<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $fillable = ['ref','name','credit','coefficient','nature','degre_id'];

   
    public function matieres(){
        return $this->hasMany(Matiere::class);
    }
    
    public function degre(){
        return $this->belongsTo(Degre::class);
    }
}
