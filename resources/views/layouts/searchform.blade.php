<div class="container">
    <form class="" method="POST" action="{{ route('roomSearch') }}">

        <div class="form-serch form-row align-items-center py-2">
            <div class="col-xl-2 col-12 py-2">
                <input name="city" value="{{ old('city')}}" type="text"
                       class="form-control autocomplete" id="city" placeholder="Куда вы едете?">
            </div>
            <div class="col-xl-2 col-6">
                <div class="input-group">

                    <input name="checkin" value="{{ old('check_in')}}" type="text"
                           class="form-control datepicker form-control-right-in" id="check_in"
                           placeholder="Дата заезда" autocomplete="off">

                    <div class="input-group-append  cursor-date-in">
                        <button class="btn btn_date btn_date_in">
                            <i class="far fa-calendar-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div id="date_range"></div>
            <div class="col-xl-2 col-6">
                <div class="input-group">
                    <input name="checkout" value="{{ old('check_out') }}" type="text"
                           class="form-control datepicker form-control-right-out" id="check_out"
                           placeholder="Дата отъезда" autocomplete="off">

                    <div class="input-group-append cursor-date-in">
                        <button class="btn btn_date btn_date_out" >
                            <i class="far fa-calendar-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-12 py-2">
                <select name="room_size" class="form-control invisible selected-guest">
                    <option selected>Кол-во гостей</option>


                </select>


                <div class="choice-visible flex border-gray guests text-black justify-content-around align-content-center">
                    {{--<div class=" flex  guest-wrapper-css hidden text-black px-0 py-2">--}}
                    <div class="choice-adults"><i class="fas fa-user-tie"></i> <span class="ml-1 adults-visible"> 1 </span> чел.</div>
                    <div class="choice-children"><i class="fas fa-baby"></i><span class="ml-1 children-visible"> 0 </span> чел.</div>
                </div>

                <div class="guests-wrapper anim">

                    <div class="guest-wrapper-css p-2">
                        <div class="text-center bolded pb-2">Взрослые</div>
                        <div class="guests-flex px-2">
                            <div class="adult-minus"><i class="far fa-minus-square"></i></div>
                            <div>
                                <span class="adults-counter">1</span>
                                чел.
                            </div>
                            <div class="adult-plus"><i class="far fa-plus-square"></i></div>
                        </div>
                    </div>

                    <div class="guest-wrapper-css p-2">
                        <div  class="text-center bolded pb-2 ">Дети</div>
                        <div class="guests-flex px-2">
                            <div class="children-minus"><i class="far fa-minus-square"></i></div>
                            <div>
                                <span class="children-counter">0</span>
                                чел.
                            </div>
                            <div class="children-plus"><i class="far fa-plus-square"></i></div>
                        </div>
                    </div>


                    <a class="btn choice__button w-100 guests gotovo text-white">готово</a>

                </div>

            </div>
            <div class="col-xl-2 col-12">
                <button type="submit" class="btn px-4  w-100 choice__button ">Узнать цены</button>
            </div>
            {{ csrf_field() }}
        </div>
    </form>
</div>
