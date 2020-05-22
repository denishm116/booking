<header>


    <div class="pt-5 pb-4 header-background img-fluid header-catalog" id="background">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 pr-1">
                    <div class="breadcrumb-holder pl-3">
                        <ul class="basic-breadcrumbs">
                            <li class="d-none d-lg-block"><a href="{{route('home')}}"><u>Главная</u></a></li>
                            <li class="d-none d-lg-block"> <a href="#">Каталог</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-12 col-12 pt-xl-4 pb-xl-2 pb-1">
                   <h1 class="header__title">Отдых в {{ $h1seo }}</h1>
                </div>
            </div>
        </div>
    </div>
</header>

{{--<div class="col-12 d-md-none d-xs-block pt-3 pb-0">--}}
    {{--<a class="show-all" aria-hidden="true" href="#"><ins>--}}
            {{--Смотреть все</ins></a>--}}
{{--</div>--}}

{{--<div class="container">--}}
    {{--<form method="POST" action="{{ route('roomSearch') }}" >--}}

        {{--<div class="form-serch form-row pb-5 align-items-center py-2">--}}
            {{--<div class="col-xl-2 col-12 py-2">--}}
                {{--<input  name="city" value="{{ old('city') /* Lecture 19 */ }}" type="text" class="autocomplete form-control" id="city" placeholder="Куда вы едете?">--}}
            {{--</div>--}}
            {{--<div class="col-xl-2 col-6">--}}
                {{--<div class="input-group">--}}
                    {{--<input  name="check_in" value="{{ old('check_in') /* Lecture 19 */ }}" type="text" class="datepicker form-control form-control-right-in" id="check_in" placeholder="Дата заезда" autocomplete="off">--}}
                    {{--<div class="input-group-append">--}}
                        {{--<button class="btn btn_date btn_date_in" type="button">--}}
                            {{--<i class="far fa-calendar-alt"></i>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col-xl-2 col-6">--}}
                {{--<div class="input-group">--}}
                    {{--<input name="check_out" value="{{ old('check_out') /* Lecture 19 */ }}" type="text" class="datepicker form-control form-control-right-out" id="check_out" placeholder="Дата отъезда" autocomplete="off">--}}
                    {{--<div class="input-group-append">--}}
                        {{--<button class="btn btn_date btn_date_out" type="button">--}}
                            {{--<i class="far fa-calendar-alt"></i>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-xl-2 col-12 py-2">--}}
                {{--<select name="room_size" class="form-control">--}}
                    {{--<option>Кол-во гостей</option>--}}

                    {{--<!-- Lecture 19 -->--}}
                    {{--@for($i=1;$i<=5;$i++)--}}
                        {{--@if( old('room_size') == $i )--}}
                            {{--<option selected value="{{$i}}">{{$i}}</option>--}}
                        {{--@else--}}
                            {{--<option value="{{$i}}">{{$i}}</option>--}}
                        {{--@endif--}}
                    {{--@endfor--}}

                {{--</select>--}}
            {{--</div>--}}
            {{--<div class="col-xl-2 col-12">--}}
                {{--<button type="submit" class="btn px-4  w-100 choice__button ">Подобрать</button>--}}
            {{--</div>--}}
            {{--{{ csrf_field() }}--}}
        {{--</div>--}}

    {{--</form>--}}
{{--</div>--}}
