<?php
/*
|--------------------------------------------------------------------------
| app/Policies/ArticlePolicy.php **** Copyright netprogs.pl * avaiable only at Udemy.com * further distribution is prohibited  ****
|--------------------------------------------------------------------------
*/

namespace App\Policies; /* Lecture 45 */

use App\User; /* Lecture 45 */
use Illuminate\Auth\Access\HandlesAuthorization; /* Lecture 45 */


/* Lecture 45 */
class ArticlePolicy
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

    /* Lecture 45 */
    public function checkOwner(User $user, \App\Article $article)
    {
        return $user->id === $article->user_id;
    }
}

