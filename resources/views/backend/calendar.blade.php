@extends('layouts.backend') <!-- Lecture 5  -->

@section('content') <!-- Lecture 5  -->

<section id="reservation">

    <h3>Забронировать</h3>

    <div class="row">



            <form {{$novalidate}} method="POST" action="{{ route('calendar1')}}">
                @CSRF

                <div class="col-md-2">
                <div class="form-group">
                    <label for="period1start">Период 1 начало</label>
                    <input required type="text" class="form-control datepicker" name="period1start"
                           placeholder="" value="01-01">
                </div>

                <div class="form-group">
                    <label for="period1end">Период 1 конец</label>
                    <input required type="text" class="form-control datepicker" name="period1end"
                           placeholder="" value="01-05">
                </div>

                 <div class="form-group">
                    <label for="price1">Цена</label>
                    <input required name="checkout" type="text" class="form-control datepicker"
                           placeholder="" name="price1">
                </div>

                </div>
                <!-- Lecture 34 -->

                    <button type="submit" class="btn btn-primary">Забронировать</button>



            </form>



        <br>
        <div class="col-md-6">
            <div id="avaiability_calendar">

            </div>
        </div>
    </div>


</section>


@endsection <!-- Lecture 5  -->

@push('scripts') <!-- Lecture 20 -->

<!-- Lecture 20 -->
<script>

    $('.checkin').datepicker({
        dateFormat: "dd-mm-YYYY",
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
    });

</script>

@endpush <!-- Lecture 20 -->




