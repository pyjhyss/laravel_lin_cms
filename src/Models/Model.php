<?php

namespace Lincms\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }
}