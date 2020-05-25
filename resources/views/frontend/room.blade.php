@extends('layouts.layout')

@section('title', 'Отдых в ' . $h1seo . ' 2020. Забронировать номер №'.$room->id.' в '.$room->object->name )

@section('description', 'Отдых в ' . $h1seo . ' 2020. Бронирование номера' . $room->id . ' в '.$room->object->name. '. Цена от собственника. Без посредников, без комиссии.')
@section('content')


    <div class="container">
        <div class="breadcrumb-holder my-3 p-0">
            <ul class="basic-breadcrumbs">
                <li class="d-none d-lg-block"><a href="{{route('home')}}"><u>Главная</u></a></li>
                <li class="d-none d-lg-block"><a href="{{route('city',['city'=>$room->object->city->alias ?? null])}}"><u>{{$room->object->city->name}}</u></a></li>
                <li class="d-none d-lg-block"><a href="{{route('type',['city'=>$room->object->city->alias  ?? null, 'type' => $room->object->types->first()->alias  ?? null])}}"><u>{{$room->object->types->first()->title ?? null}}</u></a></li>
                <li class="d-none d-lg-block"><a href="{{route('object', ['id'=>$room->object->id])}}"><u>{{$room->object->name}}</u></a></li>
                <li class="d-none d-lg-block"><a href="#"><u>{{$room->id}}</u></a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-8 col-12">

                <h1 class="about__title">Номер id: {{$room->id}}

                </h1>
                <div class="col-xl-4 line"></div>


            </div>
            <div class="col-lg-4 col-12">
                <div class="objHead text-right">Объект размещения: <a
                        href="{{ route('object',['room'=>$room->object_id]) }}">{{ $room->object->name}}</a>
                </div>
                <div class="adress pl-1 pt-1 text-right"><i
                        class="fa fa-map-marker pr-3 text-justify"></i>г. {{ $room->object->city->name }}
                    ул. {{$room->object->address->street}}, д., {{$room->object->address->number}}</div>
            </div>

        </div>
    </div>

    <div class="hide hidden">
        <div class="modalWindow"></div>
    </div>

    <div class="container mt-3">
        <div class="row">


            <div class="col-lg-4 col-md-6 col-12 shadow-lg bradius text-black">
                <div class="col pt-3 text-center">
                    <h4 class="comfort-info">Рейтинг</h4>
                    <p class="text-center">{!! $room->object->rating !!}</p>
                </div>
                <div class="row">

                    <div class="col">

                        <div class="mb-3 bg-light px-2"><b>Базовая стоимость: </b>{{$room->price}} &#8381;</div>
                        <div class="mb-3 px-2"><b>До моря: </b>{{$room->object->distance->title ?? null}}</div>
                        <div class="mb-3 bg-light px-2"><b>Кол-во мест: </b>{{$room->room_size}}  </div>
                        <div class="mb-3 px-2"><b>Кол-во комнат: </b> {{$room->room_number}}  </div>

                        <div class="mb-3  bg-light  px-2 text-justify"><b>Услуги номера:</b>
                            @foreach($room->rservices as $services)
                                <span class="pb-style"><sup class="icon-style"><sub class="icon-center"><i
                                                class="fas fa-circle"></i></sub></sup></span> {{ $services->title }}

                            @endforeach
                        </div>

                        <div class="mb-1 px-2  text-justify"><b>Дополнительно:</b>
                            @foreach($room->object->additionals as $additionals)
                                <span class="pb-style"><sup class="icon-style"><sub class="icon-center"><i
                                                class="fas fa-circle"></i></sub></sup></span> {{$additionals->title}}

                            @endforeach
                        </div>

                        <div class="mb-3 bg-light px-2  text-justify"><b> Инфраструктура:</b>
                            @foreach($room->object->infrastructures as $infrastructures)
                                <span class="pb-style"><sup class="icon-style"><sub class="icon-center"><i
                                                class="fas fa-circle"></i></sub></sup></span>{{' '.$infrastructures->title.' ' }}

                            @endforeach
                        </div>


                    </div>


                </div>

            </div>

            <div class="col-lg-8 hooper_flex ">

                <slider :photos="{{json_encode($room->photos)}}"></slider>


            </div>


        </div>
    </div>

    {{--@foreach( $room->photos->chunk(4) as $chunked_photos ) <!-- Lecture 20 -->--}}

    {{--<div class="row top-buffer">--}}

    {{--@foreach($chunked_photos as $photo) <!-- Lecture 20 -->--}}

    {{--<div class="col-md-4">--}}
    {{--<img class="img-responsive" src="{{ $photo->path ?? $placeholder /* Lecture 20 */  }}" alt="">--}}
    {{--</div>--}}

    {{--@endforeach <!-- Lecture 20 -->--}}

    {{--</div>--}}

    {{--@endforeach <!-- Lecture 20 -->--}}

    <div class="container mt-5">
        <section>


            <h3 class="about__title">Описание</h3>
            <div class="col-xl-4 line"></div>

            <div class="container">
                <div class="row my-4 shadow-sm bg-light">

                    {{--<div class="col-lg-2 col-sm-12 text-center">--}}
                    {{--<img class="image-small" src="{{$room->photos->first()->path ?? $placeholder}}" class=""--}}
                    {{--alt="{{$room->object->name}}">--}}
                    {{--</div>--}}
                    <div class="col-lg-12">

                        <div class="row">
                            <div class="col text-right align-self-end">
                                <a href="#" data="{{$room->id}}"
                                   class="btn choice__button w-100 favourites-button" role="button">В избранное</a>
                            </div>
                            <div class="col text-right align-self-end">
                                <a href="{{ route('room',['id'=>$room->id]) }}#reservation"
                                   class="btn choice__button w-100" role="button">Забронировать</a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <article class="object-description">
                <p class="object-description_article text-justify">{{ $room->description }}</p>


            </article>


        </section>


        @isset($room->price()->first()->period1start)
            <div class="col-lg-12 col-sm-12 text-center shadow-lg bg-light">
                <div class="row bg-light-dark p-1">
                    <div class="col">
                        <h3>
                            <small>Стоимость бронирования по месяцам</small>
                        </h3>

                    </div>
                </div>

                <div class="row justify-content-between">
                    @for($i = 1; $i <= 12; $i++)
                        @php
                            $room = (isset($room)) ? $room : false; // это чтобы шторм не ругался, можно и удалить
                            $periodStartStr = 'period'.$i.'start';
                            $periodEndStr = 'period'.$i.'end';
                            $periodPriceStr = 'price'.$i;
                            if($room){
                                $periodStart = $room->price()->first()->$periodStartStr;
                                $periodEnd = $room->price()->first()->$periodEndStr;
                                $periodPrice = $room->price()->first()->$periodPriceStr;
                            }
                        @endphp
                        @isset($periodPrice)
                            <div class="col-12 bg-light">

                                <div class="row p-1 table-bordered m-1 bg-white">
                                    <div class="col">{{$i}} период</div>
                                    <div class="col"> с {{ strftime('%d-%b-%Y', strtotime($periodStart))}}</div>
                                    <div class="col"> по {{ strftime('%d-%b-%Y', strtotime($periodEnd))}} </div>
                                    <div class="col"> {{ $periodPrice}} руб.</div>
                                </div>

                            </div>


                        @endisset
                    @endfor


                    {{--@for($i = 1; $i <= 12; $i++)--}}
                    {{--@php--}}
                    {{--$room = (isset($room)) ? $room : false; // это чтобы шторм не ругался, можно и удалить--}}
                    {{--$periodStartStr = 'period'.$i.'start';--}}
                    {{--$periodEndStr = 'period'.$i.'end';--}}
                    {{--$periodPriceStr = 'price'.$i;--}}
                    {{--if($room){--}}
                    {{--$periodStart = $room->price()->first()->$periodStartStr;--}}
                    {{--$periodEnd = $room->price()->first()->$periodEndStr;--}}
                    {{--$periodPrice = $room->price()->first()->$periodPriceStr;--}}
                    {{--}--}}
                    {{--@endphp--}}
                    {{--@isset($periodPrice)--}}
                    {{--<div class="col-12 col-lg-2 bg-light p-1"><h6>{{$i}} период</h6>--}}
                    {{--<div>с {{ strftime('%d-%b-%Y', strtotime($periodStart))}} </div>--}}
                    {{--по--}}
                    {{--{{ strftime('%d-%b-%Y', strtotime($periodEnd))}}--}}

                    {{--<div class="bg-light p-1"><h6>{{ $periodPrice}} руб.</h6></div>--}}
                    {{--</div>--}}
                    {{--@endisset--}}
                    {{--@endfor--}}


                </div>
                @endisset


                <div id="reservation" class="shadow-lg p-3 my-5">

                    <h2 class="text-center book m-3">Забронировать</h2>

                    <div class="row">
                        <div class="col col-lg-8">


                            <form
                                {{ $novalidate }} action="{{ route('makeReservation',['room_id'=>$room->id,'city_id'=>$room->object->city->id])}}"
                                method="POST">

                                {{--                <form {{ $novalidate }} action="{{ route('preReservation', ['room_id'=>$room->id])}}" method="POST">--}}


                                <div class="form-group w-100">
                                    <label for="checkin">Дата заезда</label>
                                    <input required name="checkin" type="text" class="form-control datepicker w-100"
                                           id="checkin"
                                           placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="checkout">Дата выезда</label>
                                    <input required name="checkout" type="text" class="form-control datepicker"
                                           id="checkout"
                                           placeholder="" autocomplete="off">
                                </div>


                                @auth()
                                    @if( Auth::id() == $room->object->user_id || Auth::user()->hasRole(['admin']))

                                        {{--<h2> {{Auth::id()}} Описание</h2>--}}
                                        {{--<h2> {{$room->object->user_id}} Описание</h2>--}}

                                        <div class="form-group">
                                            <label for="checkout">Пожелания</label>
                                            <textarea name="description" class="form-control"></textarea>

                                        </div>
                                    @endif
                                @endauth
                              {{--@if(Auth::guest())--}}
                                    {{--<p><a class="btn  choice__button w-100 mt-3" href="{{ route('login') }}">войти и забронировать</a></p>--}}
                                {{--@else--}}
                                    <button type="submit" class="btn  choice__button w-100 mt-3">Забронировать</button>
                                {{--@endif--}}


                                <h3 class="text-danger text-center m-2">{{ Session::get('reservationMsg') }}</h3>
                                {{ csrf_field() }}
                            </form>


                        </div>
                        <div class="col col-lg-4">
                            <div id="avaiability_calendar">

                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="container align-content-center mb-5">


                <h3 class="about__title">На карте</h3>
                <div class="col-xl-4 line"></div>


                <div id="map" class="yaMap pt-3"></div>
            </div>
            <div class="container">

                <h5 class="about__title pt-4">Комментарии и оценки</h5>
                <div class="col-xl-4 line mb-4"></div>


                {{--@auth--}}
                {{--<a class="btn choice__button" role="button" data-toggle="collapse" href="#collapseExample"--}}
                {{--aria-expanded="false"--}}
                {{--aria-controls="collapseExample">--}}
                {{--Добавить комментарий и оценку--}}
                {{--</a>--}}
                {{--@else--}}
                {{--<p><a href="{{ route('register') }}">Зарегистрируйтесь</a> или <a href="{{ route('login') }}">Войдите</a>,--}}
                {{--чтобы--}}
                {{--оставить отзыв</p>--}}
                {{--@endauth--}}


                <div class="row p-0">
                    <div class="col-12 mb-5 mx-0 p-0">
                        <form method="POST" action="{{ route('addComment',['object_id'=>$room->object->id])}}">
                            <div class="shadow-sm p-1 m-3">

                                <label for="textArea" class="col control-label"><h4>Ваш отзыв
                                        о {{$room->object->name}} </h4>
                                </label>
                                <div class="col">
                                <textarea required name="content" class="form-control" rows="3"
                                          id="textArea"></textarea>

                                </div>

                                <label for="select" class="col control-label"><h4 class="mt-3">Поставьте оценку
                                        для {{$room->object->name}}</h4></label>
                                <div class="row">
                                    <div class="col mx-3 mb-3">
                                        <select name="rating" class="form-control" id="select">
                                            <option value="10">10</option>
                                            <option value="9">9</option>
                                            <option value="8">8</option>
                                            <option value="7">7</option>
                                            <option value="6">6</option>
                                            <option value="5">5</option>
                                            <option value="4">4</option>
                                            <option value="3">3</option>
                                            <option value="2">2</option>
                                            <option value="1">1</option>
                                        </select>
                                    </div>
                                    <div class="col  mx-3 mb-3">
                                        <button type="submit" class="btn choice__button w-100">Отправить</button>
                                    </div>
                                </div>
                            </div>


                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

                @foreach( $room->object->comments as $comment )
                    <div class="shadow-sm bg-light mb-3 p-2">

                        <div class="row">

                            <div class="col">
                                <span class="font-weight-bold">{{ $comment->user->FullName  }}</span> поставил
                                <small> {!! $comment->ratingStar !!}
                                    <i class="far fa-star"></i></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">И прокомментировал:  </span> {{ $comment->content }}
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">

                            </div>
                        </div>

                    </div>

                @endforeach

                {{--<section>--}}
                {{--<h2 class="red">Отзывы о {{$object->name}}</h2>--}}
                {{--@foreach($object->articles as $article) <!-- Lecture 16 -->--}}
                {{--<div class="articles-list">--}}
                {{--<h4 class="top-buffer">{{ $article->title }} <!-- Lecture 16 --></h4>--}}
                {{--<p><b> {{ $article->user->FullName }} <!-- Lecture 16 --></b>--}}
                {{--<i>{{ $article->created_at }} <!-- Lecture 16 --></i>--}}
                {{--</p>--}}
                {{--<p>{{ str_limit($article->content,10000) }} <!-- Lecture 16 --> </p> <a--}}
                {{--href="{{ route('article',['id'=>$article->id]/* Lecture 22 */) }}">More</a>--}}
                {{--</div>--}}

                {{--@endforeach <!-- Lecture 16 -->--}}
                {{--</section>--}}

            <!-- Кнопка лайка - дизлайка -->
{{--                @auth--}}

{{--                @if( $room->object->isLiked() )--}}
{{--                <a href="{{ route('unlike',['id'=>$room->object->id,'type'=>'App\TouristObject']) }}"--}}
{{--                class="btn btn-primary btn-xs top-buffer">Дизлайкнуть</a>--}}
{{--                @else--}}
{{--                <a href="{{ route('like',['id'=>$room->object->id]) }}" class="btn btn-primary btn-xs top-buffer">Лайкнуть--}}
{{--                объект</a>--}}
{{--                @endif--}}

{{--                @else--}}

{{--                <p><a href="{{ route('register') }}">Зарегистрируйтесь</a> или <a href="{{ route('login') }}">Войдите</a>,--}}
{{--                чтобы--}}
{{--                поставить Лайк!</p>--}}

{{--                @endauth--}}

            </div>
    </div>
            @endsection

            @push('scripts')



                <script src="https://api-maps.yandex.ru/2.1/?apikey=3da80f65-799c-41a4-ba8f-ea7b21148fd6&lang=ru_RU"
                        type="text/javascript">
                </script>

                <script type="text/javascript">

                    ymaps.ready(init);

                    function init() {
                        var Url = "https://geocode-maps.yandex.ru/1.x/?apikey=3da80f65-799c-41a4-ba8f-ea7b21148fd6&format=json&lang=ru_RU&geocode={{$room->object->city->name}},+{{$room->object->address->street}},+{{$room->object->address->number}}"
                        var coords = '';


                        axios.get(Url)
                            .then(data => {
                                z = data.data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos;
                                // console.log('Координаты ' + z)
                                // return z;
                                test(z)
                            })
                            .catch(err => console.log(err))


                        function test(z) {
                            coords = z.split(" ", 2);

                            axios.get('/getCoords/{{$room->object->id}}')
                                .then(data => {
                                    // console.log(data.data[0].Array)
                                    if (data.data[0] == '') {
                                        console.log('ne data')
                                        axios.post('/putCoords', {
                                            latitude: coords[1],
                                            longitude: coords[0],
                                            id: {{$room->object->id}},
                                        }).then(data => {
                                            // setTimeout(() => { showOnCard
                                            //     console.log('zagruzilos')
                                            // resolve()
                                            // }, 1000 )
                                            // console.log(data)
                                            location.reload()
                                        })
                                    } else {
                                        return showOnCard();
                                    }

                                    function showOnCard() {

                                        // console.log('Дата ' + data.data);

                                        coords = data.data;
                                        // console.log('Data CoOrDs ' + coords);
                                        var myMap = new ymaps.Map("map", {
                                            center: [coords[1], coords[0]],
                                            zoom: 12
                                        });

                                        var myGeoObject = new ymaps.GeoObject({
                                            geometry: {
                                                type: "Point", // тип геометрии - точка
                                                coordinates: [coords[1], coords[0]], // координаты точки

                                            }
                                        });
                                        // Размещение геообъекта на карте.
                                        myMap.geoObjects.add(myGeoObject);

                                        var placemark = new ymaps.Placemark([coords[1], coords[0]], {
                                            hintContent: '{{$room->object->name}}',
                                            balloonContent: '{{$room->object->city->name}}, {{$room->object->address->street}}, {{$room->object->address->number}}',

                                        });

                                        // Размещение геообъекта на карте.
                                        myMap.geoObjects.add(placemark);


                                    }


                                });
                        }


                    }
                </script>


                <script>
                    $('.datepicker').datepicker({
                        range: 'period',
                        minDate: 0,
                        numberOfMonths: 2,
                        dateFormat: "yy-mm-dd",
                        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                        onSelect: function (dateText, inst, extensionRange) {
                            // extensionRange - объект расширения
                            $('[name=checkin]').val(extensionRange.startDateText);
                            $('[name=checkout]').val(extensionRange.endDateText);


                            document.querySelector('#checkin').onfocus = () => myTempVar = false;
                            if (!myTempVar) {
                                document.querySelector('#checkout').focus()
                                myTempVar = true;
                            }
                            if (myTempVar && extensionRange.startDateText < extensionRange.endDateText)
                                setTimeout(function () {
                                    $("#checkin, #checkout").datepicker('hide')
                                }, 1000)


                        }
                    });

                    /* Lecture 21 */
                    function datesBetween(startDt, endDt) {
                        var between = [];
                        var currentDate = new Date(startDt);
                        var end = new Date(endDt);
                        while (currentDate <= end) {
                            between.push($.datepicker.formatDate('mm/dd/yy', new Date(currentDate)));
                            currentDate.setDate(currentDate.getDate() + 1);
                        }

                        return between;
                    }

                    $.ajax({

                        cache: false,
                        url: base_url + '/ajaxGetRoomReservations/' + {{ $room->id }},
                        type: "GET",
                        success: function (response) {
                            var eventDates = {};
                            var dates = [/* Lecture 21 */];

                            /* Lecture 21 */
                            for (var i = 0; i <= response.reservations.length - 1; i++) {
                                dates.push(datesBetween(new Date(response.reservations[i].day_in), new Date(response.reservations[i].day_out))); // array of arrays
                            }
                            dates = [].concat.apply([], dates); /* 21 */
                            /* Lecture 21 */
                            for (var i = 0; i <= dates.length - 1; i++) {
                                eventDates[dates[i]] = dates[i];
                            }

                            $(function () {
                                $("#avaiability_calendar").datepicker({
                                    minDate: 0,
                                    dateFormat: "dd-mm-yy",
                                    range: 'period',

                                    numberOfMonths: 1,
                                    onSelect: function (data) {

                                        // console.log($('#checkin').val());

                                        if ($('#checkin').val() == '') {

                                            $('#checkin').val(data);
                                            $("#check_in, #check_out").datepicker({
                                                minDate: 0,
                                                dateFormat: "dd-mm-yy",

                                            })

                                        } else if ($('#checkout').val() == '') {
                                            $('#checkout').val(data);
                                        } else if ($('#checkout').val() != '') {
                                            $('#checkin').val(data);
                                            $('#checkout').val('');
                                        }

                                    },
                                    beforeShowDay: function (date) {
                                        var tmp = eventDates[$.datepicker.formatDate('mm/dd/yy', date)];
                                        /* Lecture 21 */
                                        //console.log(date);
                                        if (tmp)
                                            return [false, 'unavaiable_date'];
                                        else
                                            return [true, ''];
                                    }


                                });
                            });


                        }


                    });

                </script>

    @endpush



