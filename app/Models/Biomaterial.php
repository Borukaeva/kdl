<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Biomaterial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'biomaterial';

    protected $fillable = [
        'id'
    ];

    public function analysis()
    {
        return $this->hasMany(AnalysisBiomaterial::class, 'biomaterials_id', 'id');
    }
}
