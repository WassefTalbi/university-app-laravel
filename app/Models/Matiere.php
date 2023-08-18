<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'photo_url','credit','charge_total','coefficient','module_id'];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function classrooms() {
        return $this->belongsToMany(Classroom::class)->using(ClassroomMatiere::class);
    }
    public function module(){
        return $this->belongsTo(Module::class);
    }
}
