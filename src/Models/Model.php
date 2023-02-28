<?php

namespace Lincms\Models;

use DateTimeInterface;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }
}
