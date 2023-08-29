<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $fillable = ['ref', 'anneScolaire', 'department_id'];
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class);
    }


    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
