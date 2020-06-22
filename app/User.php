<?php


namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $patronymic
 * @property string $surname
 * @property string $email
 * @property string $phone
 * @property bool $active
 * @property int $code
 * @property int $attempt
 * @property int $time
 */
class User extends Authenticatable
{
    use Notifiable;
    use Enjoythetrip\Presenters\UserPresenter;

    public static $roles = [];


    protected $fillable = [
        'name', 'email', 'password', 'surname', 'patronymic', 'phone', 'code', 'time', 'active',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'time' => 'datetime',

    ];


    public function objects()
    {
        return $this->morphedByMany('App\TouristObject', 'likeable');
    }

    public function getOwnerObjects()
    {
        return $this->hasMany('App\TouristObject', 'user_id')->get();
    }

    public function tobjects()
    {
        return $this->hasMany('App\TouristObject', 'user_id');
    }

    public function larticles()
    {
        return $this->morphedByMany('App\Article', 'likeable');
    }


    public function photos()
    {
        return $this->morphMany('App\Photo', 'photoable');
    }


    public function comments()
    {
        return $this->hasMany('App\Comment');
    }


    public function unotifications()
    {
        return $this->hasMany('App\Notification');
    }


    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }


    public function hasRole(array $roles)
    {

        foreach ($roles as $role) {

            if (isset(self::$roles[$role])) {
                if (self::$roles[$role]) return true;

            } else {
                self::$roles[$role] = $this->roles()->where('name', $role)->exists();
                if (self::$roles[$role]) return true;
            }

        }


        return false;

    }

    public function activateUser(): void
    {
        $this->update([
            'active' => 1,
            'code' => null,
        ]);
    }

    public function isActive(): bool
    {
        return $this->active === 1;
    }

    public function codeIsCorrect($code): bool
    {
        return $this->code == $code;
    }

    public function addAttempt()
    {
        if ($this->attempt < 5 && $this->time > Carbon::now()) {
            $attempt = $this->attempt++;
            $this->update([
                'attempt' => $attempt,
            ]);

        }
        return $this->attempt;
    }

    public function updateCode()
    {
        $newCode = rand(999, 9999);
        $sendCode = new SendCode();
        $smsResponse = $sendCode->sendCode($this->phone, $newCode);

        if ($smsResponse->code !== "100") {
            return redirect()->back()->with('message', 'Что то пошло не так, попробуйте, пожалуйста, еще раз');
        } else {
            $this->update([
                'code' => $newCode,
                'time' => Carbon::now()->addSeconds(30),
            ]);
            $this->attempt = 1;
            $this->save();
        }
    }

    public function hasOwnerRole(): bool
    {
    foreach ($this->roles as $role) {
        if ($role->name == 'owner')
            return true;
    }
    return false;
    }
}

