<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Complex extends Model
{
    use HasFactory;

    protected $table = 'complex';

    protected $fillable = [
        'id'
    ];

    /**
     * Получить дочерний комплекс.
     */
    public function complexes()
    {
        return $this->hasMany(Complex::class, 'parent_id');
    }

    /**
     * Получить все дочерние комплексы.
     */
    public function childComplexes()
    {
        return $this->hasMany(Complex::class, 'parent_id')
            ->with('complexes');
    }

    /**
     * Метод получения списка привязанных анализов
     */
    public function analysisList()
    {
        return $this->belongsToMany(Analysis::class, 'complex_analysis', 'complexes_id', 'analyzes_id')
            ->withTimestamps();
    }
}
