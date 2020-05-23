@extends('layouts.backend')

@section('content')


    @if( $room ?? false )
        <h2 class="about__title  ml-3">Редактирование номера {{ $room->id}}
            объекта {{ $room->object->name }}</h2>
        <div class="col-xl-4 line  ml-3"></div>

    @else
        <h2 class="about__title ml-3">Добавить номер к объекту {{$room->object ?? ''}}</h2>
        <div class="col-xl-4 line  ml-3"></div>
    @endif

    <form {{ $novalidate }} action="{{ route('saveRoom',['id'=>$room->id ?? false]) }}"
          method="POST" enctype="multipart/form-data" class="form-horizontal mt-4" id="save_form">
        <fieldset>
            <div class="form-group">
                <label for="roomNumber" class="col-lg-2 control-label">Количество комнат *</label>
                <div class="col-lg-12">
                    <input name="room_number" value="{{ $room->room_number ?? old('room_number')}}"
                           required type="number" class="form-control" id="roomNumber" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="peopleNumber" class="col-lg-2 control-label">Количество мест *</label>
                <div class="col-lg-12">
                    <input name="room_size" value="{{ $room->room_size ?? old('room_size') }}" required
                           type="number" class="form-control" id="peopleNumber" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="price" class="col-lg-2 control-label">Базовая стоимость *</label>
                <div class="col-lg-12">
                    <input name="price" value="{{ $room->price ?? old('price') }}" required type="number"
                           class="form-control" id="price" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="descr" class="col-lg-2 control-label">Описание номера (не менее 100 символов) *</label>
                <div class="col-lg-12">
                <textarea name="description" required class="form-control" rows="3"
                          id="descr">{{ $room->description ?? old('description')  }}</textarea>
                </div>
            </div>

            <div class="col-lg-12 shadow-sm p-3 m-3 mt-5">
                <label for="roomPictures">Фото интерьера (размер одного фото не должен превышать 5мб)</label>
                <input type="file" name="roomPictures[]" id="roomPictures" multiple>

            </div>


            @if( $room ?? false )
                <div class="col-lg-12 col-lg-offset-2">

                    @foreach( $room->photos->chunk(4) as $chunked_photos )

                        <div class="row">


                            @foreach( $chunked_photos as $photo )

                                <div class="col-md-4 col-sm-6 m-2">
                                    <div class="thumbnail mb-4 p-1
                                        @if ($photo->main_photo ?? false )
                                        bradius_backend shadow-lg
                                        @else
                                        bradius
                                        @endif
                                        ">
                                        <img class="img-responsive img-thumbnail"
                                             src="{{ $photo->path ?? $placeholder }}" alt="{{$photo->id ?? false}}">

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
            @endif

            <div class="form-group">
                <div class="col-lg-3 shadow-sm m-3 mt-5">

                    <h5 class="card-title">Дополнительные услуги</h5>

                    @foreach($rservices as $rservice)
                        <div>
                            <input type="checkbox" name="rservices[]" value="{{$rservice->id}}"
                                   @isset($room)
                                   @foreach($room->rservices as $rservi)

                                   @if($rservi->id == $rservice->id)
                                   checked
                                @endif

                                @endforeach
                                @endisset
                            >
                            <label class="form-check-label" for="rservices[]">{{$rservice->title}}</label>
                        </div>
                    @endforeach


                </div>
            </div>
            <div class="container">

                <div class="col-lg-12 col-sm-12 text-center shadow-lg mt-3">
                    <div class="row bg-light-dark p-1">
                        <div class="col"><h5>Стоимость по месяцам</h5>
                            <h6>(Стоимость за сутки может оличаться от базовой стоимости. В курортный сезон цена может
                                быть выше)</h6>
                        </div>
                    </div>

                    <div class="row block-parent">

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

                            @if($i == 1 || isset($periodStart) && isset($periodEnd))

                                {{--<div class="bg-light p-1 periodBlock">--}}
                                <div class=" col-12 col-lg-2 bg-light p-1 periodBlock">
                                    <h6>{{$i}} период</h6><span class="far fa-window-close pull-right deletePeriod"
                                                           title="Удалить период"></span>
                                    <div>с (гггг-мм-дд) <input autocomplete="off" required type="text"
                                                               class="form-control checkin"
                                                               name="period_start[]"
                                                               placeholder=""
                                                               value="@if( $room ?? false ){{$periodStart ?? old('period'.$i.'start')}}@else{{'2020-01-01'}}@endif">
                                    </div>
                                    по (гггг-мм-дд)
                                    <input autocomplete="off" required type="text" class="form-control checkout"
                                           name="period_end[]"
                                           placeholder=""
                                           value="@if( $room ?? false ){{$periodEnd ?? old('period'.$i.'end')}}@else{{'2020-03-31'}}@endif">
                                    <div class="mt-2">
                                        Цена<input required type="text"  class="form-control"
                                                   placeholder="" name="prices[]"
                                                   value="@if( $room ?? false ){{$periodPrice ?? old('price'.$i)}}@endif">
                                    </div>
                                </div>

                            @endif

                        @endfor
                            <div class="inner"></div>
                        <div
                            class="col-12 col-lg-2 bg-light p-1 justify-content-center align-self-center add-item-button"
                            title="Добавить период">
                            <i class="far fa-plus-square fa-4x add-item" id="add-period-item"></i>
                        </div>

                        <div
                            class="col-12 col-lg-2 bg-light p-1 justify-content-center align-self-center add-item-disabled-button"
                            title="Создано максимум периодов">
                            <i class="far fa-plus-square fa-4x disabled"></i>
                        </div>
                    </div>
                </div>

                <div class="alert alert-danger hidden" role="alert" id="periods_errors_container">

                </div>

            </div>

            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2 mt-3">
                    <button id="form_submit" type="submit" class="btn choice__button">Сохранить</button>
                </div>
            </div>

        </fieldset>
        <input type="hidden" name="room_id" value="{{ $room->id ?? null }}">
        <input type="hidden" name="object_id" value="{{ $object_id ?? null}}">
        {{ csrf_field()  }}
    </form>
