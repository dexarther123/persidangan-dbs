<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UndiUsul extends Model
{
    use HasFactory;

    protected $table = 'undian_usul';

    protected $fillable = [
        'usul_id','user_id','undi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usul()
    {
        return $this->belongsTo(Usul::class, 'usul_id');
    }

}
