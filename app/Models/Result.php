<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table = 'result';

    protected $fillable = [
        'id'
    ];

    public function analysis()
    {
        return $this->belongsTo(Analysis::class, 'analysis_id', 'id')
            ->withDefault();
    }

    public function analysisBiomaterial()
    {
        return $this->belongsTo(AnalysisBiomaterial::class, 'analysis_biomaterial_id', 'id')
            ->withDefault();
    }

    public function analysisParameter()
    {
        return $this->belongsTo(AnalysisParameter::class, 'analysis_parameter_id', 'id')
            ->withDefault();
    }

    public function laborant()
    {
        return $this->belongsTo(User::class, 'laborant_id', 'id')
            ->withDefault();
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id')
            ->withDefault();
    }
}
