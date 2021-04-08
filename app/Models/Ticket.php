<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    } 

    public function eventRegistration()
    {
        return $this->belongsTo(EventRegistration::class);
    }
}
