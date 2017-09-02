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

    public function picks()
    {
        return $this->hasMany(Pick::class, 'gift_list_id');
    }

    public function topPicks()
    {
        return $this->picks->filter(function($pick) {
            return $pick->top_pick;
        })->shuffle();
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
        $suggestion_id = $suggestion instanceof Suggestion ? $suggestion->id : $suggestion;

        return Pick::create([
            'suggestion_id' => $suggestion_id,
            'gift_list_id' => $this->id,
            'top_pick' => false,
        ]);
    }

    public function makeSuggestionTopPick($suggestion_id)
    {
        return tap($this->getSuggestedPick($suggestion_id), function($pick) {
            $pick->update(['top_pick' => true]);
        });
    }

    protected function getSuggestedPick($suggestion_id)
    {
        return $this->picks()->where('suggestion_id', $suggestion_id)->first();
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
        $this->notify(new GiftListPublished($this->present(GiftListNotificationPresenter::class)));
        $this->sent = true;
        $this->save();
    }
}
