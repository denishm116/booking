@extends('layouts.layout')

@section('title', 'Отдых в ' . $h1seo . ' 2020. Забронировать номер в '.$object->name)

@section('description', 'Отдых в '.$h1seo. ' 2020. Забронировать номер в '.$object->name. '. Цена от собственника. Без посредников, без комиссии.' )



@section('content')


    <div class="container">

        <div class="breadcrumb-holder my-3 p-0">
            <ul class="basic-breadcrumbs">
                <li class="d-none d-lg-block"><a href="{{route('home')}}"><u>Главная</u></a></li>
                <li class="d-none d-lg-block"><a
                        href="{{route('city',['city'=>$object->city->alias])}}"><u>{{$object->city->name}}</u></a></li>
                {{--<li class="d-none d-lg-block"><a href="{{route('type',['city'=>$object->city->alias, 'type' => $object->types->first()->alias])}}"><u>{{$object->types->first()->title}}</u></a></li>--}}
                <li class="d-none d-lg-block"><a href="#"><u>{{$object->name}}</u></a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-lg-8 col-12">
                <h1 class="about__title"> {{ $object->name }} в {{$h1seo}}</h1>
                <div class="col-xl-4 line"></div>
            </div>

            <div class="col-lg-4 col-10 pt-2">

                <p class="adress pl-1 pt-1"><i
                        class="fa fa-map-marker pr-3 text-justify"></i>г. {{ $object->city->name }}
                    ул. {{$object->address->street}}, д., {{$object->address->number}}</p>
            </div>


        </div>
    </div>


    <div class="hide hidden">
        <div class="modalWindow"></div>
    </div>
    <div class="container mb-5 pt-3">
        <div class="row">

            <div class="col-lg-8 hooper_flex">

                <slider :photos="{{json_encode($object->photos)}}"></slider>


            </div>


            <div class="col-lg-4 col-md-6 col-12 mx-0">


                <div class="shadow-sm text-center ">


                    <div class="rating__group_1 text-center" title="@guest()Авторизуйтесь, чтобы ваша оценка была учтена @endguest">
                        @guest() <a href="{{route('login')}}"> @endguest
                        <div class="rating text-center">
                            <div class="rating__group" title="Оценок: {{$object->votedCounter()}} @if($object->hasUserMark(Auth::id()))Ваша оценка {{$object->userMark(Auth::id())}}@endif
                                ">
                                @for ($i = 1; $i <= 10; $i++)

                                    <input class="rating__input @auth auth @endauth" type="radio" name="health" id="health-{{$i}}"
                                           value="{{$i}}"
                                           @if ($object->ratingCounter() == $i)
                                           checked
                                        @endif
                                    >
                                    <label class="rating__star" for="health-{{$i}}"></label>

                                @endfor
                            </div>
                        </div>

                            @if($object->hasUserMark(Auth::id()))<div class="">Ваша оценка {{$object->userMark(Auth::id())}}</div> @else <div class=" rat_text ">рейтинг</div> @endif
                @guest() </a> @endguest
                    </div>


                </div>

                <div class="object-info_number mb-3 pb-1 shadow-sm">
                    <div class="objHead">До моря:</div>

                    <div class="mleft"> {{$object->distance->title ?? null}}</div>

                </div>


                <div class="object-info_number  shadow-sm">
                    <div class="objHead">Дополнительно:</div>
                    <p class="text-justify">
                        @foreach($object->additionals as $additionals)

                            <i class="fas fa-angle-double-right"></i>{{' '.$additionals->title.' ' }}

                        @endforeach
                    </p>
                </div>


                <div class="object-info_number  shadow-sm">
                    <div class="objHead">Инфраструктура:</div>
                    <p class="text-justify">

                        @foreach($object->infrastructures as $infrastructures)
                            <i class="fas fa-angle-double-right"></i>{{' '.$infrastructures->title.' ' }}
                        @endforeach

                    </p>
                </div>

                <div class="object-info_number  shadow-sm">
                    <div class="objHead">Тип:</div>
                    <p class="text-justify">

                        @foreach($object->types as $type)
                            <i class="fas fa-angle-double-right"></i>{{' '.$type->title.' ' }}
                        @endforeach

                    </p>
                </div>


            </div>

        </div>


    </div>
    <div class="container my-3">

        <h3>Номера</h3>
    </div>

    <div class="container">
        @foreach($object->rooms as $room)
            <div class="row shadow-lg bg-light border-danger mb-4 p-3">

                <div class="col-lg-3 col-sm-12 text-center m-0 p-0 shadow-sm">

                    <img class="image-small thumb-radius" src="{{$room->photos->first()->path ?? $placeholder}}"
                         alt="{{$object->name}}">
                </div>
                <div class="col-lg-6">
                    <div class="row">

                        <div class="px-3">
                            <div class="text-center mb-2">Уникальный номер: <b>{{$room->id}}</b>
                            </div>
                            <div class="pl-1 text-justify"><b>Дополнительно:</b>
                                @foreach($room->rservices as $services)
                                    <span class="pb-style"><sup class="icon-style"><sub class="icon-center"><i
                                                    class="fas fa-circle ob"></i></sub></sup></span><span
                                    >{{' '.$services->title.' '}}</span>
                                @endforeach
                            </div>
                            <p class="pt-1"><b>Описание: </b>{{ str_limit($room->description,70) ?? false}} <a
                                    href="{{ route('room',['id'=>$room->id]) }}">далее...</a></p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3">


                    <div class="row">
                        <div class="col pt-2">
                            <div class="bg-white px-2 mb-2"><b>Базовая стоимость: </b>{{$room->price}} &#8381;</div>

                            <div class="px-2 mb-2"><b>Кол-во мест: </b>{{$room->room_size}}  </div>
                            <div class="bg-white px-2 mb-2"><b>Кол-во комнат: </b> {{$room->room_number}}  </div>

                            <div class="col text-right align-self-end px-1 mb-2">
                                <a href="{{ route('room',['id'=>$room->id]/* Lecture 20 */) }}"
                                   class="btn choice__button w-100 mt-2">Подробнее</a>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        @endforeach

    </div>
    <div class="container mt-5">

        <h3 class="about__title">"{{ $object->name }}"</h3>
        <div class="col-xl-4 line"></div>


        <article class="object-description">
            <p class="object-description_article text-justify">{{ $object->description }}</p>
        </article>


    </div>


    <div class="container align-content-center mt-5">


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
                <form method="POST"
                      action="{{ route('addComment',['object_id'=>$object->id])/* Lecture 25 */ }}">
                    <div class="shadow-sm p-1 m-3">

                        <label for="textArea" class="col control-label"><h4>Ваш отзыв
                                о {{$object->name ?? false}} </h4></label>
                        <div class="col">
                                <textarea required name="content" class="form-control" rows="3"
                                          id="textArea"></textarea>

                        </div>

                        <label for="select" class="col control-label"><h4 class="mt-3">Поставьте оценку
                                для {{$object->name ?? false}}</h4></label>
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


        @foreach( $object->comments as $comment )
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




        {{--        <section>--}}
        {{--        <h2 class="red">Отзывы о {{$object->name}}</h2>--}}
        {{--        @foreach($object->articles as $article)--}}
        {{--        <div class="articles-list">--}}
        {{--        <h4 class="top-buffer">{{ $article->title }} </h4>--}}
        {{--        <p><b> {{ $article->user->FullName }}</b>--}}
        {{--        <i>{{ $article->created_at }} </i>--}}
        {{--        </p>--}}
        {{--        <p>{{ str_limit($article->content,10000) }}  </p> <a--}}
        {{--        href="{{ route('article',['id'=>$article->id]) }}">More</a>--}}
        {{--        </div>--}}

        {{--        @endforeach--}}
        {{--        </section>--}}

    <!-- Кнопка лайка - дизлайка -->
        {{--        @auth--}}

        {{--        @if( $object->isLiked())--}}
        {{--        <a href="{{ route('unlike',['id'=>$object->id,'type'=>'App\TouristObject']) }}"--}}
        {{--        class=""><i class="fas fa-thumbs-up"></i></a>--}}
        {{--        @else--}}
        {{--        <a href="{{ route('like',['id'=>$object->id]) }}" class=""><i class="far fa-thumbs-up"></i></a>--}}
        {{--        @endif--}}

        {{--        @else--}}

        {{--        <p><a href="{{ route('register') }}">Зарегистрируйтесь</a> или <a href="{{ route('login') }}">Войдите</a>,--}}
        {{--        чтобы--}}
        {{--        поставить Лайк!</p>--}}

        {{--        @endauth--}}

    </div>
    <div class="ob-id text-white">{{$object->id}}</div>
