@extends('layouts.layout')

@section('title', 'Отдых в Крыму 2020 цены, жилье для отдыха у моря. Курорты Крыма для отдыха летом')

@section('description', 'Отдых в Крыму в 2020 году: гостиницы, частный сектор, гостевые дома с отзывами. Фотографии, описание, бронирование жилья у моря.')

@section('canonical', 'canonical')
@section('canonical-address', 'https://krim-leto.ru')

@section('content')

    @include('layouts.indexheader')

    @if (session('norooms'))
        <div class="text-center red bolded">
            {{ session('norooms') }}
        </div>
    @endif
    @push('scripts')
        <script>
            $(document).ready(function () {
                const card = document.querySelector('.rotate-container');
                const cardItem = this.querySelector('.rotate-card');
                const halfHeight = cardItem.offsetHeight / 2;
                card.addEventListener('mousemove', rotate)
                card.addEventListener('mouseout', rotate0)

                function rotate(event) {

                    cardItem.style.transform = 'rotateX(' + -(event.offsetY - halfHeight) / 120 + 'deg) rotateY(' + (event.offsetX - halfHeight) / 85 + 'deg)'
                }


                function rotate0() {
                    cardItem.style.transform = 'rotateX(0deg) rotateY(0deg)'
                }


            });
        </script>

    @endpush

    <main>
        <div class="container">

            <div class="row">
                <div class="col-xl-12 col-12">
                    <h2 class="about__title">Где остановиться</h2>
                    <div class="col-xl-4 line"></div>
                </div>
            </div>


            <div class="row justify-content-around my-3 ">

                @foreach($types as $type )
                        {{--<div class="col">--}}
                    <a href="{{  route('type',['city'=> 'krim', 'type'=>$type->alias ?? false] ) }}">
                        <div class="objects__category col-sm-auto col-lg-auto objects__category__type__seo">

                            {{$type->title}}
                        </div>
                    </a>
                        {{--</div>--}}
                @endforeach

            </div>

            <div class="row">
                <div class="col-xl-8">

                    <div class="row ">
                        @include('layouts.citylist')
                        {{--<div class="col-xl-3 col-6">--}}
                            {{--<a class="town"--}}
                               {{--href="#">еще...</a>--}}

                        {{--</div>--}}
                    </div>

                    <div class="row shadow-text mt-3">
                        <div class="col">

                            <h2>Такой разный Крым.</h2>
                            <p class="seo-text">Для многих людей Крым – это море и горы. Не все знают, что большую часть
                                территории
                                (почти
                                63%)
                                занимает степь. Путешествуя по степным районам Крыма, трудно поверить, что стоит
                                преодолеть всего сотню
                                километров, и
                                взору откроется совсем иной Крым – его южное побережье с горами и буйной
                                средиземноморской
                                растительностью.

                                Западное побережье радует глаз красивейшими скалистыми берегами: мыс Тарханкут, а южнее
                                него
                                –
                                мыс Айя с живописным пляжем, который любители уединенного отдыха называют Затерянным
                                миром.</p>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 rotate-container shadow-text">


                    <img class="rotate-card" src="images/shadow.png" alt="Бронирования в Крыму">

                </div>
            </div>


            <div class="row mb-3 justify-content-around">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <h2 class="about__title">Популярные запросы</h2>
                            <div class="col-xl-4 line"></div>

                        </div>
                    </div>


                    <div class="row justify-content-center">


                        @foreach($conditions as $condition )
                            <a href="{{ route('cityConditions',['alias'=>'krim' ?? false, 'condition' => $condition[1]] ) }}">
                                <div class="objects__category col-sm-auto col-lg-auto objects__category__type__seo col">

                                    {{$condition[2]}}
                                    ({{$condition[0]}})

                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>


        <section class="cards__popular__object py-5">

            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <h2 class="about__title">Последние добавленные объекты</h2>
                        <div class="col-xl-4 line pb-3"></div>
                    </div>

                </div>

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

                                        {{--<div class="text-center p-0 m-0)">--}}
                                        {{--<small> {!! $object->rating ?? null!!}</small>--}}
                                        {{--</div>--}}
                                        {{--<div class="p-0 m-0 text-center">--}}
                                        {{--<small><i>рейтинг </i></small>--}}
                                        {{--</div>--}}


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
        </section>

        <div class="container">

            <section class="articles mb-5" id="articles">
                <article class="seo-block">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12 col-12 py-3">
                                <h2 class="about__title">Отдых в&nbsp;Крыму</h2>
                                <div class="col-xl-4 line"></div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col">

                                <p class="seo-text text-justify">Крымский полуостров&nbsp;&mdash; достаточно известное
                                    место
                                    отдыха еще со&nbsp;времен Российской империи. Недаром здесь возводили дворцы
                                    императоры
                                    и&nbsp;знать. Еще в&nbsp;19 веке, когда по&nbsp;настоянию доктора С. П.
                                    Боткина Крым был выбран императрицей Марией Александровной для лечения. А&nbsp;незадолго
                                    до&nbsp;этого, в&nbsp;городе Саки, открылась первая официальная грязелечебница. В&nbsp;советские
                                    времена в&nbsp;Крыму активно строились пансионаты и&nbsp;дома отдыха для трудящихся
                                    и&nbsp;интеллигенции.
                                    Полуостров называли всесоюзной здравницей. Сама природа создала здесь все условия
                                    для отдыха и&nbsp;оздоровления:
                                    уникальный климат, целебный воздух, больше ста минеральных источников, лечебные
                                    грязи.
                                </p>

                            </div>
                            <div class="col text-right align-content-end shadow-text justify-content-end">
                                <img src="images/more.png" class="image-krim  mt-3" alt="Крымские скалы">
                            </div>
                            <div class="container">
                                <div class="row shadow-text justify-content-between">
                                    <div class="col-md-6 p-1 ">
                                        <img src="images/buhta2.png" class=" image-krim mt-3" alt="Крымская бухта">

                                    </div>
                                    <div class="col-md-6 p-1">
                                        <img src="images/buhta.png" class="image-krim mt-3" alt="Крымcкое побережье">

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </article>
                {{--<div class="container">--}}
                {{--<div class="row">--}}
                {{--<div class="col-xl-4 col-12 mx-auto pt-3 pb-5">--}}
                {{--<a href="№" class="btn btn-large px-5 py-2 choice__button ">Больше информации</a>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
            </section>
        </div>
    </main>

@endsection

