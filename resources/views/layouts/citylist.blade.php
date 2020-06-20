

@foreach($cities as $city )
{{--    <div class="col-sm-6 col-xl-2">--}}
{{----}}
    <div class="col-5 col-xl-2">
        <a class="town"
           href="{{ route('city',['city'=>$city->alias ?? false]) }}">{{$city->name}}</a>


    </div>

@endforeach
