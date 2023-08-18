<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $fillable = ['ref','name','credit','coefficient','nature','specialite_id'];

   
    public function matiere(){
        return $this->hasMany(Matiere::class);
    }
    public function specialite(){
        return $this->belongsTo(Specialite::class);
    }
}
