<?php

namespace App\GiftLists;

use App\Suggestions\Suggestion;
use Illuminate\Database\Eloquent\Model;

class Pick extends Model
{
    protected $table = 'gift_list_suggestion';

    protected $fillable = ['suggestion_id', 'gift_list_id', 'top_pick'];

    protected $casts = ['top_pick' => 'boolean'];

    public function suggestion()
    {
        return $this->belongsTo(Suggestion::class, 'suggestion_id');
    }

    public function toJsonableArray()
    {
        $this->load('suggestion.product');

        return [
            'id'            => $this->id,
            'list_id'       => $this->gift_list_id,
            'suggestion_id' => $this->suggestion_id,
            'top_pick'      => $this->top_pick,
            'product_name'  => $this->suggestion->product->title,
            'product_image' => $this->suggestion->product->image,
            'price'         => $this->suggestion->product->price,
            'what'          => $this->suggestion->what,
            'why'           => $this->suggestion->why,
        ];
    }
}
