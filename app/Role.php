<?php
/*
|--------------------------------------------------------------------------
| app/Role.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

namespace App; /* Lecture 27 */

use Illuminate\Database\Eloquent\Model; /* Lecture 27 */

/* Lecture 27 */
class Role extends Model
{

    public $guarded = []; /* Lecture 36 */
    public $timestamps = false; /* Lecture 36 */


    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}

