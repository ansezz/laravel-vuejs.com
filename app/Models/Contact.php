<?php

namespace LaravelVueJs\Models;

use Illuminate\Database\Eloquent\Model;
class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
    ];


}
