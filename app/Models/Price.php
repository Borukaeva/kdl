<?php

namespace App\Models;

use App\Models\AnalysisBiomaterialPricePivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnalysisBiomaterial;

class Price extends Model
{
    use HasFactory;

    protected $table = 'price';

    protected $fillable = [
        'id'
    ];

    public function analysisBiomaterial()
    {
        return $this->belongsToMany(AnalysisBiomaterial::class, 'analysis_biomaterial_price', 'price_id', 'analysis_biomaterial_id')
            ->withPivot(['price1', 'price2']);
    }

    /**
     * @param AnalysisBiomaterial $analysis_biomaterial
     * @return mixed
     */
    public function analysisBiomaterialPivot(AnalysisBiomaterial $analysis_biomaterial)
    {
        return $this->belongsToMany(AnalysisBiomaterial::class, 'analysis_biomaterial_price', 'price_id', 'analysis_biomaterial_id')
            ->withPivot(['price1', 'price2'])
            ->where('analysis_biomaterial_id', $analysis_biomaterial->id)
            ->first()->pivot;
    }

    public function contract()
    {
        return $this->hasMany(Contract::class, 'price_id', 'id');
    }
}
