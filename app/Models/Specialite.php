<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'name'];
   

    public function degres() {
        return $this->hasMany(Degre::class);
    }

}
