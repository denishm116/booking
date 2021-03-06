<div class="card-main-page">

    <div class="card-main-page__photo">
        <div class="card-main-page__photo-wrapper-card">

            <div class="card-main-page__photo-row1">
                <div class="card-main-page__photo-header room_seen{{$room->id}}">
                    <a
                        href="{{ route('room',['id'=>$room->id]) }}">Номер ID
                        {{$room->id}}
                    </a>
                </div>
            </div>
            <div class="card-main-page__photo-row2">
                <div class="card__photo-wrapper">
                    <div class="for-star-icon">
                        <a href="{{ route('room',['id'=>$room->id]) }}">

                            <img class="" src="{{ $room->photos->first()->path ?? $placeholder}}"

                                 alt="{{ str_limit($room->description,150) }}">
                            <div class="star-icon">
                                <small> {!!$room->object->rating!!}</small>
                            </div>
                        </a>
                    </div>


                </div>
            </div>


        </div>
    </div>

    <div class="card-main-page__content">

        <div class="card-main-page__content-wrapper">

            <div class="card-main-page__content-wrapper-row-1">
                <div class="">
                    <i class="fas fa-map-marker-alt"></i> {!! $room->object->city->name ?? null!!}

                </div>
                <div class="">
                    <i class="fas fa-water"></i> море: {{$room->object->distance->title ?? null}}

                </div>

            </div>

            <div class="card-main-page__content-wrapper-row-2">
                <div class="card-main-page__content-wrapper-row-2-1">
                    <div class="">
                        @foreach($room->object->types as $type)
                            @if($type->id === 6)
                                {{$room->room_number}}-комнатная квартира
                                @break;
                            @elseif ($type->id === 7)
                                {{$room->room_number}}-комнатный дом
                                @break;
                            @elseif ($type->id === 10)
                                {{$room->room_number}}-комнатный коттедж
                                @break;
                            @else
                                {{$room->room_size}}-местный номер
                                @break;
                            @endif
                        @endforeach

                    </div>

                    @if  (Request::is('favourites/*'))
                        <div class="">
                            <a href="#"
                               class="favorite-delete" data="{{$room->id}}"
                               role="button"><i class="fas fa-heart"></i> удалить</a>
                        </div>
                    @else

                        <div class="">
                            <a href="{{route('room', ['id' => $room->id])}}"
                               class="favourites-button" data="{{$room->id}}"
                            > <i class="far fa-heart"> </i> в избранное</a>
                        </div>
                    @endif


                </div>
                <div class="card-main-page__content-wrapper-row-2-2">
                    <div>
                        <span> <a
                                href="{{ route('room',['id'=>$room->id]) }}">Название: {{$room->display_name ?? $room->id}}</a></span>
                    </div>
                    <div>

                    </div>
                </div>

            </div>

            <div class="card-main-page__content-wrapper-row-3">

                @forelse($room->rservices as $service)
                    <div class="content-wrapper-row-3">
                        <i class="fas fa-angle-down"> </i> {{$service->title}}

                    </div>
                @empty
                @endforelse


            </div>

            <div class="card-main-page__content-wrapper-row-4">
                <a href="{{route('object', ['id' => $room->object->id])}}">Объект: {{$room->object->name}}</a>
            </div>

            <div class="card-main-page__content-wrapper-row-5">
                <div class="">
                    <a href="{{ route('room',['id'=>$room->id]) }}"
                       class="btn choice__button choice__button__small"
                       role="button">забронировать</a>
                </div>

                <div class="">
                    <a href="{{ route('room',['id'=>$room->id]) }}"
                       class="btn btn-detailed"
                       role="button">подробнее</a>
                </div>

                <div class="">

                    от <span> {{$room->price ?? null}} </span> &#8381;

                </div>

            </div>


        </div>
    </div>

</div>
