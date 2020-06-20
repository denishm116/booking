<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Панель управления - krim-leto.ru. Пользователь: {{Auth::user()->name}}</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css"
          integrity="sha384-rtJEYb85SiYWgfpCr0jn174XgJTn4rptSOQsMroFBPQSGLdOC5IbubP6lJ35qoM9" crossorigin="anonymous">
    <!-- Bootstrap core CSS -->
    {{--<link href="https://bootswatch.com/3/readable/bootstrap.min.css" rel="stylesheet">--}}
    {{--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">--}}
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">

    <link type="text/css" href="{{ asset('css/Cupertino.css')}}" rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my.css') }}">


    <script>
        const $$ = {}
        var base_url = '{{ url('/admin') }}';



        <?php
        if (isset($_COOKIE['scroll_val'])) {

            echo 'var scroll_val=' . '"' . (int)$_COOKIE['scroll_val'] . '";';

            setcookie('scroll_val', '', -3000);
        }
        ?>

    </script>
    <script src="//code.jivosite.com/widget.js" data-jv-id="0tRmtaryEe" async></script>
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


</head>

<body class="bg-light">


<div class="my_menu container">

    <div class="main-menu">


        <div id="sandwich">
            <div class="sw-top"></div>
            <div class="sw-middle"></div>
            <div class="sw-bottom"></div>
        </div>

        <div class="row ">

            <div class="ul col-2 m-0">
                @auth



                    <li class="mb-3"><a href="{{ route('adminHome') }}">Клендарь бронирований <span
                                class="sr-only">(current)</span></a>
                    </li>

                    <!-- Lecture 36 -->
                    @if( Auth::user()->hasRole(['owner','admin'])  )
                        <li class="mb-3"><a href="{{ route('myObjects') }}">Мои объкты</a></li>
                        <li class="mb-3"><a href="{{ route('saveObject') }}">Добавить объект</a></li>
                        <li class="mb-3"><a href="https://youtu.be/ouw9i6XIBGc"><i class="fas fa-question-circle"></i>
                                Справка</a></li>
                    @endif
                    @if( Auth::user()->hasRole(['admin']) )
                        <li class="mb-3"><a href="{{ route('cities.index') }}">Курорты Крыма</a></li>

                    @endif


                    <li class="mb-3"><a href="{{ route('profile') }}">Профиль: {{ Auth::user()->name }}</a></li>

                    <!-- Lecture 7 -->
                    <li class="mb-3">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Выйти
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endauth

                @guest
                    <div class="li"><a href="{{ route('login') }}">Войти</a></div>
                    <div class="li"><a href="{{ route('register') }}">Зарегистрироваться</a></div>
                    <a href="{{route('saveObject')}}">
                        <div class="li navigation-item-button">Добавить объект</div>
                    </a>
                @endguest
            </div>

            <div class="dropdown pt-3 ml-3 col-2 m-0">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    @if( $ncounter = count($notifications->where('status',0)) )
                        <span id="app-notifications-count" class="button__badge">{{ $ncounter }}</span>
                    @else
                        <span id="app-notifications-count" class="button__badge hidden">0</span>
                    @endif
                    <i class="fas fa-envelope-square"></i>
                </a>
                <ul id="app-notifications-list" class="dropdown-menu">
                    @foreach( $notifications as $notification )
                        @if($notification->status)
                            <li class="w-100"><a>{{ $notification->content }}</a></li>
                        @else
                            <li class="unread_notification w-100"><a
                                    href="{{ $notification->id }}">{{ $notification->content }}</a></li>
                        @endif

                    @endforeach

                </ul>

            </div>

            <div class="col-8 logo-mob pt-2">
                <a class="mob" href="/">Krim-leto<span class="logo-orange">.ru</span>
                </a>
            </div>


        </div>


    </div>


    <ul class="ulmenu2 py-2 backend-menu bg-light" >
        <li>
            <a class="mob" href="/">
                <div>
                    Krim-leto<span class="logo-orange">.ru</span>
                </div>
            </a>
        </li>

        @auth




            <li class="active"><a class="btn navigation-item-button" href="{{ route('adminHome') }}">Клендарь
                    бронирований
                    <span class="sr-only">(current)</span></a></li>


            @if( Auth::user()->hasRole(['owner','admin'])  )
                <li><a class="btn navigation-item-button" href="{{ route('myObjects') }}">Мои объекты</a></li>
                <li><a class="btn navigation-item-button" href="{{ route('saveObject') }}">Добавить объект</a></li>

            @endif
            @if( Auth::user()->hasRole(['admin']) )
                <li><a class="btn navigation-item-button" href="{{ route('cities.index') }}">Курорты Крыма</a></li>

            @endif


            <li><a class="btn navigation-item-button"
                   href="{{ route('profile') }}">Профиль: {{ Auth::user()->name }}</a><br>
{{--                <a--}}
{{--                    href="">в панель</a>--}}

            </li><br>

            @if( Auth::user()->hasRole(['owner'])  )
                <li><a class="btn choice__button helpbutton" style="font-weight: normal"
                       href="https://youtu.be/ouw9i6XIBGc"><i class="fas fa-question-circle" style="color: white"></i>
                        Cправка</a></li>
            @endif
            @if( Auth::user()->hasRole(['admin'])  )
                <li><a class="btn choice__button helpbutton" style="font-weight: normal"
                       href="{{ route('admin.objects.index') }}">
                        Панель</a></li>
            @endif
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
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        @if( $ncounter = count($notifications->where('status',0)) )
                            <span id="app-notifications-count" class="button__badge">{{ $ncounter }}</span>
                        @else
                            <span id="app-notifications-count" class="button__badge hidden">0</span>
                        @endif
                        <i class="fas fa-envelope-square"></i>
                    </a>
                    <ul id="app-notifications-list" class="dropdown-menu">
                        @foreach( $notifications as $notification )
                            @if($notification->status)
                                <li class="wnotification"><a>{{ $notification->content }}</a></li>
                            @else
                                <li class="unread_notification"><a
                                        href="{{ $notification->id }}">{{ $notification->content }}</a></li>
                            @endif

                        @endforeach

                    </ul>
                </div>
            </li>

        @endauth
        @guest
            <li><a href="{{ route('login') }}">Войти</a></li>
            <li><a href="{{ route('register') }}">Зарегистрироваться</a></li>
            <li><a class="btn px-5 navigation-item-button" href="{{route('saveObject')}}">Добавить объект</a></li>
        @endguest

    </ul>

</div>

<div class="container backend-content" id="app">
    <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-12 col-md-offset-2 main">


            @if ($errors->any())
                <br>
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <br>

            @if(Session::has('message'))
                <br>
                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ Session::get('message') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

{{--<div class="circle-wrapper">--}}
{{--    <div class="phone-wrapper">--}}
{{--        <div class="phone-numbers">--}}
{{--            <div><a href="tel: +79785852287">+7 (800) 222 64 99</a></div>--}}
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


<footer class="footer-info">
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-xl-3 col-12">
                <a class="down-logo" href="#">
                    Krim-leto<span class="logo-orange">.ru</span>
                </a>

                <div class="footer-info footer-doc">© {{date('Y')}} г.</div>

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
                <div class="py-0 mt-0 footer-info">
                    <a href="#" class="orange_footer"><i class="fab fa-vk"></i></a>
                    <a href="#" class="orange_footer ml-3"><i class="fab fa-odnoklassniki"></i></a>
                    <a href="#" class="orange_footer ml-3"><i class="fab fa-instagram"></i></a>
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.datepicker.extension.range.min.js')}}"></script>
<script src="{{ asset('js/ru.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

<script src="{{ asset('js/app.js') }}"></script> <!-- Lecture 5 -->
<script src="{{ asset('js/admin.js') }}"></script> <!-- Lecture 5 -->

<script>

    $(function () {


        //to prevent scroll top when refreshing
        if (typeof scroll_val !== 'undefined') {

            $(window).scrollTop(scroll_val);
            //scroll(0,scroll_val);
        }

    });


    //to prevent scroll top when refreshing
    function scroll_value() {
        document.cookie = 'scroll_val' + '=' + $(window).scrollTop();
    }


    $(document).on('click', '.keep_pos', function (e) {
        scroll_value();
    });

</script>
@stack('scripts')
</body>
</html>

