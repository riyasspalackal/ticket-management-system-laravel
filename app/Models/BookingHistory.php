<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventRegistration;


class BookingHistory extends Model
{
    protected $table = 'booking-histories';
    protected $primaryKey = 'id';
    protected $dateFormat = 'dd/mm/yyyy';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'evt_id',
        'customer_name',
        'customer_email',
        'phone_number',
        'ticket_history',
    ];
    
     public function eventRegistration()
    {
        return $this->belongsTo(EventRegistration::class);
    }
}
