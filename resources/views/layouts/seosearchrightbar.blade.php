@forelse($rooms as $room)
    @push('scripts')
        <script>
            function getCookie(name) {
                let matches = document.cookie.match(new RegExp(
                    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                ));
                return matches ? decodeURIComponent(matches[1]) : undefined;
            }

            function setLookedStatus() {

                if (getCookie('room_seen' + {{$room->id}}) != undefined) {

                    document.querySelector('.room_seen{{$room->id}}').classList.add('looked')
                }
            }

            setLookedStatus();


        </script>
    @endpush

    @include('layouts.card')




@empty

    <div class="border-orange m-2">
        <div class=" border-bottom text-center p-3 bg-light"> Извините, на данный момент нет открытых дат
            в {{$h1seo}} ;-(<br>Попробуйте выбрать
            другой курорт.
            <h3 class="m-3">Открывайте новые места!</h3>
            <div class="row mt-3">
                @include('layouts.citylist')
            </div>
        </div>
    </div>
@endforelse


<div class="col text-center">

    {{--                        {{$rooms->list()}}--}}
    {!! $rooms->render() !!}

</div>