@endsection

@push('scripts')
    <script>

        let windowWidth=document.body.clientWidth;
        let numberOfMonth = 2
        $(document).ready(function () {

            const maxPeriodsAllowed = 12;

            let defaultPrice = document.querySelector('#price');

            defaultPrice.onchange = () => document.querySelector('#price1').value =  defaultPrice.value;

            function addPeriod(){

                let periodBlock = $(".periodBlock").last().clone()


                $(periodBlock).insertBefore('.add-item-button')


                let periodBlockInputInTemp = $(".periodBlock input");
                let periodBlockInputIn = periodBlockInputInTemp[periodBlockInputInTemp.length - 3];
                let periodBlockInputOut = periodBlockInputInTemp[periodBlockInputInTemp.length - 2];
                let periodPrice = periodBlockInputInTemp[periodBlockInputInTemp.length - 1];
                let h6allDomElements = document.querySelectorAll('.periodBlock h6');
                let h6lastWithTag = h6allDomElements[h6allDomElements.length - 2];
                let h6LastNumber = h6lastWithTag.innerHTML[0];
                let firstPeriodNotSelected = false
                h6allDomElements[h6allDomElements.length - 1].innerHTML = +h6LastNumber + 1 + ' период';

                periodBlockInputIn.classList.remove('hasDatepicker')
                periodBlockInputIn.removeAttribute('id')
                periodBlockInputOut.classList.remove('hasDatepicker')
                periodBlockInputOut.removeAttribute('id')

                let dateStart = new Date(periodBlockInputOut.value);


                let dateEndVal = new Date(periodBlockInputOut.value);
                let monthEnd = dateStart.getMonth() + 1
                let dayEnd = dateStart.getDate() + 1

                let monthEndOurFormat = new Date(dateEndVal.setMonth(monthEnd))
                let dayStartOurFormat = new Date(dateStart.setDate(dayEnd))
                // console.log(dayStartOurFormat)

                let dayEndOurFormat = new Date(monthEndOurFormat.setDate(dayEnd + 1))

                periodBlockInputIn.value =dayStartOurFormat.toISOString().split('T')[0]

                periodBlockInputOut.value = dayEndOurFormat.toISOString().split('T')[0]


                // console.log(date)
                //

                 // ширина окна
               if (windowWidth < 600) {
                   numberOfMonth = 1;
                   // console.log(numberOfMonth)
               }

                $([periodBlockInputIn, periodBlockInputOut]).datepicker({
                    range: 'period',
                    numberOfMonths: numberOfMonth,
                    dateFormat: 'yy-mm-dd',


                    onSelect: function (dateText, inst, extensionRange) {
                        // extensionRange - объект расширения
                        $(periodBlockInputIn).val(extensionRange.startDateText);
                        $(periodBlockInputOut).val(extensionRange.endDateText);

                        periodBlockInputIn.onclick = function() {
                            firstPeriodNotSelected = false;
                        };

                        if (!firstPeriodNotSelected) {
                            periodBlockInputOut.focus();
                            firstPeriodNotSelected = true;
                        }

                        if (!firstPeriodNotSelected || extensionRange.startDateText < extensionRange.endDateText) {
                            setTimeout(function () {
                                $(periodBlockInputOut).datepicker('hide')
                                periodPrice.focus();
                            }, 1000)
                        }
                    }

                })

                var periodsAmount = $(".periodBlock").length;
                if(periodsAmount >= maxPeriodsAllowed){
                    $('.add-item-button').hide();
                    // $('.add-item-disabled-button').show();
                }
                $('.deletePeriod').show();
            }

            var periodsAmount = $(".periodBlock").length;
            if(periodsAmount === 0){
                addPeriod();
            }

            $('.add-item').hover(function () {
                $(this).removeClass('fa-4x');
                $(this).addClass('fa-5x');
            }, function () {
                $(this).removeClass('fa-5x');
                $(this).addClass('fa-4x');
            });

            $('#add-period-item').click(function(){

                addPeriod();
            });

            $(document).on("click", ".deletePeriod" , function() {
                $(this).parent().remove();


                var periodsAmount = $(".periodBlock").length;
                if(periodsAmount < maxPeriodsAllowed){
                    $('.add-item-disabled-button').hide();
                    $('.add-item-button').show();
                }

                if(periodsAmount <= 1){
                    $('.deletePeriod').hide();
                }

            });

        });


