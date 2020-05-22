<?php


namespace App\Enjoythetrip\Interfaces; /* Lecture 13 */


/* Lecture 13 */
interface FrontendRepositoryInterface   {

    /* Lecture 13 */
    public function getObjectsForMainPage();

    /* Lecture 15 */
    public function getObject($id);
}


