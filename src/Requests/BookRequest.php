<?php

namespace Lincms\Requests;

use Pyjhyssc\Requests\BaseRequest;

class BookRequest extends BaseRequest
{
    public array $rules = [
        'title' => 'required|unique:book',
        'author' => 'required',
        'summary' => 'required',
        'image' => 'required',
    ];
}
