<?php

//Route::get('mailable', function () {
////    $invoice = App\Gue::find(1);
//$reservation = App\Reservation::find(179);
//$city = App\City::find(10);
//$owner = App\User::find(53);
//$object = App\TouristObject::find(36);
//    $addres = App\Address::find(36);
//    $user = App\User::find(54);
//    $room = App\Room::find(66);
//    return new App\Mail\TutorialMail($user);
//});

Route::get('/', 'FrontendController@index')->name('home');
Route::get('object/{id}', 'FrontendController@object')->name('object');
Route::post('roomsearch', 'FrontendController@roomsearch')->name('roomSearch');
Route::get('room/{id}', 'FrontendController@room')->name('room');
Route::get('article/{id}', 'FrontendController@article')->name('article');
Route::get('person/{id}', 'FrontendController@person')->name('person');

//Route::post('/favourites/{favourites}','FrontendController@favourites')->name('favourites');

//Route::post('/favourites','FrontendController@favouritesPost');

Route::get('/searchCities', 'FrontendController@searchCities');
Route::get('/ajaxGetRoomReservations/{id}', 'FrontendController@ajaxGetRoomReservations');

Route::get('/like/{likeable_id}', 'FrontendController@like')->name('like');
Route::get('/unlike/{likeable_id}', 'FrontendController@unlike')->name('unlike');

Route::post('/addComment/{commentable_id}', 'FrontendController@addComment')->name('addComment');
Route::post('/makeReservation/{room_id}/{city_id}', 'FrontendController@makeReservation')->name('makeReservation');




Route::get('/guest_agreement', 'FrontendController@guest_agreement')->name('guest_agreement');
Route::get('/landlord_agreement', 'FrontendController@landlord_agreement')->name('landlord_agreement');
Route::get('/confidential_policy', 'FrontendController@confidential_policy')->name('confidential_policy');
Route::get('/contacts', 'FrontendController@contacts')->name('contacts');
Route::get('/forowners', 'FrontendController@forowners')->name('forowners');

Route::get('/verify', 'VerifyController@getVerify')->name('getVerify');
Route::post('/verify', 'VerifyController@postVerify')->name('verify');
Route::get('/verify/newCode', 'VerifyController@requestNewCode')->name('requestNewCode');
//Route::get('/sendmail', 'SendMail@sendMail')->name('sendmail');
//Route::get('/sendmailpicture', 'SendMail@sendMailPicture')->name('sendmailpicture');


//Переменные, передаваемые в JavaScript
Route::get('/additionals', 'FrontendController@additionals');
Route::get('/rservices', 'FrontendController@rservices');
Route::get('/infrastructures', 'FrontendController@infrastructures');
Route::get('/types', 'FrontendController@types');
Route::get('/distances', 'FrontendController@distances');
Route::get('/sortprices', 'FrontendController@sortprices');
Route::get('/getCoords/{id}', 'FrontendController@getCoords');
Route::post('/putCoords', 'FrontendController@putCoords');
Route::get('/getTypeAlias', 'FrontendController@getTypeAlias');
Route::get('/getCityAlias', 'FrontendController@getCityAlias');
Route::get('/getRoomCity/{id}', 'FrontendController@getRoomCity');
Route::get('/getObjectCity/{id}', 'FrontendController@getObjectCity');


Route::get('/ownerdata', 'FrontendController@ownerdata')->name('ownerdata');
Route::get('/ownerafterpay', 'FrontendController@ownerafterpay')->name('ownerafterpay');
Route::get('/paymenterror/{reason}/{iniciator}', 'FrontendController@paymenterror')->name('paymenterror');


Route::get('/sendMailToGuestRepeat/{id}', 'BackendController@sendMailToGuestRepeat')->name('sendMailToGuestRepeat');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    //for json mobile
    Route::get('/getNotifications', 'BackendController@getNotifications'); /*  53 */
    Route::post('/setReadNotifications', 'BackendController@setReadNotifications'); /* 53 */

    Route::get('/', 'BackendController@index')->name('adminHome');
