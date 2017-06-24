<?php

namespace App\Articles;

use App\Interests\Interest;
use App\Issues\ArticleUpdateIssue;
use App\Products\Lookup;
use App\Products\Product;
use App\Products\ProductHtml;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Symfony\Component\DomCrawler\Crawler;

class Article extends Model implements HasMediaConversions
{
    use Sluggable, HasMediaTrait;

    const DEFAULT_TITLE_IMG = '/images/defaults/article.jpg';

    protected $fillable = ['title', 'description', 'body', 'intro'];

    protected $casts = ['published' => 'boolean'];

    protected $dates = ['published_on', 'body_updated_on'];

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
            ->setManipulations(['w' => 500, 'h' => 333, 'fit' => 'crop', 'fm' => 'src'])
            ->performOnCollections('default');
        $this->addMediaConversion('web')
            ->setManipulations(['w' => 800, 'h' => 500, 'fit' => 'max', 'fm' => 'src'])
            ->performOnCollections('default');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source'   => 'title',
                'onUpdate' => $this->hasNeverBeenPublished()
            ]
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('published', true)->whereDate('published_on', '<=', Carbon::now()->format('Y-m-d'));
    }

    public function isPublished()
    {
        return $this->published && !is_null($this->published_on) && (!$this->published_on->isFuture());
    }

    protected function hasNeverBeenPublished()
    {
        return is_null($this->published_on);
    }

    public function publish($publish_date = null)
    {
        if (is_null($this->published_on) || $publish_date) {
            $this->published_on = $publish_date ? Carbon::parse($publish_date) : Carbon::now();
        }
        $this->published = true;
        $this->save();

        return $this->published;
    }

    public function retract($publish_date = null)
    {
        $this->published = false;
        $this->published_on = $publish_date;
        $this->save();

        return $this->published;
    }

    public function addImage($image)
    {
        return $this->addMedia($image)->preservingOriginal()->toCollection();
    }

    public function setTitleImage($image)
    {
        $this->removeExistingTitleImages();
        $image = $this->addImage($image);
        $image->setCustomProperty('is_title', true);
        $image->save();

        return $image;
    }

    protected function removeExistingTitleImages()
    {
        $this->getMedia()->filter(function ($image) {
            return $image->hasCustomProperty('is_title') && $image->getCustomProperty('is_title');
        })->each(function ($titleImage) {
            $titleImage->delete();
        });
    }

    public function titleImage($conversion = '')
    {
        $image = $this->getMedia()->filter(function ($image) {
            return $image->hasCustomProperty('is_title') && $image->getCustomProperty('is_title');
        })->first();

        if ($image) {
            return $image->getUrl($conversion);
        }

        return static::DEFAULT_TITLE_IMG;
    }

    public function setBody($content)
    {
        $this->body = $content;
        $this->body_updated_on = Carbon::now();
        $this->save();

        return $this->body;
    }

    public function lastUpdated()
    {
        return $this->body_updated_on ?? $this->published_on ?? $this->created_at;
    }

    public function mentionedProducts()
    {
        $crawler = new Crawler($this->body);
        $products = [];

        $crawler->filter('.amazon-product-card')->each(function ($node) use (&$products) {
            $products[] = [
                'itemid' => $node->attr('data-amzn-id'),
                'title'  => $node->filter('.amazon-product-title')->first()->text(),
                'link'   => $node->filter('a')->first()->attr('href'),
                'image'  => $node->filter('img')->first()->attr('src'),
                'price'  => $this->extractPriceFromNode($node),
            ];
        });

        return $products;
    }

    protected function extractPriceFromNode($node)
    {
        if($node->filter('.inner-price')->count()) {
            return $node->filter('.inner-price')->first()->text();
        }

        return substr($node->filter('a')->first()->text(), 14);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function attachProducts($products)
    {
        $this->products()->attach($products);
    }

    public function detachProducts($products)
    {
        $this->products()->detach($products);
    }

    public function syncMentionedProducts()
    {
        $unsyncedItemIdChunks = collect($this->mentionedProducts())->filter(function ($product) {
            return !Product::where('itemid', $product['itemid'])->first();
        })->map(function ($product) {
            return $product['itemid'];
        })->chunk(10);

        foreach ($unsyncedItemIdChunks as $chunk) {
            $lookup = app()->make(Lookup::class);

            $products = $lookup->withId(implode(',', $chunk->toArray()))->map(function ($product) {
                $product->save();

                return $product->fresh();
            });

            $this->products()->attach($products->pluck('id')->toArray());
        }
    }

    public function updateBodyWithProduct($product)
    {
        try {
            $html = $this->body;
            $crawler = new Crawler();
            $crawler->addHtmlContent(html_entity_decode($html));
            $query = '//*[@data-amzn-id="' . $product->itemid . '"]';
            $newproduct = $crawler->filterXPath($query);
            $newproduct->getNode(0)->nodeValue = $this->makeProductHtml($product->toArray());
            $newbody = $this->reformattedCrawlerHtml($crawler->html());
        } catch (\Exception $e) {
            ArticleUpdateIssue::create(['product_id' => $product->id, 'article_id' => $this->id]);
            return;
        }


        $this->body = $newbody;
        $this->save();
    }

    protected function makeProductHtml($product)
    {
        return htmlspecialchars(ProductHtml::innerFor($product));
    }

    protected function reformattedCrawlerHtml($html)
    {
        $html = html_entity_decode($html);

        return mb_substr($html, 6, -7);
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class);
    }

    public function setInterests($interests)
    {
        $this->interests()->sync(Interest::createList($interests)->pluck('id'));

        return $this->fresh()->interests;
    }

    public function hasInterest($interest)
    {
        return $this->interests->pluck('interest')->contains($interest);
    }


}
