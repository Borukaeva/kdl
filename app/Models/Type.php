<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'type';

    protected $fillable = [
        'id'
    ];

    public function analysisParameter()
    {
        return $this->hasMany(AnalysisParameter::class);
    }
}
