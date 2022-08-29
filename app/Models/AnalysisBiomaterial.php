<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnalysisBiomaterial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'analysis_biomaterial';

    protected $fillable = [
        'id'
    ];

    public function analysis()
    {
        return $this->belongsTo(Analysis::class);
    }

    public function biomaterial()
    {
        return $this->belongsTo(Biomaterial::class, 'biomaterials_id', 'id')
            ->withDefault();
    }

    public function testTube()
    {
        return $this->belongsTo(TestTube::class, 'test_tubes_id', 'id')
            ->withDefault();
    }

    public function price()
    {
        return $this->belongsToMany(Price::class, 'analysis_biomaterial_price', 'analysis_biomaterial_id', 'price_id')
            ->withPivot('price1', 'price2');
    }

    public function result()
    {
        return $this->hasMany(Result::class);
    }
}
