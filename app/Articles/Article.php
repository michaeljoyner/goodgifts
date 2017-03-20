<?php

namespace App\Articles;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Article extends Model implements HasMediaConversions
{
    use Sluggable, HasMediaTrait;

    const DEFAULT_TITLE_IMG = '/images/defaults/article.jpg';

    protected $fillable = ['title', 'description', 'body', 'intro'];

    protected $casts = ['published' => 'boolean'];

    protected $dates = ['published_on'];

    public function registerMediaConversions()
    {
        $this->addMediaConversion('web')
            ->setManipulations(['w' => 800, 'h' => 500, 'fit' => 'max', 'fm' => 'src'])
            ->performOnCollections('default');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
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
        return $this->published && !is_null($this->published_on) && (! $this->published_on->isFuture());
    }

    protected function hasNeverBeenPublished()
    {
        return is_null($this->published_on);
    }

    public function publish($publish_date = null)
    {
        if(is_null($this->published_on) || $publish_date) {
            $this->published_on = $publish_date ? Carbon::parse($publish_date) : Carbon::now();
        }
        $this->published = true;
        $this->save();

        return $this->published;
    }

    public function retract()
    {
        $this->published = false;
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
        $this->getMedia()->filter(function($image) {
            return $image->hasCustomProperty('is_title') && $image->getCustomProperty('is_title');
        })->each(function($titleImage) {
            $titleImage->delete();
        });
    }

    public function titleImage($conversion = '')
    {
        $image = $this->getMedia()->filter(function($image) {
            return $image->hasCustomProperty('is_title') && $image->getCustomProperty('is_title');
        })->first();

        if($image) {
            return $image->getUrl($conversion);
        }

        return static::DEFAULT_TITLE_IMG;
    }
}
