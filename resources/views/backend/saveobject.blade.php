@extends('layouts.backend')

@section('content')
    <div class="col">

        @if( $object ?? false )

            <h3 class="about__title">Редактирование объекта {{ $object->name }}</h3>
            <div class="col-xl-4 line"></div>
            @if (Auth::user()->hasRole(['admin']))
                <div class="container m-0"><small>
                        Объект id: {{$object->id}} <a href="{{route('object', ['id' => $object->id])}}"> <i
                                class="fas fa-eye"></i></a>
                    </small></div>

            @endif
        @else
            <h3 class="about__title">Добавление нового объекта объекта</h3>
            <div class="col-xl-4 line"></div>
        @endif


        <div class="row mt-4">
            <div class="col">


                <form {{ $novalidate}} method="POST" enctype="multipart/form-data"
                      action="{{ route('saveObject',['id'=>$object->id ?? null])}}">
                    @if( Auth::user()->hasRole(['admin']) )
                        <div class="form-group">
                            <label for="city" class="col-lg-2 control-label">ЮЗЕР *</label>
                            <div class="col-lg-12">

                                <select name="user_id" class="form-control" id="user_id">


                                    @foreach($users as $user)
                                        @if( ($user ?? false) && ($object ?? false) && $object->user->id == $user->id )
                                            <option selected value="{{ $user->id }}">{{$user->id}}
                                                . {{$user->name}} {{$user->surname}} {{$user->phone}}</option>
                                        @else
                                            <option value="{{ $user->id }}">{{$user->id}}
                                                . {{ $user->name }} {{$user->surname}} {{$user->phone}}</option>
                                        @endif
                                    @endforeach

                                </select>

                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="city" class="col-lg-2 control-label">Город *</label>
                        <div class="col-lg-12">

                            <select name="city" class="form-control" id="city">


                                @foreach($cities as $city)
                                    @if( ($object ?? false) && $object->city->id == $city->id )
                                        <option selected value="{{ $city->id }}">{{ $city->name }}</option>
                                    @else
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endif
                                @endforeach

                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-lg-2 control-label">Название объекта *</label>
                        <div class="col-lg-12">
                            <input name="name" required type="text"
                                   value="{{ $object->name ?? old('name') ?? ''}}"
                                   class="form-control" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="street" class="col-lg-2 control-label">Улица *</label>
                        <div class="col-lg-12">
                            <input name="street" required type="text"
                                   value="{{ $object->address->street ?? old('street') ?? ''}}"
                                   class="form-control"
                                   id="street" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="number" class="col-lg-2 control-label">Номер дома *</label>
                        <div class="col-lg-12">
                            <input name="number" required
                                   value="{{ $object->address->number ?? old('number') ?? ''}}"
                                   class="form-control"
                                   id="number" placeholder="">
                        </div>
                    </div>
                    @if($object ?? null)
                        @if (Auth::user()->hasRole(['admin']))
                            <div class="row">

                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="latitude" class="col-lg-2 control-label">Широта</label>
                                        <div class="col">
                                            <input name="latitude"
                                                   value="{{ $object->latitude ?? old('latitude')}}"
                                                   class="form-control"
                                                   id="latitude" placeholder="">
                                        </div>

                                        <label for="longitude" class="col-lg-2 control-label">Долгота</label>
                                        <div class="col">
                                            <input name="longitude"
                                                   value="{{ $object->longitude ?? old('longitude')}}"
                                                   class="form-control"
                                                   id="number" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">

                                    <div id="map" class="yaMap pt-3"></div>

                                </div>
                            </div>

                        @endif
                    @endif

                    <div class="form-group">
                        <label for="descr" class="col-lg-3 control-label">Описание объекта (не менее 100 символов)
                            *</label>
                        <div class="col-lg-12">
                <textarea name="description" required class="form-control" rows="10"
                          id="descr">{{ $object->description ?? old('description') ?? ''}}</textarea>
                        </div>
                    </div>


                    <div class="col-lg-12 p-3 m-3">
                        <div class="row">

                            <div class="col-lg-3 shadow-sm">

                                <h5 class="card-title">Дополнительные услуги</h5>

                                @foreach($additionals as $additional)
                                    <div>
                                        <input type="checkbox" name="additionals[]" value="{{$additional->id}}"
                                               @if( $object ?? false )
                                               @foreach($object->additionals as $add)

                                               @if($add->id == $additional->id)
                                               checked
                                            @endif

                                            @endforeach
                                            @endif
                                        >
                                        <label class="form-check-label"
                                               for="additionals[]">{{$additional->title}}</label>
                                    </div>
                                @endforeach

                            </div>

                            <div class="col-lg-3  shadow-sm">

                                <h5 class="card-title">Тип объекта</h5>
                                @foreach($types as $type)
                                    <div>
                                        <input type="checkbox" name="types[]" value="{{$type->id}}"

                                               @if( $object ?? false )
                                               @foreach($object->types as $typ)

                                               @if($typ->id == $type->id)
                                               checked
                                            @endif

                                            @endforeach
                                            @endif
                                        >
                                        <label class="form-check-label" for="types[]">{{$type->title}}</label>
                                    </div>
                                @endforeach


                            </div>

                            <div class="col-lg-3  shadow-sm">

                                <h5 class="card-title">Инфраструктура</h5>
                                @foreach($infrastructures as $infrastructure)
                                    <div>
                                        <input type="checkbox" name="infrastructures[]"
                                               value="{{$infrastructure->id}}"
                                               @if( $object ?? false )
                                               @foreach($object->infrastructures as $infrastruct)

                                               @if($infrastruct->id == $infrastructure->id)
                                               checked
                                            @endif

                                            @endforeach
                                            @endif
                                        >
                                        <label class="form-check-label"
                                               for="infrastructures[]">{{$infrastructure->title}}</label>
                                    </div>
                                @endforeach


                            </div>


                            <div class="col-lg-3  shadow-sm">

                                <h5 class="card-title">До моря</h5>

                                <select name="distance_id" class="form-control" id="distance_id">
                                    @foreach($distances as $distance)

                                        @if( ($object ?? false) && ($object->distance_id == $distance->id))
                                            <option selected
                                                    value="{{ $distance->id }}">{{ $distance->title }}</option>
                                            {{--@else--}}
                                        @endif
                                        <option value="{{ $distance->id }}">{{ $distance->title }}</option>


                                    @endforeach
                                </select>


                            </div>


                        </div>

                    </div>

                    @if ($object ?? false)
                        <section class="container">
                            <div class="row">

                                @forelse( $object->rooms as $room )

                                    <div class="col-lg-2 align-content-between">
                                        <div class="objects__category__type text-center a">

                                            <div class="row shadow-sm">
                                                <div class="col text-center font-weight-bold"><a
                                                        href="{{route('room', ['id'=>$room->id])}}">
                                                        Уникальный номер id: <b>{{ $room->id  }}</b> </a></div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col text-center">
                                                    Комнат: {{$room->room_number}}
                                                </div>
                                            </div>

                                            <div class="row my-3">
                                                <div class="col text-center">
                                                    Мест: {{$room->room_size}}
                                                </div>
                                            </div>
                                            <div class="row my-3">
                                                <div class="col text-center">
                                                    Цена: {{$room->price}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <a title="edit" class="btn confirm__button w-100"
                                                   href="{{ route('saveRoom',['id'=>$room->id]) }}"><i
                                                        class="fas fa-edit"> </i> Редактировать</a></div>

                                            <div class="row">
                                                <a title="delete" class="btn confirm__button w-100"
                                                   href="{{ route('deleteRoom',['id'=>$room->id])  }}"><i
                                                        class="fas fa-trash"> </i> Удалить
                                                </a></div>

                                        </div>

                                    </div>

                                @empty
                                    @push('scripts')
                                        <script>


                                            const modal = $$.modal({
                                                modalHeaderText: 'Теперь необходимо добавить <b>номер</b>',
                                                modalBodyText: 'Для того, чтобы объект <b>"{{$object->name}}"</b> начал отображаться в поиске, необходимо добавить хотябы 1 номер с описанием, и стоимостью. Даже если вы сдаете квартиру или дом, все равно нужно добавить номер, как будто у Вас отель, в котором 1 номер. Ведь нельзя указать стоимость отеля за сутки, можно указать только стоимость номера за сутки :)',
                                                modalButtonText: 'Добавить номер к <b>"{{$object->name}}"</b>',
                                                href: '{{ route('saveRoom').'?object_id='.$object->id  }}',
                                                closable: true,
                                            })
                                            modal.open()
                                        </script>

                                    @endpush
                                    @if ($object ?? false)
                                        <div class="col-12 align-content-center text-center">
                                            <div class="alert alert-danger"><b>ВНИМАНИЕ: </b>для того, чтобы ваш объект
                                                отобразился в поиске нажмите <a
                                                    href="{{ route('saveRoom').'?object_id='.$object->id  }}"
                                                    class="btn confirm__button btn-xs">Добавить номер</a>. И заполните
                                                данные хотя бы одного номера.<br> Если вы сдаете квартиру или дом,
                                                заполните
                                                оставшиеся данные, после нажатия кнопки.
                                            </div>
                                        </div>

                                    @endif
                                @endforelse

                                @forelse($object->rooms as $room)

                                    <div
                                        class="col-lg-2 align-content-between objects__category__type text-center my-auto">

                                        <a
                                            href="{{ route('saveRoom').'?object_id='.$object->id  }}"
                                            class="">Нажмите <span class="btn confirm__button w-100">ЗДЕСЬ</span> чтобы
                                            добавить еще номер<i class="fas fa-plus-square"></i></a>

                                    </div>
                                    @break
                                @empty

                                @endforelse
                            </div>
                        </section>
                    @endif


                    <div class="form-group shadow-sm p-3 m-3">
                        <div class="col-lg-10 col-lg-offset-2">
                            <label for="objectPictures">Фото объекта (размер одного фото не должен превышать
                                5мб)</label>
                            <input type="file" name="objectPictures[]" id="objectPictures" multiple>

                        </div>
                    </div>
                    @push('scripts')
                        <script>
                            function pictureFirst() {
                                let img = document.getElementsByName('objectPictures[]');
                                console.log(img)

                            }

                            pictureFirst();
                            document.querySelector('.radio').onchange = pictureFirst;
                            document.querySelectorAll('.button').onclick = pictureFirst;
                        </script>
                    @endpush

                    @if( $object ?? false )
                        <div class="col-lg-12 col-lg-offset-2">

                            @foreach( $object->photos->chunk(4) as $chunked_photos )

                                <div class="row">


                                    @foreach( $chunked_photos as $photo )

                                        <div class="col-md-4 col-sm-6">
                                            <div class="thumbnail mb-4
                                            @if ($photo->main_photo ?? false )
                                                bradius_backend shadow-lg
                                                @else
                                                bradius2
                                                @endif
                                                ">
                                                <img class="img-responsive img-thumbnail"
                                                     src="{{ $photo->path ?? $placeholder}}"
                                                     alt="{{$photo->id ?? false}}">

                                                <div class="flex text-center mt-2">
                                                    <div class="margin"><a
                                                            href="{{ route('deletePhoto',['id'=>$photo->id])}}"
                                                            class="btn confirm__button px-3"
                                                            role="button">Удалить <i
                                                                class="fas fa-trash"> </i></a>
                                                    </div>

                                                    <div class="margin">
                                                        @if ($photo->main_photo ?? false )
                                                            <div class="navigation-item-button p-0 px-3 mb-2">Главное
                                                                фото
                                                            </div>
                                                        @else
                                                            <a
                                                                href="{{ route('mainPhoto',['id'=>$photo->id])}}"
                                                                class="btn confirm__button px-3"
                                                                role="button">
                                                                Сделать главным <i class="fas fa-search"></i>
                                                            </a>
                                                        @endif

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    @endforeach

                                </div>


                            @endforeach

                        </div>



                        {{--<div class="col-lg-12 col-lg-offset-2">--}}
                        {{--Articles:--}}
                        {{--<ul class="list-group">--}}
                        {{--@foreach( $object->articles as $article )--}}
                        {{--<li class="list-group-item">--}}
                        {{--{{ $article->title}} <a--}}
                        {{--href="{{ route('deleteArticle',['id'=>$article->id])}}">delete</a>--}}
                        {{--</li>--}}
                        {{--@endforeach--}}

                        {{--</ul>--}}
                        {{--</div>--}}
                    @endif


                    @if( $object ?? false )

                        <h5 class="m-3">Чтобы изменения вступили в силу, не забудьте нажать на кнопку "сохранить
                            объект"</h5>

                    @else
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                {{--<button type="submit" class="btn choice__button">Сохранить объект</button>--}}
                                <h4 style="color: red">ВНИМАНИЕ!<br> ДОБАВЬТЕ НОМЕРА!</h4>
                                <h5 style="color: red">После того, как вы сохраните объект, ОБЯЗАТЕЛЬНО добавьте номера!
                                    Стоимость проживания указывется для каждого номера! (если у вас квартира, дом и
                                    т.д., вам все равно нужно будет нажать кнопку "Добавить номер" в появившемся окне и
                                    заполнить форму).</h5>

                            </div>

                        </div>
                    @endif


                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn choice__button">Сохранить объект @if( $object ?? false )
                                    id:{{$object->id}} @endif</button>
                        </div>
                    </div>


                    {{ csrf_field()  }}
                </form>

            </div>
        </div>
    </div>

@endsection

@if ($object ?? null)


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
                            coords = data.data;
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
@endif
