<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Subscriber extends Model
{
    protected $fillable = [
        'topic',
        'url'
    ];
}