<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'unit';

    protected $fillable = [
        'id'
    ];

    public function analysisParameter()
    {
        return $this->hasMany(AnalysisParameter::class);
    }
}
