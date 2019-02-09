<?php

namespace LaravelVueJs\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedSocialAccount extends Model
{

    protected $fillable = [
        'provider_id',
        'provider_name',
        'user_id',
        'data',
    ];


    protected $casts = [
        'data' => 'json',
    ];

    /**Get linked user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
