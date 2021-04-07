<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\EventLineup;


class EventRegistration extends Authenticatable implements JWTSubject
{
    protected $table = 'event_registrations';
    protected $primaryKey = 'id';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'evt_name',
        'evt_desc',
        'location',
        'golden_ticket',
        'platinum_ticket',
        'silver_ticket'
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


    public function eventLineup()
    {
        return $this->hasMany(EventLineup::class,'evt_id');
    }
    

    public static function boot() {
        parent::boot();
        self::deleting(function($eventRegistration) { // before delete() method call this
             $eventRegistration->eventLineup()->each(function($eventLineup) {
                $eventLineup->delete(); // <-- direct deletion
             });
             
            
        });
    }
    
}
