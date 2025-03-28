<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'slot_id',
        'payment_method',
        'status',
    ];

    public function slot()
    {
        return $this->belongsTo(TimeSlot::class, 'slot_id');
    }
}
