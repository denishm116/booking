@extends('layouts.backend')

@section('content')
    <div class="app">
        <h3 class="about__title">Календарь бронирований</h3>
        <div class="col-xl-4 line"></div>

        @if (count($objects) == '')
            <div class="container">
                <div class="row justify-content-center">
                    <div class="panel panel-success top-buffer shadow-lg align-content-center p-5 my-5 h100rem">
                        <div class="mt50">
                            <h3 class="panel-title text-center"> Здесь будут отображаться Ваши бронирования
                            </h3>

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


                        </div>
                    </div>
                </div>
            </div>
        @endif


        @foreach( $objects as $o=>$object )

            @php ( $o++ )
            <h3 class="red">Объект "{{ $object->name }}" </h3>

            @foreach( $object->rooms as $r=>$room )

                <div class="shadow-lg p-3 my-4 bg-white">

                    @push('scripts')
                        <script>

                            var eventDates{{ $o.$r }} = {};
                            var datesConfirmed{{ $o.$r }} = [];
                            var datesnotConfirmed{{ $o.$r }} = [];

                            @foreach($room->reservations as $reservation)

                            @if ($reservation->status)
                            datesConfirmed{{$o.$r}}.push(datesBetween(new Date('{{$reservation->day_in}}'), new Date('{{$reservation->day_out}}')));
                            @else
                            datesnotConfirmed{{$o.$r}}.push(datesBetween(new Date('{{$reservation->day_in}}'), new Date('{{$reservation->day_out}}')));
                            @endif

                                @endforeach

                                datesConfirmed{{$o.$r}} = [].concat.apply([], datesConfirmed{{$o.$r}});
                            datesnotConfirmed{{$o.$r}} = [].concat.apply([], datesnotConfirmed{{$o.$r}});


                            for (var i = 0; i < datesConfirmed{{ $o.$r }}.length; i++) {
                                eventDates{{ $o.$r }}[datesConfirmed{{ $o.$r }}[i]] = 'confirmed';
                            }

                            var tmp{{ $o.$r }} = {};
                            for (var i = 0; i < datesnotConfirmed{{ $o.$r }}.length; i++) {
                                tmp{{ $o.$r }}[datesnotConfirmed{{ $o.$r }}[i]] = 'notconfirmed';
                            }


                            Object.assign(eventDates{{ $o.$r }}, tmp{{ $o.$r }});


                            $(function () {

                                $(".reservation_calendar" + {{ $o.$r }}).datepicker({
                                    dateFormat: "dd-mm-yy",
                                    minDate: new Date($('#hiddendelivdate').val()),
                                    monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                                    dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],


                                    onSelect: function (date/* data->date */) {

                                        $('.hidden_' + {{ $o.$r }}).hide();
                                        $('.loader_' + {{ $o.$r }}).show();

                                        App.GetReservationData({{ $room->id }}, {{ $o.$r }}, date);

                                    },
                                    beforeShowDay: function (date) {
                                        var tmp = eventDates{{ $o.$r }}[$.datepicker.formatDate('mm/dd/yy', date)];

                                        if (tmp) {
                                            if (tmp == 'confirmed')
                                                return [true, 'reservationconfirmed'];
                                            else
                                                return [true, 'reservationnotconfirmed'];
                                        } else
                                            return [false, ''];

                                    }


                                });
                            });


                        </script>
                    @endpush

                    <h4> Номер {{ $room->id }} в "{{$room->object->name}}"

                        <small class="text-black"><i>адрес: г. {{$room->object->city->name}},
                                ул.{{$room->object->address->street}}
                                , {{$room->object->address->number}}.
                                @if( Auth::user()->hasRole(['owner', 'admin']) )
                                    тел. {{\App\User::find($room->object->user_id)->phone}}.
                                    Контакт: {{\App\User::find($room->object->user_id)->name}}
                                @endif
                            </i></small>
                    </h4>

                    <div class="row mt-3 mr-3">
                        <div class="col-md-3 mb-3">
                            <div class="reservation_calendar{{ $o.$r}}"></div>
                        </div>
                        <div class="col-md-9">
                            <div class="text-center text-danger mb-2"><b>Кликните в календаре</b> по любой дате,
                                входящей в нужное Вам бронирование.
                            </div>
                            <div class="center-block loader loader_{{ $o.$r}}" style="display: none;"></div>
                            <div class="hidden_{{ $o.$r }}" style="display: none;">


                                <div class="row">
                                    <div class="col">
                                        <div class="row mb-3 bg-light-dark shadow-sm py-2">
                                            <div class="col">
                                                <span class="font-weight-bold">Бронирование № </span><span
                                                    class="reservation_data_person"></span>
                                            </div>
                                            @if( Auth::user()->hasRole(['owner', 'admin']) )
                                                <div class="col"><a href="#"
                                                                    class="btn reservation_data_confirm_reservation">Подтвердить</a>
                                                </div>
                                            @endif
                                            @if( Auth::user()->hasRole(['tourist']) )
                                                <div class="col">
                                                    <div class="reservation_data_confirm_reservation_wait"><i
                                                            class="fas fa-hourglass-half rotate-hourglass"></i> Ожидает
                                                        подтверждения
                                                    </div>
                                                </div>
                                            @endif

                                            @if( Auth::user()->hasRole(['owner']) )
                                                <div class="col">Удалить: <a
                                                        class="reservation_data_delete_reservation keep_pos"
                                                        href=""><i class="fas fa-trash "></i></a></div>
                                            @endif


                                            @if( Auth::user()->hasRole(['admin']) )
                                                <div class="col">Удалить: <a
                                                        class="reservation_data_delete_reservation_admin keep_pos"
                                                        href=""><i class="fas fa-trash "></i></a></div>
                                            @endif


                                        </div>
                                        <div class="row mb-3 bg-light-dark shadow-sm py-2">
                                            <div class="col">
                                                <div class="font-weight-bold">Номер</div>
                                                <div class="reservation_data_room_number"></div>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-bold">Заезд</div>
                                                <div class="reservation_data_day_in"></div>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-bold">Выезд</div>
                                                <div class="reservation_data_day_out"></div>
                                            </div>
                                        </div>

                                        @if( Auth::user()->hasRole(['owner', 'admin']) )
                                            <div class="row  bg-light-dark p-1 mb-3  shadow-sm py-2">
                                                <div class=" col reservation_data_price"></div>
                                                <div class=" col reservation_data_comission"></div>
                                                <div class=" col reservation_data_reward"></div>
                                            </div>
                                        @endif

                                        <div class="row  bg-light-dark p-1 mb-3  shadow-sm py-2">
                                            <div class=" col reservation_data_description"></div>
                                        </div>
                                        @if( Auth::user()->hasRole(['tourist']) && $reservation->status)
                                            <div class="col text-center">
                                                <a href="{{route('sendMailToGuestRepeat',['id'=>$reservation->id])}}"><i
                                                        class="fas fa-envelope-open-text"></i> Выслать билет
                                                    повторно</a>
                                            </div>
                                        @endif


                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>


                </div>
            @endforeach
        @endforeach

@foreach($authUserObject as $object)
    @if(count($object->rooms) == 0)
                @push('scripts')
                    <script>


                        const modal = $$.modal({
                            modalHeaderText: 'Необходимо добавить <b>номер</b> к <b>"{{$object->name}}"</b>',
                            modalBodyText: 'Для того, чтобы объект <b>"{{$object->name}}"</b> начал отображаться в поиске, необходимо добавить хотябы 1 номер с описанием, и стоимостью. Даже если вы сдаете квартиру или дом, все равно нужно добавить номер, как будто у Вас отель, в котором 1 номер. Ведь нельзя указать стоимость отеля за сутки, можно указать только стоимость номера за сутки :)',
                            modalButtonText: 'Добавить номер к <b>"{{$object->name}}"</b>',
                            href: '{{ route('saveRoom').'?object_id='.$object->id  }}',
                            closable: true,
                        })
                        modal.open()
                    </script>

                @endpush
@endif
    @endforeach










        @if( Auth::user()->hasRole(['admin']) )
            {{ $objects->links() }}
        @endif
    </div>
@endsection

