<?php

namespace App\Traits;

trait StandardizesEmails
{
    /**
     * Mutador para el campo 'email'.
     * Convierte el correo electrónico a minúsculas antes de guardarlo.
     *
     * @param  string  $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
}