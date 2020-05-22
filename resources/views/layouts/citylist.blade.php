@foreach($cities as $city )


    <div class="col-xl-3 col-6">
        <a class="town"
           href="{{ route('city',['city'=>$city->alias ?? false]) }}">{{$city->name}}</a>

    </div>

@endforeach
