<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Analysis extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'analysis';

    protected $fillable = [
        'id'
    ];

    public function parameters()
    {
        return $this->hasMany(AnalysisParameter::class);
    }

    public function biomaterials()
    {
        return $this->hasMany(AnalysisBiomaterial::class);
    }

    /**
     * Метод получения списка привязанных комплектов
     */
    public function complexList()
    {
        return $this->belongsToMany(Complex::class, 'complex_analysis', 'analyzes_id', 'complexes_id')->withTimestamps();
    }

    /**
     * Метод получения списка привязанных комплектов
     */
    public function hasComplex($complex_id)
    {
        foreach ($this->complexList as $complex){
            if ($complex->id == $complex_id) return true;
        }
        return false;
    }

    public function result()
    {
        return $this->hasMany(Result::class);
    }
}
