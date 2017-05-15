<?php

namespace App\Interests;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $table = 'interests';

    protected $fillable = ['interest'];

    public static function createList($interests)
    {
        return $interests->map(function($interest) {
            return static::where('interest', $interest)->firstOrCreate(['interest' => $interest]);
        });
    }
}
