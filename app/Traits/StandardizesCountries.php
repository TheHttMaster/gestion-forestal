<?php

namespace App\Traits;

trait StandardizesCountries
{
    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = strtoupper($value);
    }
}