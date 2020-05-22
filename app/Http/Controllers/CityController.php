<?php
/*
|--------------------------------------------------------------------------
| app/Http/Controllers/CityController.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;
/* Lecture 37 */


use App\City;
use Illuminate\Http\Request; /* Lecture 37 */

use App\Enjoythetrip\Gateways\BackendGateway; /* Lecture 37 */

use App\Enjoythetrip\Interfaces\BackendRepositoryInterface; /* Lecture 37 */

/* Lecture 37 */

class CityController extends Controller
{

    /* Lecture 37 */
    public function __construct(BackendGateway $backendGateway, BackendRepositoryInterface $backendRepository)
    {
        $this->middleware('CheckAdmin');
        $this->bG = $backendGateway;
        $this->bR = $backendRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.cities.index', ['cities' => $this->bR->getCities()]); /* Lecture 37 */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.cities.create'); /* Lecture 37 */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->bG->createCity($request); /* Lecture 37 */
        return redirect()->route('cities.index'); /* Lecture 37 */
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backend.cities.edit', ['city' => $this->bR->getCity($id)]); /* Lecture 37 */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->bG->updateCity($request, $id); /* Lecture 37 */
        return redirect()->route('cities.index'); /* Lecture 37 */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->bR->deleteCity($id); /* Lecture 37 */
        return redirect()->route('cities.index'); /* Lecture 37 */
    }

    public function types($type)
    {


//        $cit = Type::with(['objects.rooms.reservations', 'objects.rooms.photos','objects.rooms.object.photos', 'objects.rooms.rservices', 'objects.rooms.object.additionals', 'objects.rooms.object.types', 'objects.rooms.object.infrastructures'])->where('alias',$type)->first();


        $cities = City::with(['rooms.reservations', 'rooms.photos', 'rooms.object.photos', 'rooms.rservices', 'rooms.object.additionals', 'rooms.object.types', 'rooms.object.infrastructures'])->get();



//        return view('frontend.roomsearch',['city'=>$city]);


dd($cities);
    }
}
