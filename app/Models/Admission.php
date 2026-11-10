<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [
        'application_number',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'applying_for',
        'guardian_name',
        'guardian_email',
        'guardian_phone',
        'previous_school',
        'status',
        'review_notes',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'submitted_at' => 'datetime',
        ];
    }
}
