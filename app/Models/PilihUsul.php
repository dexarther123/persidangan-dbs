<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihUsul extends Model
{
    protected $table = 'pilih_unsuls';

    protected $fillable = [
        'adbs_id','selected_usuls',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
