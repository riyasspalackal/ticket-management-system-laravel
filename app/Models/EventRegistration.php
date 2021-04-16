<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\EventLineup;
use App\Models\Ticket;


class EventRegistration extends  Model
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
    ];


    public function eventLineup()
    {
        return $this->hasMany(EventLineup::class,'evt_id');
    }
    public function ticket()
    {
        return $this->hasMany(Ticket::class,'evt_id');
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
