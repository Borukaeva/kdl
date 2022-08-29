<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisBiomaterialPrice extends Model
{
    use HasFactory;

    protected $table = 'analysis_biomaterial_price';

    protected $fillable = [
        'id'
    ];
}
