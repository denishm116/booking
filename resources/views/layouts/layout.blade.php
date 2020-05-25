<html lang="ru">
<head>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(57244333, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true,
            ecommerce: "dataLayer"
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/57244333" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-132861745-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-132861745-2');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <link rel="@yield('canonical')" href="@yield('canonical-address')">


    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css"
          integrity="sha384-rtJEYb85SiYWgfpCr0jn174XgJTn4rptSOQsMroFBPQSGLdOC5IbubP6lJ35qoM9" crossorigin="anonymous">

    <link type="text/css" href="{{ asset('/css/Aristo.css')}}" rel="stylesheet"/>


    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my.css') }}">


    <script>
        var base_url = '{{ url('/') }}';
    </script>
    <script src="//code.jivosite.com/widget.js" data-jv-id="0tRmtaryEe" async></script>
    <script src="https://kassa.yandex.ru/checkout-ui/v2.js"></script>


    <meta name="yandex-verification" content="e7e601028b8d617f"/>
</head>
<body>


<div class="my_menu container">
    <div class="main-menu">
        <div id="sandwich">
            <div class="sw-top"></div>
            <div class="sw-middle"></div>
            <div class="sw-bottom"></div>
        </div>
        <div class="ul">
            <li>
                <div>
                    <a href="#" class="favourites-mob"> <i class="header-heart far fa-heart"></i>Избранное</a>
                </div>
            </li>
            @auth
                <div class="li">Вы вошли, как:</div>
                <div class="li">{{ Auth::user()->name }}</div>
                <a href="{{ route('adminHome') }}">
                    <div class="li">Панель управления</div>
                </a>
                <a href="{{route('saveObject')}}">
                    <div class="li navigation-item-button">Добавить объект</div>
                </a>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <div class="li">
                        Выйти

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </a>
            @endauth

            @guest
                <a href="{{ route('login') }}">
                    <div class="li">Войти</div>
                </a>
                <a href="{{ route('register') }}">
                    <div class="li">Зарегистрироваться</div>
                </a>
                <div>
                    <div class="li navigation-item-button"><a href="{{route('saveObject')}}">Сдать жилье</a>
                    </div>
                </div>
            @endguest
        </div>
    </div>


    <div>
        <a class="krim_Leto_ru" href="/">Krim-leto<span class="logo-orange">.ru</span>
        </a>

    </div>

    <ul class="ulmenu2 py-2">

        <li>
            <div>

                {{--<form action="{{route('favourites')}}">--}}
                {{--<button class="favourites-mob"> <i class="header-heart far fa-heart"></i>Избранное</button>--}}
                {{--<input type="hidden" value="111" class="hidden-favourites">--}}
                {{--</form>--}}
                <a href="#" class="favourites"> <i class="header-heart far fa-heart"></i>Избранное</a>
            </div>
        </li>

        @auth
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    Выйти
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>

            <li>

                <div class="for-menu-button">
                    <a href="{{ route('adminHome') }}" class="btn px-5 navigation-item-button">Панель
                        управления: {{ Auth::user()->name }}</a>
                </div>
            </li>

        @endauth
        @guest
            <li><a href="{{ route('login') }}">Войти</a></li>
            <li><a href="{{ route('register') }}">Зарегистрироваться</a></li>
            <li><a class="btn px-5 navigation-item-button" href="{{route('saveObject')}}">СДАТЬ ЖИЛЬЕ</a></li>
        @endguest

    </ul>

</div>


<div id="app">

    @yield('content')

</div>

{{--<div class="circle-wrapper">--}}
{{--    <div class="phone-wrapper">--}}
{{--        <div class="phone-numbers">--}}
{{--            <div><a href="tel: +78002226499">+7 (800) 222 64 99</a></div>--}}
{{--            <div><a href="tel: +79785852287">+7 (978) 585 22 87</a></div>--}}
{{--        </div>--}}
{{--        <div class="phone circle circle2">--}}
{{--            <i class="fa fas fa-phone"></i>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="phone_mob_wrapper">
    <div class="phone_mob">

        <a href="tel: +79785852287">
            <div class="phone circle circle2">
                <i class="fa fas fa-phone"></i>
            </div>
        </a>
    </div>
</div>
<div id="toTop" class="bradius2 arrow-top"><i class="fas fa-caret-square-up "></i>
</div>
<footer class="footer-info">
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-xl-3 col-12">
                <a class="down-logo" href="#">
                    Krim-leto<span class="logo-orange">.ru</span>
                </a>

                <div class="footer-info footer-doc">© 2019 — 2020 г.</div>

            </div>
            <div class="col-xl-3 col-12">

                <div class="py-0 mt-0 footer-info"><a href="{{route('forowners')}}" class="footer-doc footer-serv">Для
                        владельцев недвижимости</a></div>
                <div class="py-0 mt-0 footer-info"><a href="{{route('guest_agreement')}}"
                                                      class="footer-doc footer-user">Пользовательское
                        соглашение</a>
                </div>
            </div>

            <div class="col-xl-3 col-12 ">
                <div class="py-0 mt-0 footer-info"><a href="{{route('confidential_policy')}}"
                                                      class="footer-doc footer-conf">Политика
                        конфиденциальности</a>
                </div>
                <div class="py-0 mt-0 footer-info"><a href="{{route('landlord_agreement')}}"
                                                      class="footer-doc footer-contract">Договор публичной оферты</a>
                </div>
                <div class="py-0 mt-0 footer-info"><a href="{{route('contacts')}}" class="footer-doc footer-contakt">Контакты</a>
                </div>

            </div>


            <div class="col-xl-3 col-12 ">

                <div class="py-0 mt-0 footer-info"><i class="fas fa-envelope"> </i> <a class="footer-doc"
                                                                                       href="mailto: info@krim-leto.ru">
                        info@krim-leto.ru</a></div>

                <div class="py-0 mt-0 footer-info"><i class="fas fa-phone-square"></i> <a class="footer-doc"
                                                                                          href="tel: +78002226499">+7
                        (800) 222 64 99</a></div>
                <div class="py-0 mt-0 footer-info">
                    <a href="https://vk.com/krim_letoru" class="orange_footer"><i class="fab fa-vk"></i></a>
                    <a href="https://ok.ru/profile/580138185952" class="orange_footer ml-3"><i
                            class="fab fa-odnoklassniki"></i></a>
                    <a href="https://www.instagram.com/krim_leto_/" class="orange_footer ml-3"><i
                            class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col footer-doc footer-conf">
                <p class="footer-doc footer-conf">© Все права защищены. Любое использование либо копирование материалов сайта, элементов дизайна и
                    оформления допускается лишь с разрешения правообладателя и только со ссылкой на источник:
                    krim-leto.ru</p>
                <p>Использование сайта означает согласие с <a href="{{route('guest_agreement')}}"
                                                               class="footer-doc footer-user bolded">Пользовательским
                        соглашением</a> и <a href="{{route('confidential_policy')}}"
                                             class="footer-doc footer-conf bolded">Политикой конфиденциальности</a>. Оплачивая
                    лицензионный платеж, вы принимаете <a href="{{route('guest_agreement')}}"
                                                          class="footer-doc footer-user bolded">Лицензионное соглашение.</a></p>
            </div>
        </div>

    </div>

</footer>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

{{--<script--}}
{{--src="https://code.jquery.com/jquery-3.4.1.min.js"--}}
{{--integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="--}}
{{--crossorigin="anonymous"></script>--}}


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>


<script src="{{ asset('js/app.js') }}"></script>

<script src="{{ asset('js/cookie.js') }}"></script>
<script src="{{ asset('js/jquery.datepicker.extension.range.min.js')}}"></script>
<script src="{{ asset('js/ru.js') }}"></script>
<script src="{{ asset('js/rating.js') }}"></script>
@stack('scripts')

<script type="text/javascript">

    $(function () {

        $(window).scroll(function () {

            if ($(this).scrollTop() != 0) {

                $('#toTop').fadeIn();

            } else {

                $('#toTop').fadeOut();

            }

        });

        $('#toTop').click(function () {

            $('body,html').animate({scrollTop: 0}, 800);

        });

    });

</script>

<script>
    $.datepicker.setDefaults($.datepicker.regional['ru']);
    let myTempVar = false;
    let width = document.body.clientWidth; // ширина
    let numberOfMonth = 2;
    if (width < 600)
        numberOfMonth = 1;

    $("#check_in, #check_out").datepicker({

        minDate: 0,
        range: 'period',
        numberOfMonths: numberOfMonth,
        dateFormat: "dd-mm-yy",


        onSelect: function (dateText, inst, extensionRange) {

            // extensionRange - объект расширения
            $('[name=checkin]').val(extensionRange.startDateText);
            $('[name=checkout]').val(extensionRange.endDateText);

            document.querySelector('#check_in').onfocus = () => myTempVar = false;
            if (!myTempVar) {
                document.querySelector('#check_out').focus()
                myTempVar = true;
            }
            if (myTempVar && extensionRange.startDateText < extensionRange.endDateText)
                setTimeout(function () {
                    $("#check_in, #check_out").datepicker('hide')
                }, 1000)
        }
    });


    function guests() {
        let choiceVisible = document.querySelector('.choice-visible');
        let guestsWrapper = document.querySelector('.guests-wrapper');
        let adultsPlus = document.querySelector('.adult-plus');
        let adultsMinus = document.querySelector('.adult-minus');
        let childrenPlus = document.querySelector('.children-plus');
        let childrenMinus = document.querySelector('.children-minus');
        let adultsCounter = document.querySelector('.adults-counter');
        let adultsVisible = document.querySelector('.adults-visible');
        let childrenCounter = document.querySelector('.children-counter');
        let childrenVisible = document.querySelector('.children-visible');
        let select = document.querySelector('.selected-guest');
        let gotovo = document.querySelector('.gotovo');

        if (gotovo) {
            gotovo.onclick = function () {
                guestsWrapper.classList.add('anim');

            }
            //Появление меню
            choiceVisible.onclick = function () {
                guestsWrapper.classList.toggle('anim');

                this.classList.toggle('border-gray');
                this.classList.toggle('border-orange');
            };

            adultsPlus.onclick = function () {
                let zz = adultsCounter.innerHTML;
                zz++;
                if (zz > 10) zz = 10;
                adultsCounter.innerHTML = zz;
                adultsVisible.innerHTML = zz;
                write();
            };


            adultsMinus.onclick = function () {
                let mm = adultsCounter.innerHTML;
                mm--;
                if (mm <= 1) mm = 1;
                adultsCounter.innerHTML = mm;
                adultsVisible.innerHTML = mm;
                write();
            };


            childrenPlus.onclick = function () {
                let bb = childrenCounter.innerHTML;
                bb++;
                if (bb > 10) bb = 10;
                childrenCounter.innerHTML = bb;
                childrenVisible.innerHTML = bb;
                write();
            };


            childrenMinus.onclick = function () {
                let mm = childrenCounter.innerHTML;
                mm--;
                if (mm <= 0) mm = 0;
                childrenCounter.innerHTML = mm;
                childrenVisible.innerHTML = mm;
                write();
            }

            function write() {
                let sumGuests = +adultsCounter.innerHTML + +childrenCounter.innerHTML;
                select.options[0].value = sumGuests;
                select.options[0].text = sumGuests;

            }


            window.addEventListener('click', function (e) {
                if (!guestsWrapper.contains(e.target) && !choiceVisible.contains(e.target)) {

                    guestsWrapper.classList.add('anim');

                }
            });

        }
    }


    guests();
    document.querySelector('.btn_date_in').onclick = function (e) {
        e.preventDefault();
    };
    document.querySelector('.btn_date_out').onclick = function (e) {
        e.preventDefault();
    };
</script>
<script src="{{ asset('js/favourites.js') }}"></script>
</body>
</html>

