<?php

namespace App\GiftLists;

use App\Articles\Article;
use App\Recommendations\Request;
use App\Suggestions\Suggestion;
use Hemp\Presenter\Presentable;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class GiftList extends Model
{
    use Presentable;

    protected $table = 'gift_lists';

    protected $fillable = ['writeup'];

    protected $casts = ['approved' => 'boolean'];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    public function suggestions()
    {
        return $this->belongsToMany(Suggestion::class);
    }

    public function suggestionList()
    {
        return $this->suggestions()->with('product')->get();
    }

    public function addSuggestion($suggestion)
    {
        $id = $suggestion instanceof Suggestion ? $suggestion->id : $suggestion;

        return $this->suggestions()->attach($id);
    }

    public function removeSuggestion($suggestion)
    {
        $id = $suggestion instanceof Suggestion ? $suggestion->id : $suggestion;

        return $this->suggestions()->detach($id);
    }

    public function defaultSuggestions()
    {
        return Suggestion::forTags($this->request->interestsArray());
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function addArticle($article)
    {
        $id = $article instanceof Article ? $article->id : $article;

        $this->articles()->attach($id);
    }

    public function removeArticle($article)
    {
        $id = $article instanceof Article ? $article->id : $article;

        $this->articles()->detach($id);
    }

    public function approve()
    {
        $this->slug = Uuid::uuid4()->toString();
        $this->approved = true;
        $this->save();
    }

    public static function withSlug($slug)
    {
        return static::where('slug', $slug)->firstOrFail();
    }
}
