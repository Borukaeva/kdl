<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $table = 'partner';

    protected $fillable = [
        'id'
    ];

    public function contract()
    {
        return $this->hasMany(Contract::class);
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }
}
