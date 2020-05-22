@extends('layouts.backend')

@section('content')


    <div class="app">
        <h3 class="about__title">Календарь бронирований</h3>
        <div class="col-xl-4 line"></div>

        @if (count($objects) == 0)
            <div class="container">
                <div class="row justify-content-center">
                    <div class="panel panel-success top-buffer shadow-lg align-content-center p-5 my-5 h100rem">
                        <div class="mt50">
                            <h3 class="panel-title text-center"> Здесь будут отображаться Ваши бронирования
                            </h3>
                            @if( Auth::user()->hasRole(['owner']) )

                                <h3 class="panel-title text-center"> Просмотрите, пожалуйста, <a
                                        href="https://youtu.be/ouw9i6XIBGc">видеоинструкцию</a> по пользованию сервисом.
                                </h3>
                                <div class="text-center">
                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/ouw9i6XIBGc"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                </div>
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
                                for (let i = 0; i < 12; i++) {
                                    $(".reservation_calendar" + {{ $o.$r }}+i).datepicker({

                                        dateFormat: "dd-mm-yy",
                                        numberOfMonths: 1,
                                        defaultDate: '+' + i + 'm',
                                        minDate: new Date($('#hiddendelivdate').val()),


                                        onSelect: function (date/* data->date */) {

                                            $('.hidden_' + {{ $o.$r }}).hide();
                                            $('.loader_' + {{ $o.$r }}).show();


                                                {{--let div = document.createElement('div');--}}
                                                {{--div.classList.add('.hidden_' + {{ $o.$r }})--}}
                                           App.GetReservationData({{ $room->id }}, {{ $o.$r }}, date);
                                            {{--console.log( App.GetReservationData({{ $room->id }}, {{ $o.$r }}, date))--}}
                                           {{--let makeReservation = function() {--}}

                                               {{--function reservationForm() {--}}
                                                   {{--let div = document.createElement('div');--}}
                                                   {{--div.style.position = 'absolute';--}}
                                                   {{--div.style.height = '100px';--}}
                                                   {{--div.style.width = '100px';--}}
                                                   {{--div.innerHTML = 'ofvanvianv';--}}

                                               {{--}--}}

                                                {{--for (let index of datesnotConfirmed{{ $o.$r}}) {--}}
                                                    {{--// console.log(index, date)--}}
                                                    {{--if (index != date) {--}}
                                                      {{--reservationForm--}}
                                                    {{--}--}}

                                                {{--}--}}

                                           {{--};--}}
// makeReservation()
                                        },
                                        beforeShowDay: function (date) {
                                            var tmp = eventDates{{ $o.$r }}[$.datepicker.formatDate('mm/dd/yy', date)];

                                            // if (tmp) {
                                                if (tmp == 'confirmed') {
                                                    return [true, 'reservationconfirmed'];
                                                }

                                                else if (tmp == 'notconfirmed') {
                                                    return [true, 'reservationnotconfirmed'];
                                                }

                                                else  if (tmp == undefined){
                                                    // console.log('111')
                                                    return [true, 'reservationoped']; //Я придумал
                                                }

                                            // }


                                        }


                                    });
                                }
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
                        @for ($i = 0; $i < 12; $i++)


                            <div class="col-md-3 mb-3">
                                <div class="reservation_calendar{{ $o.$r.$i}}"></div>
                            </div>
                        @endfor

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



        @if( Auth::user()->hasRole(['admin']) )
            {{ $objects->links() }}
        @endif
    </div>

    @push('scripts')
        <script>


            function qqqqq() {

                let output  = $.ajax({
                    type: 'POST',
                    url: '/getNotifications',
                    // data: 'searchValue='+searchValue+'&field='+field+'&eventId='+eventId,
                    dataType : "json",
                    success: function (data) {
                        output = data;
                      console.log(output)
                    }
                })

                // console.log(output)
                return output;
            };
         qqqqq()
        </script>
    @endpush
@endsection

