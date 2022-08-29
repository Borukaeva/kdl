<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplexAnalysis extends Model
{
    use HasFactory;

    protected $table = 'complex_analysis';

    protected $fillable = [
        'id'
    ];
}
