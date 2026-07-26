<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'icon', 'target_amount', 'current_amount', 'target_date',
    ];

    public function getProgressPercentAttribute()
    {
        if ($this->target_amount == 0) return 0;
        return round(($this->current_amount / $this->target_amount) * 100);
    }
}