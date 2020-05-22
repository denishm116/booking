@extends('layouts.backend')

@section('content')
    <div class="col">

        @if( $object ?? false )

            <h3 class="about__title">Редактирование объекта {{ $object->name }}</h3>
            <div class="col-xl-4 line"></div>
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
                                   value="{{ $object->address->street ?? old('street')}}"
                                   class="form-control"
                                   id="street" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="number" class="col-lg-2 control-label">Номер дома *</label>
                        <div class="col-lg-12">
                            <input name="number" required
                                   value="{{ $object->address->number ?? old('number')}}"
                                   class="form-control"
                                   id="number" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descr" class="col-lg-3 control-label">Описание объекта (не менее 100 символов)
                            *</label>
                        <div class="col-lg-12">
                <textarea name="description" required class="form-control" rows="3"
                          id="descr">{{ $object->description ?? old('description')}}</textarea>
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
<div class="navigation-item-button p-0 px-3 mb-2">Главное фото</div>
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

                        <h5 class="m-3">Чтобы изменения вступили в силу, не забудьте нажать на кнопку "сохранить объект"</h5>

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
                            <button type="submit" class="btn choice__button">Сохранить объект</button>
                        </div>
                    </div>


                    {{ csrf_field()  }}
                </form>

            </div>
        </div>

        {{--<div class="col-lg-10 col-lg-offset-2" style="display: none;">--}}

        {{--<form {{$novalidate}} method="POST" class="form-horizontal"--}}
        {{--action="{{ route('saveArticle',['id'=>$object->id ?? null])}}">--}}
        {{--<fieldset>--}}

        {{--<div class="form-group">--}}
        {{--<label for="textTitle" class="col-lg-2 control-label">Title *</label>--}}
        {{--<div class="col-lg-10">--}}
        {{--<input name="title" value="{{ old('title') }}" required type="text"--}}
        {{--class="form-control" id="textTitle" placeholder="">--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
        {{--<label for="textArea" class="col-lg-2 control-label">Content *</label>--}}
        {{--<div class="col-lg-10">--}}
        {{--<textarea name="content" required class="form-control" rows="3"--}}
        {{--id="textArea">{{ old('content')}}</textarea>--}}
        {{--<span class="help-block">Add an article about this object.</span>--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
        {{--<div class="col-lg-10 col-lg-offset-2">--}}
        {{--<button type="submit" class="btn btn-primary">Save</button>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</fieldset>--}}
        {{--{{ csrf_field() }}--}}
        {{--</form>--}}

        {{--</div>--}}


    </div>

@endsection


