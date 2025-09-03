<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\StandardizesEmails;
use App\Traits\StandardizesCities;
use App\Traits\StandardizesCountries;

class Provider extends Model
{
    use HasFactory, SoftDeletes, StandardizesEmails, StandardizesCities, StandardizesCountries;

    protected $fillable = [
        'name',
        'contact_name',
        'email',
        'address',
        'city',
        'country',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('contact_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
    }
}