<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestTube extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'test_tube';

    protected $fillable = [
        'id'
    ];

    public function analysis()
    {
        return $this->hasMany(AnalysisBiomaterial::class, 'test_tubes_id', 'id');
    }
}
