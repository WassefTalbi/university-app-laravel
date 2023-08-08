<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = ['score','etudiant_id','matiere_id'];

    public function etudiant(){
        return $this->belongsTo(Etudiant::class);
    }
    public function matiere(){
        return $this->belongsTo(Matiere::class);
    }

}