//    Route::get('/index2', 'BackendController@index2')->name('adminHome2');
//    Route::get('/adminpage', 'BackendController@adminpage')->name('adminpage');

    Route::group(['prefix' => 'admin'], function () {
        Route::get('', 'UserController@index')->name('index');
        Route::get('/adduser/{id?}', 'UserController@addUserForm')->name('addUserForm');
        Route::post('/adduser/{id?}', 'UserController@addUser')->name('addUser');
        Route::get('/showuser/{id}', 'UserController@show')->name('showUser');
        Route::get('/removeUser/{id?}', 'UserController@removeUser')->name('deleteUser');
        Route::post('/activateuser/{id}', 'UserController@activateUser')->name('activateUser');
    });

    Route::group(['prefix' => 'reservation'], function () {
        Route::get('', 'ReservationController@reservationIndex')->name('reservationIndex');
        Route::get('/addReservation/{id?}', 'ReservationController@addReservationForm')->name('addReservationForm');
        Route::post('/addReservation/{id?}', 'ReservationController@create')->name('addReservation');
        Route::get('/showReservation/{id}', 'ReservationController@show')->name('showReservation');
        Route::get('/removeReservation/{id?}', 'ReservationController@removeReservation')->name('removeReservation');
        Route::get('/removeConfirmation/{id}', 'BackendController@removeConfirmation')->name('removeConfirmation');
        Route::get('/removeConfirmation/{id}', 'BackendController@removeConfirmation')->name('removeConfirmation');
        Route::get('/returnPayment/{id}', 'ReservationController@returnPayment')->name('returnPayment');
    });

    Route::group(['prefix' => 'objects'], function () {
        Route::get('', 'ObjectController@index')->name('admin.objects.index');
        Route::get('/moderate/{id?}', 'ObjectController@moderate')->name('admin.objects.moderate');
        Route::get('/unmoderate/{id?}', 'ObjectController@unModerate')->name('admin.objects.unmoderate');
    });

    Route::group(['prefix' => 'ajax'], function () {
        Route::get('/getUser/{id?}', 'ReservationController@getUser');
        Route::get('/getObject/{id?}', 'ReservationController@getObject');
        Route::get('/getCity/{id?}', 'ReservationController@getCity');
        Route::get('/reservations', 'ReservationController@getReservationsAjax');
        Route::get('/objects', 'ReservationController@getobjectsAjax');
        Route::get('/objects/rooms/{id}', 'ObjectController@removeRoom');
        Route::get('/objects/{id}', 'ObjectController@removeObject');


    });


    Route::get(trans('routes.myobjects'), 'BackendController@myobjects')->name('myObjects');
    Route::match(['GET', 'POST'], trans('routes.saveobject') . '/{id?}', 'BackendController@saveObject')->name('saveObject');
    Route::match(['GET', 'POST'], trans('routes.profile'), 'BackendController@profile')->name('profile');
    Route::get('/deletePhoto/{id}', 'BackendController@deletePhoto')->name('deletePhoto');
    Route::get('/mainPhoto/{id}', 'BackendController@mainPhoto')->name('mainPhoto');
    Route::match(['GET', 'POST'], trans('routes.saveroom') . '/{id?}', 'BackendController@saveRoom')->name('saveRoom');
    Route::get('deleteroom/{id}', 'BackendController@deleteRoom')->name('deleteRoom');
    Route::get('/deleteArticle/{id}', 'BackendController@deleteArticle')->name('deleteArticle');
    Route::post('/saveArticle/{id?}', 'BackendController@saveArticle')->name('saveArticle');
    Route::get('/ajaxGetReservationData', 'BackendController@ajaxGetReservationData');
    Route::get('/ajaxSetReadNotification', 'BackendController@ajaxSetReadNotification');
    Route::get('/ajaxGetNotShownNotifications', 'BackendController@ajaxGetNotShownNotifications');
    Route::get('/ajaxSetShownNotifications', 'BackendController@ajaxSetShownNotifications');
    Route::get('/confirmReservation/{id}', 'BackendController@confirmReservation')->name('confirmReservation');
    Route::get('/deleteReservation/{id}', 'BackendController@deleteReservation')->name('deleteReservation');
    Route::resource('cities', 'CityController');
    Route::get('deleteobject/{id}', 'BackendController@deleteObject')->name('deleteObject');

});


Auth::routes();


Route::get('/{city}', 'FrontendController@city')->name('city');
//Route::get('/{city}/{type}', 'FrontendController@objectTypes')->name('cityOne');
Route::get('/{city}/{type}', 'FrontendController@typesAvailable')->name('type');

Route::get('/{city}/{condition}', 'FrontendController@conditionsAll')->name('cityConditions');

Route::get('/{city}/{type}/{condition}', 'FrontendController@cityConditions')->name('typeConditions');

Route::group(['prefix' => 'favourites'], function () {
    Route::get('favourite/{id}', 'FrontendController@favourites')->name('favourites.favourite');
});
//Route::get('/home', 'HomeController@index')->name('home');  /* Lecture 7 */
Route::group(['prefix' => 'ajax', /*'middleware' => 'auth'*/], function () {
    Route::get('/changeRating/{objectId}/{rating}', 'FrontendController@changeRating');
    Route::get('/price/{room_id}/{dayIn}/{dayOut}', 'FrontendController@price');
//    Route::post('/setRating', 'FrontendController@setRating');
});


