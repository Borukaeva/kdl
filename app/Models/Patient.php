<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patient';

    protected $fillable = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }

    public function surname()
    {
        $fio = explode(' ', $this->fio);
        return isset($fio[0]) ? $fio[0] : '';
    }

    public function name()
    {
        $fio = explode(' ', $this->fio);
        return isset($fio[1]) ? $fio[1] : '';
    }

    public function patronymic()
    {
        $fio = explode(' ', $this->fio);
        return isset($fio[2]) ? $fio[2] : '';
    }
}