@endsection

@push('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?apikey=3da80f65-799c-41a4-ba8f-ea7b21148fd6&lang=ru_RU"
            type="text/javascript">
    </script>

    <script type="text/javascript">

        ymaps.ready(init);

        function init() {
            var Url = "https://geocode-maps.yandex.ru/1.x/?apikey=3da80f65-799c-41a4-ba8f-ea7b21148fd6&format=json&lang=ru_RU&geocode={{$object->city->name}},+{{$object->address->street}},+{{$object->address->number}}"
            var coords = '';


            axios.get(Url)
                .then(data => {
                    z = data.data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos;
                    test(z)
                })
                .catch(err => console.log(err))


            function test(z) {
                coords = z.split(" ", 2);

                axios.get('/getCoords/{{$object->id}}')
                    .then(data => {
                        // console.log(data.data[0].Array)
                        if (data.data[0] == '') {
                            console.log('ne data')
                            axios.post('/putCoords', {
                                latitude: coords[1],
                                longitude: coords[0],
                                id: {{$object->id}},
                            }).then(data => {

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
                                hintContent: '{{$object->name}}',
                                balloonContent: '{{$object->city->name}}, {{$object->address->street}}, {{$object->address->number}}',

                            });

                            // Размещение геообъекта на карте.
                            myMap.geoObjects.add(placemark);


                        }


                    });
            }


        }
    </script>


@endpush
