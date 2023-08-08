<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function note()
    {
        return $this->hasOne(Note::class);
    }
}
 