// function datepickers(elementStart, ElementEnd, price, numberOfMonth, firstPeriodNotSelected) {
//
//     $(elementStart, ElementEnd).datepicker({
//         range: 'period',
//         numberOfMonths: numberOfMonth,
//         dateFormat: 'yy-mm-dd',
//         onSelect: function (dateText, inst, extensionRange) {
//             // extensionRange - объект расширения
//             $(elementStart).val(extensionRange.startDateText);
//             $(ElementEnd).val(extensionRange.endDateText);
//
//             elementStart.onclick = function() {
//                 firstPeriodNotSelected = false;
//             };
//
//             if (!firstPeriodNotSelected) {
//                 ElementEnd.focus();
//                 firstPeriodNotSelected = true;
//             }
//
//             if (!firstPeriodNotSelected || extensionRange.startDateText < extensionRange.endDateText) {
//                 setTimeout(function () {
//                     $(ElementEnd).datepicker('hide');
//                     price.focus();
//                 }, 1000)
//             }
//
//         }
//     });
// }

        function initDatepickers(){
            let periodStartElement = document.getElementsByName('period_start[]');
            let periodEndElement = document.getElementsByName('period_end[]');
            let periodPrice = document.getElementsByName('prices[]');
            let firstPeriodNotSelected = false;
            let blocksCounter = document.querySelectorAll('.periodBlock');

            if (windowWidth < 600) {
                numberOfMonth = 1;

            }


            for (let i = 0; i < periodStartElement.length; i++) {

                $([periodStartElement[i], periodEndElement[i]]).datepicker({
                    range: 'period',
                    numberOfMonths: numberOfMonth,
                    dateFormat: 'yy-mm-dd',
                    onSelect: function (dateText, inst, extensionRange) {
                        // extensionRange - объект расширения
                        $(periodStartElement[i]).val(extensionRange.startDateText);
                        $(periodEndElement[i]).val(extensionRange.endDateText);
                        periodStartElement[i].onclick = function() {
                            firstPeriodNotSelected = false;
                        };

                        if (!firstPeriodNotSelected) {
                            periodEndElement[i].focus();
                            firstPeriodNotSelected = true;
                        }

                        if (!firstPeriodNotSelected || extensionRange.startDateText < extensionRange.endDateText) {
                            setTimeout(function () {
                                $(periodEndElement[i]).datepicker('hide')
                                periodPrice[i].focus();
                            }, 1000)
                        }

                    }
                });

            }
        }

        $(document).ready(function () {

            function deparam(query) {
                var pairs, i, keyValuePair, key, value, map = [];
                map['period_start'] = [];
                map['period_end'] = [];
                map['prices'] = [];
                // remove leading question mark if its there
                if (query.slice(0, 1) === '?') {
                    query = query.slice(1);
                }
                if (query !== '') {
                    pairs = query.split('&');
                        for (i = 0; i < pairs.length; i += 1) {
                        keyValuePair = pairs[i].split('=');
                        // console.log('keyValuePair: ' + keyValuePair);
                        key = decodeURIComponent(keyValuePair[0]);
                        // console.log('KEY: ' + key);
                        value = (keyValuePair.length > 1) ? decodeURIComponent(keyValuePair[1]) : undefined;

                        if (key.slice(-2) === "[]" && key !== 'rservices[]') {
                            let arrKey = key.slice(0, -2);
                            map[arrKey].push(value);
                        }
                    }
                }

                return map;
            }

            initDatepickers();

            // form_id = form-horizontal mt-4
            $('#form_submit').click(function (e) {
                let form_data = $('#save_form').serialize();
                let form_data_deserialised = deparam(form_data);
                let errors = [];

                for (let i = 0; i < form_data_deserialised['period_start'].length; i++) {
                    let start_value_current = new Date(form_data_deserialised['period_start'][i]);
                    let end_value_previous = new Date(form_data_deserialised['period_end'][i - 1]);
                    let Difference_In_Days = (start_value_current.getTime() - end_value_previous.getTime()) / (1000 * 3600 * 24);

                    if (Difference_In_Days > 1) {
                        errors.push('Разница даты начала в поле "' + (i + 1) + ' период" и даты завершения в поле "' + i + ' период" не может быть больше чем 1 день');
                    } else if (Difference_In_Days < 1) {
                        errors.push('"Период ' + (i + 1) + '" не может пересекатся с "периодом ' + i + '"');
                    }
                }

                if (errors.length) {
                    $('#periods_errors_container').removeClass('hidden').html(errors.join('<br>'));

                    return false;
                }
            });
        });



    </script>


@endpush
