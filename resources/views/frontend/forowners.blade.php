@extends('layouts.layout')

@section('title', 'Поможем сдать жилье для отдыхающих в Крыму: отель, квартиру, дом, и т.д.')

@section('description', 'Отдых в Крыму в 2020 году: Сдадим ваше жилье для отдыхающих, гостиницу, квартиру, дом, отель и т.д.')

@section('content')

    <section class="banner-area mt-3 ">
        <link href="images/for_owners/main.css" rel="stylesheet" type="text/css">

        <div class="container">
            <div class="row fullscreen d-flex align-items-center justify-content-start">
                <div class="banner-content col-lg-9 mt-5">
                    <h6>бронирование недвижимости для отдыха в Крыму</h6>
                    <h1 class="text-white mb-0">
                        Размещение рекламы отелей - бесплатно<br>
                    </h1>
                    <h5>И любых других объектов недвижимости для отдыха</h5>

                    <a href="{{ route('register') }}" class="genric-btn mt-5">Регистрация</a>
                    <a href="{{ route('home') }}" class="genric-btn mt-5 ml-3">На главную</a>

                </div>

                {{--<img class="header-img img-fluid align-self-end d-flex" src="images/for_owners/header-img.png" alt="">--}}
            </div>
            <div class="banner-content"><a class="genric-btn mt-5" href="{{ route('home') }}"> перейти на сайт https://krim-leto.ru</a></div>

        </div>
    </section>
    <section class="calltotop-area pt-70 pb-70">
        <div class="container">
            <div class="callto-section">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-4 call-left no-padding">
                        <p>
                            Иногда <span>пустуют</span> номера? <br>
                            <span>решим</span> эту <span>проблему</span><br>
                            Без <span>ежегодной</span> оплаты!
                        </p>
                    </div>
                    <div class="col-lg-5 call-middle">
                        <p>
                            Платформа krim-leto.ru — это одна из немногих платформ, на которой вы совершенно бесплатно можете разместить рекламу своей гостиницы, отеля, может быть квартиры или дома, если вы принимаете гостей великолепного Крыма!
                        </p>
                    </div>
                    <div class="col-lg-3 call-right  d-flex">
                        <a href="{{ route('register') }}" class="call-btn">Зарегистрироваться</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="feature-area section-gap mt-0">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-9 pb-40 header-text">
                    <h3>Что Вы получите, работая с нами</h3>
                    <p>
                       Мы заинтересованы в вашем успехе.
                    </p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature">
                        <h4><i class="fab fa-creative-commons-nc mr-2"></i>Бесплатное размещение</h4>
                        <p>
                            Размещая свой объект недвижимости (отель, дом, квартиру) на страницах нашего сайта Вы не платите никакой арендной платы. Разместить можно сколько угодно объектов на любой срок.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature">
                        <h4><i class="far fa-calendar-check mr-2"></i>Синхронизация календарей</h4>
                        <p>
                            Вы можете синхронизировать календарь бронирований сайта krim-leto.ru с календарем других сайтов (формат iCal - например - booking.com) и управлять бронированиями с одной площадки.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature">
                        <h4><i class="far fa-handshake mr-2"></i>Агентское вознаграждение</h4>
                        <p>
                            В курортном бизнесе общепринятая агентская комиссия 20% от стоимости бронирования. Некоторые сайты берут 15 - 18 %. <i>Комиссия на krim-leto.ru - всего 10%.</i> При этом Вы, как владелец, цену за аренду устанавливаете самостоятельно любую, какую Вам удобно.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature">
                        <h4><i class="fas fa-gavel mr-2"></i>Юридическая чистота</h4>
                        <p>
                            Все финансовые действия на сайте подкреплены <a href="{{route('landlord_agreement')}}"
                                                                            class=" footer-contract">договорм публичной оферты</a> и <a href="{{route('landlord_agreement')}}"
                                                                                                                                                  class="footer-contract">пользовательским соглашением</a>.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature">
                        <h4><i class="fas fa-user-shield mr-2"></i>Защита от отмененных бронирований</h4>
                        <p>
                            krim-leto.ru берет на себя расходы, возникшие по причине отмены бронировний, не описанных в <a href="{{route('landlord_agreement')}}"
                                                                                                                           class=" footer-contract">договоре публичной оферты</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature">
                        <h4><i class="far fa-laugh-wink mr-2"></i>Никаких трат</h4>
                        <p>
                            В случае, если с krim-leto.ru не поступают бронирования, Вы ничего не теряете! Ведь вы не оплачиваете размещение объявления!
                        </p>
                    </div>
                </div>

            </div>


        </div>
        <div class="col-lg-12 mt-3 text-center">
            <a href="{{ route('register') }}" class="call-btn">Зарегистрироваться</a>
        </div>
    </section>

    <section class="review-area section-gap">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-9 pb-40 header-text text-center">
                    <h4 class="pb-10">Мы на YouTube</h4>
                    <p>
                        Чтобы не читать, можно посмотреть.
                    </p>
                </div>
            </div>
            <div class="container text-center">
                <iframe width="100%" height="500px" src="https://www.youtube.com/embed/mIO5uVGlhXQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            </div>
        </div>
    </section>






@endsection
