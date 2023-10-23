<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kluster extends Model
{
    use HasFactory;

    protected $table = 'klusters';

    protected $fillable = [
        'nama_kluster'
    ];

    public function usuls()
    {
        return $this->hasMany(Usul::class);
    }
}
