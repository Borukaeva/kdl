<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';

    protected $fillable = [
        'id'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class)->withDefault();
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class)->withDefault();
    }

    public function result()
    {
        return $this->hasMany(Result::class, 'ticket_id', 'id');
    }

    public function results()
    {
        $ab_collection = collect([]);
        if (count($this->result)) {
            foreach ($this->result as $result) {
                $r_collection = collect(['id' => $result->analysis_biomaterial_id, 'result' => $result]);
                $ab_collection->push($r_collection);
            }
        }
        return $ab_collection->groupBy("id");
    }
}
