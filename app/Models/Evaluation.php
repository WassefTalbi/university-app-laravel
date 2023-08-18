<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = ['name','pourcentage','matiere_id'];

  
    public function matiere(){
        return $this->belongsTo(Matiere::class);
    }
}
