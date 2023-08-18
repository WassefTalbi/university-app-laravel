<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'name','niveau','semestre'];
   

    public function modules() {
        return $this->hasMany(Module::class);
    }
}
