@extends('layouts.layout')

@section('title', 'Отдых в Крыму 2020. Цены на жилье у моря. Бронирование без посредников.')

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

    <main>

        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <h2 class="about__title">Курорты Крыма</h2>
                            <div class="col-xl-4 line"></div>
                        </div>
                    </div>
                    <div class="row ">
                        @include('layouts.citylist')
                    </div>
                </div>

            </div>

            <div class="row mt-3">
                <div class="col">
                    <div class="row">
                        <div class="col-xl-12 col-12  mt-3">
                            <h2 class="about__title">Где остановиться</h2>
                            <div class="col-xl-4 line"></div>
                        </div>
                    </div>


                    <div class="row justify-content-between">

                        @foreach($types as $type )
                            <div class="objects__category col-sm-auto col-lg-auto objects__category__type__seo">
                                <a href="{{  route('type',['city'=> 'krim', 'type'=>$type->alias ?? false] ) }}">
                                    {{$type->title}}
                                </a>
                            </div>
                        @endforeach
                    </div>


                    <div class="row justify-content-around">

                        @foreach($conditions as $condition )
                            <div
                                class="objects__category col-sm-auto col-lg-auto objects__category__type__seo objects__category__type__seo-where">
                                <a href="{{ route('cityConditions',['alias'=>'krim' ?? false, 'condition' => $condition[1]] ) }}">
                                    {{$condition[2]}}
                                    ({{$condition[0]}})
                                </a>
                            </div>
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
                        <div class="col-xl-4 line mb-2"></div>
                    </div>

                </div>


                @livewire('index')


            </div>
        </section>

        <div class="container">

            <section class="articles mb-5">

                <div class="container">
                    <div class="row">
                        <div class="col-xl-12 col-12 py-3">
                            <h2 class="about__title">Отзывы</h2>
                            <div class="col-xl-4 line"></div>
                        </div>
                    </div>
                </div>


                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">

                            <div class="container">
                                <ul class="hash-list cols-3 cols-1-xs pad-30-all align-center text-sm">
                                    <li>
                                        <img src="{{asset('images/reviews/review1.jpg')}}"
                                             class="wpx-100 img-round mgb-20" title="" alt="" data-edit="false"
                                             data-editor="field"
                                             data-field="src[Image Path]; title[Image Title]; alt[Image Alternate Text]">
                                        <p class="fs-110 font-cond-l" contenteditable="false">"Бронировал в августе
                                            отель в Ялте через данный сервис. Никаких нареканий нет. И от отдыха
                                            остались только положительные эмоции!"</p>
                                        <h5 class="font-cond mgb-5 fg-text-d fs-130" contenteditable="false"><a
                                                href="https://vk.com/tretyakov_r">Роман Третьяков</a></h5>
                                        <small class="font-cond case-u lts-sm fs-80 fg-text-l" contenteditable="false">Шоу-мэн,
                                            телеведущий, продюссер - Москва</small>
                                    </li>

                                    <li>
                                        <img src="{{asset('images/reviews/review2.jpg')}}"
                                             class="wpx-100 img-round mgb-20" title="" alt="" data-edit="false"
                                             data-editor="field"
                                             data-field="src[Image Path]; title[Image Title]; alt[Image Alternate Text]">
                                        <p class="fs-110 font-cond-l" contenteditable="false">"Когда был в России,
                                            воспользовался сервисом krim-leto.ru. Название понравилось, хотя ездил
                                            осенью :) Всем остался доволен."</p>
                                        <h5 class="font-cond mgb-5 fg-text-d fs-130" contenteditable="false"><a
                                                href="https://vk.com/akudievskiy">Андрей Кудиевский</a></h5>
                                        <small class="font-cond case-u lts-sm fs-80 fg-text-l" contenteditable="false">Chief
                                            Executive Officer Distillery inc. - Los Angeles</small>
                                    </li>
                                    <li>
                                        <img src="{{asset('images/reviews/review3.jpg')}}"
                                             class="wpx-100 img-round mgb-20" title="" alt="" data-edit="false"
                                             data-editor="field"
                                             data-field="src[Image Path]; title[Image Title]; alt[Image Alternate Text]">
                                        <p class="fs-110 font-cond-l" contenteditable="false">"Бронировали с женой
                                            гостевой дом на этом сайте. Все намного проще и понятнее, чем на подобных
                                            сайтах. Теперь буду бронировать только здесь."</p>
                                        <h5 class="font-cond mgb-5 fg-text-d fs-130" contenteditable="false"><a
                                                href="https://vk.com/romashishkin">Роман Шишкин</a></h5>
                                        <small class="font-cond case-u lts-sm fs-80 fg-text-l" contenteditable="false">Ведущий,
                                            сценарист, Стенд-ап комик - Ростов</small>
                                    </li>

                                </ul>
                            </div>


                        </div>
                        <div class="carousel-item">


                            <div class="container">

                                <ul class="hash-list cols-3 cols-1-xs pad-30-all align-center text-sm">


                                    <li>
                                        <img src="{{asset('images/reviews/review4.jpg')}}"
                                             class="wpx-100 img-round mgb-20" title="" alt="" data-edit="false"
                                             data-editor="field"
                                             data-field="src[Image Path]; title[Image Title]; alt[Image Alternate Text]">
                                        <p class="fs-110 font-cond-l" contenteditable="false">"Бронировали с мужем отель
                                            в Феодосии. Все было хорошо. В этом году собираемся в Евпаторию, бронировать
                                            будем здесь!"</p>
                                        <h5 class="font-cond mgb-5 fg-text-d fs-130" contenteditable="false"><a
                                                href="https://vk.com/beluana">Марина Фетисова</a></h5>
                                        <small class="font-cond case-u lts-sm fs-80 fg-text-l" contenteditable="false">Веб-разработчик,
                                            фрилансер - Екатеринбург</small>
                                    </li>

                                    <li>
                                        <img src="{{asset('images/reviews/review5.jpg')}}"
                                             class="wpx-100 img-round mgb-20" title="" alt="" data-edit="false"
                                             data-editor="field"
                                             data-field="src[Image Path]; title[Image Title]; alt[Image Alternate Text]">
                                        <p class="fs-110 font-cond-l" contenteditable="false">"Несколько раз ездила по
                                            работе, и пару раз отдыхать. Все время бронировла гостиницы здесь, ни разу
                                            не разочаровалась. "</p>
                                        <h5 class="font-cond mgb-5 fg-text-d fs-130" contenteditable="false"><a
                                                href="https://www.instagram.com/mary_prudik/">Прудникова Марина</a></h5>
                                        <small class="font-cond case-u lts-sm fs-80 fg-text-l" contenteditable="false">Стилист
                                            - Ейск</small>
                                    </li>

                                    <li>
                                        <img src="{{asset('images/reviews/review6.jpg')}}"
                                             class="wpx-100 img-round mgb-20" title="" alt="" data-edit="false"
                                             data-editor="field"
                                             data-field="src[Image Path]; title[Image Title]; alt[Image Alternate Text]">
                                        <p class="fs-110 font-cond-l" contenteditable="false">"В прошлом году возила
                                            внуков в Саки. В этом году поедем в Ялту. Бронируем здесь. Всем советую.
                                            Намного проще, чем на других сайтах."</p>
                                        <h5 class="font-cond mgb-5 fg-text-d fs-130" contenteditable="false"><a
                                                href="https://www.instagram.com/khmelevskaiavalen/">Валентина
                                                Хмеливская</a></h5>
                                        <small class="font-cond case-u lts-sm fs-80 fg-text-l" contenteditable="false">Шеф-повар
                                            - Железноводск</small>
                                    </li>
                                </ul>

                            </div>


                        </div>

                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon bg-orange" aria-hidden="true"></span>
                        <span class="sr-only  shadow ">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon  bg-orange" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>


            </section>
        </div>
    </main>

@endsection

