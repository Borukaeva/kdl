<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnalysisParameter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'analysis_parameter';

    protected $fillable = [
        'id'
    ];

    public function analysis()
    {
        return $this->belongsTo(Analysis::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class)->withDefault();
    }

    public function type()
    {
        return $this->belongsTo(Type::class)->withDefault();
    }

    public function result()
    {
        return $this->hasMany(Result::class);
    }
}
