import {AxiosInstance as axios} from "axios";
import json from "vue-resource/src/http/interceptor/json";
import response from "vue-resource/src/http/response";


// $(document).ready(function () {
//     $('.circle-wrapper').hover(function () {
//         $('.circle-wrapper').toggleClass('phone-fon')
//         $('.phone-wrapper').toggleClass('phone-wrapper-white')
//     })
//
// });

//Автозаполнение города
$(document).ready(function () {
    $(".autocomplete").autocomplete({
        source: base_url + "/searchCities", /* 17 */
        minLength: 1,
        select: function (event, ui) {
        }
    });
});

//Бургер меню
$(document).ready(function () {
    $("#sandwich, .li").click(function () {
        $("#sandwich").toggleClass("active");
        $(".ul").toggleClass('ul-menu');


    });
    window.addEventListener('click', function (e) {
        let menu = document.querySelector('.ul');
        let ulmenu = document.querySelector('.main-menu');
        let sandwich = document.querySelector('#sandwich')

        if (!menu.contains(e.target) && !sandwich.contains(e.target) && !ulmenu.contains(e.target)) {
            // Ниже код, который нужно выполнить при срабатывании события.
            menu.classList.remove('ul-menu');
            sandwich.classList.remove('active');
        }
    });
});


//Оранжевая обводка форм
$(document).ready(function () {
    function focusForm(btn_date) {
        $(btn_date).toggleClass('form-control-left');
        $(btn_date).removeClass('btn_date')
    }

    function blurForm(btn_date) {
        $(btn_date).removeClass('form-control-left')
        $(btn_date).addClass('btn_date')
    }

    $('.form-control-right-in').focus(function () {
        focusForm('.btn_date_in');
    })

    $('.form-control-right-in').blur(function () {
        blurForm('.btn_date_in');
    })

    $('.form-control-right-out').focus(function () {
        focusForm('.btn_date_out');
    })

    $('.form-control-right-out').blur(function () {
        blurForm('.btn_date_out');
    })
});


window.axios = require('axios');
window.Vue = require('vue');
window.hooper = require('hooper')
// window.VueResource = require('vue-resource')


// Vue.component('example-component', require('./components/ExampleComponent.vue'));
// Vue.component('prop-component', require('./components/PropComponent.vue').default);
// Vue.component('pagination', require('./components/pagination.vue').default);
Vue.component('filters', require('./components/Filters.vue').default);
Vue.component('slider', require('./components/Slider.vue').default);
Vue.component('app-admin-reservations-index', require('./components/AppAdminReservationsIndex.vue').default);
Vue.component('app-admin-objects-index', require('./components/AppAdminObjectsIndex.vue').default);
// Vue.component('app-pagination', require('./components/AppPagination.vue').default);
// Vue.component('price-counter', require('./components/PriceCounter.vue').default);


const app = new Vue({
    el: '#app',

});


