<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'birth_date',
        'notes',
        'active'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'active' => 'boolean'
    ];

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
