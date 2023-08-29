<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degre extends Model
{
    use HasFactory;
    protected $fillable = ['niveau', 'semestre','specialite_id'];

    
   
    public function speciality(){
        return $this->belongsTo(Specialite::class);
    }

    public function modules() {
        return $this->hasMany(Module::class);
    }

}
