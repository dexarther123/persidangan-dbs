<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usul extends Model
{
    use HasFactory;

    public function scopeRawExpression($query, $expression)
    {
        return $query->selectRaw($expression);
    }

    protected $table = 'usuls';

    protected $fillable = [
        'title','kluster_id','tarikh'
    ];

    public function kluster()
    {
        return $this->belongsTo(Kluster::class);
    }

}
