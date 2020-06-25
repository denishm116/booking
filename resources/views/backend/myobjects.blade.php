@extends('layouts.backend')

@section('content')
    <div class="app">
<h3 class="about__title">Список ваших объектов</h3>
<div class="col-xl-4 line"></div>
        @if( Auth::user()->hasRole(['owner']) && count($authUserObject) == 0)
            @push('scripts')
                <script>


                    const modal = $$.modal({
                        modalHeaderText: 'Необходимо создать объект',
                        modalBodyText: 'Для продолжения работы, Вам необходимо добавить свой объект, фотграфии и описание. После этого к объекту нужно будет добавить номера (система сама Вас направит). Даже если вы сдаете квартиру или дом, все равно нужно добавить номер, как будто у Вас отель, в котором 1 номер. Ведь нельзя забронировать отель - можно забронировать номер в отеле :)',
                        modalButtonText: 'Добавить объект',
                        href: '{{ route("saveObject") }}',
                        closable: true,
                    })
                    modal.open()
                </script>

            @endpush
        @endif
@if (count($objects) == 0)
            @push('scripts')
                <script>
                    // const $ = {};
                </script>
            @endpush
    <div class="container">
        <div class="row justify-content-center">
            <div class="panel panel-success top-buffer shadow-lg align-content-center px-5 h100rem">
                <div class="mt50">
                    <h3 class="panel-title text-center"> Нажмите "<a href="{{ route('saveObject') }}">Добавить объект</a>", чтобы добавить объект<br> (гостиницу, гостевой дом, квартиру и т. д.).
                    </h3>

                    <h3 class="panel-title text-center"> Просмотрите, пожалуйста, <a href="https://youtu.be/ouw9i6XIBGc">видеоинструкцию</a> по пользованию сервисом.
                    </h3>


                </div>
            </div>
        </div>
    </div>
@endif

@foreach( $objects as $object )

<div class="panel panel-success top-buffer shadow-lg bg-white p-3 mb-3">
    <div class="panel-heading">
        <h3 class="panel-title"> Объект "{{ $object->name }}"
            <small><a href="{{ route('saveObject',['id'=>$object->id])}}"
                      class="btn confirm__button btn-xs">Редактировать объект</a> <a
                    href="{{ route('saveRoom').'?object_id='.$object->id  }}"
                    class="btn confirm__button btn-xs">Добавить номер</a> <a title="delete"
                                                                             href="{{ route('deleteObject',['id'=>$object->id]) }}"><i
                        class="fas fa-trash"></i></a></small>
        </h3>
    </div>

    <h4>Номера: </h4>

    <div class="row align-content-between">


    @forelse( $object->rooms as $room )

            <div class="col-lg-2 align-content-between">
            <div class="objects__category__type text-center a">

                <div class="row shadow-sm">
                    <div class="col text-center font-weight-bold"><a href="{{route('room', ['id'=>$room->id])}}">
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
        <div class="col-12 align-content-center text-center">
            <div class="alert alert-danger"><b>ВНИМАНИЕ: </b>для того, чтобы ваш объект отобразился в поиске нажмите <a
                    href="{{ route('saveRoom').'?object_id='.$object->id  }}"
                    class="btn confirm__button btn-xs">Добавить номер</a>. И заполните данные хотя бы одного номера.<br> Если вы сдаете квартиру или дом, заполните оставшиеся данные, после нажатия кнопки. </div></div>
        @endforelse

@forelse($object->rooms as $room)

            <div class="col-lg-2 align-content-between objects__category__type text-center my-auto">

            <a
                href="{{ route('saveRoom').'?object_id='.$object->id  }}"
                class="">Нажмите <span class="btn confirm__button w-100">ЗДЕСЬ</span> чтобы добавить еще номер<i class="fas fa-plus-square"></i></a>

        </div>
    @break
    @empty

@endforelse

    </div>

</div>

@endforeach
    </div>

@endsection


