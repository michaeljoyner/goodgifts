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

    protected $fillable = ['title', 'description', 'body'];

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
}
