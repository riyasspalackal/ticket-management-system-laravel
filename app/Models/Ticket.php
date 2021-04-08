<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventRegistration;


class Ticket extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    protected $dateFormat = 'dd/mm/yyyy';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'evt_id',
        'ticket_type',
        'capacity',
        'price',
        'available_ticket',
    ];
    

    public function eventRegistration()
    {
        return $this->belongsTo(EventRegistration::class);
    }
}
