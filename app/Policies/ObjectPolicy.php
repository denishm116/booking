<?php


namespace App\Policies; /* Lecture 43 */

use App\{User,TouristObject}; /* Lecture 43 */
use Illuminate\Auth\Access\HandlesAuthorization; /* Lecture 43 */


/* Lecture 43 */
class ObjectPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function checkOwner(User $user, TouristObject $object)
    {
//        dd($user->id);

        if($user->hasRole(['owner'])) {

            return $user->id === $object->user->id;
        }
        elseif($user->hasRole(['admin'])) {
            return true;
        }
        else {
            return $user->id === $object->user->id;
        }
    }




}

