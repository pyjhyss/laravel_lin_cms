<?php

namespace Lincms\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'book';
}
