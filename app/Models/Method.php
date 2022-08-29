<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Method extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'method';

    protected $fillable = [
        'id'
    ];

    public function analysisParameter()
    {
        return $this->belongsTo(AnalysisParameter::class);
    }
}
