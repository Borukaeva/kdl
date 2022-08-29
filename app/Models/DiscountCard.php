<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCard extends Model
{
    use HasFactory;

    protected $table = 'discount_card';

    protected $fillable = [
        'id'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function increasing_amount(float $sum)
    {
        $this->sum += $sum;
        $this->calculation_of_discount();
    }

    public function decreasing_amount(float $sum)
    {
        $this->sum -= $sum;
        if ($this->sum < 0) $this->sum = 0;
        $this->calculation_of_discount();
    }

    public function calculation_of_discount()
    {
        $this->percent = floor($this->sum / 10000) * 10;
        $this->save();
    }
}
