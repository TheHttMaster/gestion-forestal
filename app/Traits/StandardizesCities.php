<?php

namespace App\Traits;

trait StandardizesCities
{
    public function setCityAttribute($value)
    {
        $this->attributes['city'] = strtoupper($value);
    }
}