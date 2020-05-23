<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

use App\TouristObject;
use App\User;
use App\City;
class Reservation extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    //protected $fillable = ['name'];
    const STATUS_CONFIRMED = 1;
    const STATUS_NOT_CONFIRMED = 0;


    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function room()
    {
        return $this->belongsTo('App\Room');
    }

    public function getUsername()
    {
        return $this->user()->first()->fullPayName;
    }

    public function getUser()
    {
        return $this->user()->first();
    }

    public function getOwner()
    {
        $object = TouristObject::with('user')->where('id', $this->room()->first()->object_id)->first();
        $owner = User::findOrFail($object->user_id);
        return $owner;
    }

    public function getObject()
    {
        $object = TouristObject::with('user')->where('id', $this->room()->first()->object_id)->first();

        return $object;
    }

    public function isPaid(): bool
    {
        return $this->paid;
    }

    public function isConfirmed(): bool
    {
        return $this->status;
    }

    public function getCity()
    {

        return City::findOrFail($this->city_id);
    }

}

