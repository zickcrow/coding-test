<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'education_institution_id',
        'birthday',
        'experience',
        'last_position_id',
        'applied_position_id',
        'email',
        'phone',
        'resume',
    ];

    protected $with = ['skills', 'lastPosition', 'appliedPosition', 'educationInstitution'];

    public function lastPosition()
    {
        return $this->belongsTo(Position::class);
    }

    public function appliedPosition()
    {
        return $this->belongsTo(Position::class);
    }

    public function educationInstitution()
    {
        return $this->belongsTo(EducationInstitution::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }
}
