<header>


    <div class="pt-4 pb-4 header-background img-fluid header-catalog"

         @isset($rooms)
         style="background: #1b4b72 url(/images/city/{{$rooms->first()->object->city->alias ?? 'oteli'}}.jpg)"
         @endisset

         id="background">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-xl-12 col-12 pt-xl-4 pb-xl-2 pb-1">
                    <h1 class="header__title">Отдых в {{ $h1seo ?? 'Крыму' }}</h1>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row d-flex justify-content-start mt-3">

        @foreach($cities as $city )


            <div class="col-6 col-lg-2">
                <h3 class="about_h3"><a class="town"
                                        href="{{ route('city',['city'=>$city->alias]) }}">{{$city->name}} </a>
                </h3>

            </div>
        @endforeach

    </div>
</div>

<div class="col-12 d-md-none d-xs-block pt-3 pb-0">
    <a class="show-all" aria-hidden="true" href="#"><ins>
            Смотреть все</ins></a>
</div>

@include('layouts.searchform')
