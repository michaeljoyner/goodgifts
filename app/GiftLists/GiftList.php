<?php

namespace App\GiftLists;

use App\Articles\Article;
use App\Events\GiftListCreated;
use App\Notifications\GiftListPublished;
use App\Recommendations\Request;
use App\Suggestions\Suggestion;
use Carbon\Carbon;
use Hemp\Presenter\Presentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class GiftList extends Model
{
    use Presentable, Notifiable;

    protected $table = 'gift_lists';

    protected $fillable = ['writeup', 'approved', 'sent'];

    protected $casts = ['approved' => 'boolean', 'sent' => 'boolean'];

    protected $dispatchesEvents = [
        'created' => GiftListCreated::class
    ];

    public function routeNotificationForMail()
    {
        return $this->request->email;
    }

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

    public function scopeOutstanding($query)
    {
        return $query->where('sent', 0)->whereHas('request', function ($inner_query) {
            $inner_query->where('birthday', '>=', Carbon::today());
        });
    }

    public function scopeUrgent($query)
    {
        return $query->outstanding()->whereHas('request', function ($inner_query) {
            $inner_query->where('birthday', '<', Carbon::today()->addDays(27));
        });
    }

    public function scopeUpcoming($query)
    {
        return $query->outstanding()->whereHas('request', function ($inner_query) {
            $inner_query->where('birthday', '<', Carbon::today()->addDays(55))
                ->where('birthday', '>=', Carbon::today()->addDays(27));
        });
    }

    public function scopeDue($query)
    {
        return $query
            ->outstanding()
            ->where('approved', 1)
            ->whereHas('request', function ($inner_query) {
                $inner_query->where('birthday', '<', Carbon::today()->addDays(21));
            });
    }

    public function sendNotification()
    {
        $this->notify(new GiftListPublished($this));
        $this->sent = true;
        $this->save();
    }
}
