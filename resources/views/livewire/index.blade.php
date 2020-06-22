<div>
    <div class="row p-0 m-0">
        <div class="card-main-page-wrapper">
            @foreach($objects as $object)
                <div class="card-main-page-index">
                    <div class="card-main-page__photo-index">
                        <div class="card-main-page__photo-wrapper">
                            <a href="{{ route('object',['id'=>$object->id]) }}">
                                <img src="{{ $object->photos->first()->path ?? $placeholder}}"
                                     alt="{{ str_limit($object->description,150) }}">
                            </a>
                        </div>
                    </div>
                    <div class="card-main-page__content-index">
                        <div class="card-main-page__content-wrapper">
                            <div class="card-main-page__content-wrapper-row-1">
                                <div class="">
                                    <i class="fas fa-map-marker-alt"></i> {!! $object->city->name ?? null!!}
                                </div>
                                <div class="">
                                    море: {{$object->distance->title ?? null}}

                                </div>

                            </div>
                            <div class="card-main-page__content-wrapper-row-2">
                                <div class="">
                                    {{$object->name ?? null}}
                                </div>
                            </div>
                            <div class="card-main-page__content-wrapper-row-3">
                                <div class="">

                                    {{ str_limit($object->description,100) }}
                                </div>
                            </div>
                            <div class="card-main-page__content-wrapper-row-4">
                                <div class="">
                                    <a href="{{ route('object',['id'=>$object->id]) }}"
                                       class="btn btn-detailed"
                                       role="button">Подробнее</a>
                                </div>
                                <div class="">

                                    от <span> {{$object->rooms->first()->price ?? null}} </span> &#8381;

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col mt-3">

            {{ $objects->links() }}

        </div>
    </div>
</div>
