<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $fillable = ['name', 'grade_level', 'class_teacher_id'];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
