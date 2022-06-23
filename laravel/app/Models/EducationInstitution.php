<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationInstitution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
