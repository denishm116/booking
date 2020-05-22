<?php


namespace App; /* Lecture 49 */

use Illuminate\Database\Eloquent\Model; /* Lecture 49 */


/* Lecture 49 */
class Notification extends Model
{
    public $timestamps = false; /* Lecture 50 */
    public $guarded = []; /* Lecture 54 */
}

