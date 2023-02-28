<?php

namespace Lincms\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
