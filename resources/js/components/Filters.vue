<template>

    <div class="row shadow-orange pr-3 pt-1">

        <div class="col-lg-3 form-group d-none d-lg-block mt-1 pt-1">
            <div class="shadow-orange border-orange p-3 mb-5 bg-white rounded mt-0 pt-0">

                <h5 class="search-parameters">Поиск по&nbsp;параметрам</h5>
                <div class="my-3 line-grey"></div>


                <h6 class="filter-type">Цена за сутки</h6>
                <div class="form-group">

                    <select class="form-control" v-model="sortprice">
                        <option class="object-parameter" v-bind:value="0">Все номера</option>
                        <option class="object-parameter" v-for="sort in sortprices" v-bind:value="sort.title"
                        >до {{sort.title}} р
                        </option>
                    </select>

                </div>
                <div class="my-3 line-grey"></div>


                <h6 class="filter-type mt-4">Тип объекта</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option1">
                    <div>
                        <div v-for="typ in types">
                            <label>
                                <input class="form-check-input" type="checkbox" v-bind:value="typ.id" v-model="type"
                                       v-on:change="setTypes()"
                                >{{typ.title}}
                            </label>
                        </div>
                    </div>

                </div>
                <div class="my-3 line-grey"></div>


                <h6 class="filter-type mt-4">Расстояние до моря</h6>

                <div class="form-check" v-for="dist in distances">
                    <label>
                        <input class="form-check-input" type="checkbox" v-bind:value="dist.id" v-model="distance"
                               v-on:change="setTypes()">{{dist.title}}
                    </label>
                </div>
                <div class="my-3 line-grey"></div>


                <h6 class="filter-type mt-4">Дополнительный услуги</h6>
                <div class="form-check" v-for="add in additionals">
                    <label>
                        <input class="form-check-input" type="checkbox" v-bind:value="add.id" v-model="additional"
                               v-on:change="setTypes()"
                        >{{add.title}}
                    </label>
                </div>

                <div class="my-3 line-grey"></div>

                <h6 class="filter-type mt-4">Инфраструктура</h6>

                <div class="form-check" v-for="inf in infrastructures">
                    <label>
                        <input class="form-check-input" type="checkbox" v-bind:value="inf.id" v-model="infrastructure"
                               v-on:change="setTypes()">{{inf.title}}


                    </label>
                </div>

                <div class="my-3 line-grey"></div>
                <h6 class="filter-type mt-4">Услуги в номере</h6>
                <div class="form-check" v-for="rserv in rservices">
                    <label>
                        <input class="form-check-input" type="checkbox" v-bind:value="rserv.id" v-model="rservice"
                               v-on:change="setTypes()">{{rserv.title}}
                    </label>
                </div>


            </div>
        </div>


        <div class="col-lg-9 align-content-center">

            <div class="row justify-content-center mb-3 mt-1"
                 v-for="(room, roomIndex) in displayedRooms">

                <div class="col-12 shadow-orange post-module my-1 shadow">

                    <div class="row p-1 align-items-center height h-100">
                        <div class="col-lg-4 col-sm-12 text-center m-0 p-1 h-100">
                            <div class="thumbnail bg-light" v-bind:class="{ looked: room.looked}">
                                <a v-bind:href="'/room/'+room.id">
                                    <div class="card-main-page__photo-header">Номер ID: {{room.id}}</div>
                                    <div class="card__photo-wrapper">
                                        <template v-if="room.photos == ''">
                                            <img class="image-krim card-img-top" v-bind:src="placeholder">
                                        </template>

                                        <template v-else>
                                            <template v-if="room.has_main_photo">
                                                <template v-for="photo in room.photos">
                                                    <template v-if="photo.main_photo == 1">

                                                        <img class="image-krim card-img-top" v-bind:src="photo.path">
                                                    </template>
                                                </template>
                                            </template>

                                            <template v-else>
                                                <template v-for="(photo, index) in room.photos">
                                                    <img v-show="index == 0" class="image-krim card-img-top"
                                                         v-bind:src="photo.path">

                                                </template>
                                            </template>
                                        </template>
                                    </div>
                                    <div class="star-icon">
                                        <small v-html="room.object.rating"></small>
                                    </div>
                                </a>

                            </div>
                        </div>

                        <div class="col-lg-8 height container-fluid h-100 align-items-stretch height">

                            <div class="card-main-page__content-wrapper height align-items-stretch">

                                <div class="card-main-page__content-wrapper-row-1">
                                    <div class="">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{room.object.city.name}} ул.
                                        {{room.object.address.street}},
                                        {{room.object.address.number}}.
                                    </div>
                                    <div class="">
                                        море: {{room.object.distance.title}}

                                    </div>

                                </div>

                                <div class="card-main-page__content-wrapper-row-2">
                                    <div class="card-main-page__content-wrapper-row-2-1">
                                        <div class="">
                                            {{room.room_size}}-местный номер
                                        </div>

                                        <div class="">
                                            <a v-bind:href="'/room/'+room.id" v-bind:data="room.id"
                                               class="favourites-button"
                                            ><i class="far fa-heart"></i>в избранное</a>
                                        </div>

                                    </div>
                                    <div class="card-main-page__content-wrapper-row-2-2">
                                        <div>
                                            <span>   <a v-bind:href="'/room/'+room.id">Название: {{room.display_name ? room.display_name : room.id}}</a></span>
                                        </div>
                                        <div>

                                        </div>
                                    </div>

                                </div>


                                <div class="card-main-page__content-wrapper-row-3">
                                    <template v-for="rservices in room.rservices">
                                        <div class="content-wrapper-row-3">
                                            <i class="fas fa-angle-down"> </i> {{ rservices.title }}
                                        </div>
                                    </template>
                                </div>


                                <div class="card-main-page__content-wrapper-row-4">
                                    <a v-bind:href="'/object/'+room.object.id"
                                       title="Перейти на стрницу объекта"> Объект: {{room.object.name}}</a>
                                </div>

                                <div class="card-main-page__content-wrapper-row-5">
                                    <div class="">
                                        <a v-bind:href="'/room/'+room.id"
                                           class="btn choice__button choice__button__small"
                                           role="button">забронировать</a>
                                    </div>

                                    <div class="">
                                        <a v-bind:href="'/room/'+room.id"
                                           class="btn btn-detailed"
                                           role="button">подробнее</a>
                                    </div>

                                    <div class="">


                                        <template v-if="reservprice">


                                            <template
                                                v-if="!reservprice[roomIndex].price.error">
                                                <span class="price">{{reservprice[roomIndex].price}} </span>
                                                <b>&#8381;</b>
                                                <b v-if="reservprice[roomIndex].interval == 1">/
                                                    {{reservprice[roomIndex].interval}} ночь </b>
                                                <b v-else-if="reservprice[roomIndex].interval > 1 && reservprice[roomIndex].interval < 5">/
                                                    {{reservprice[roomIndex].interval}} ночи </b>
                                                <b v-else-if="reservprice[roomIndex].interval >= 5">/
                                                    {{reservprice[roomIndex].interval}} ночей </b>

                                                <b v-else-if="reservprice[roomIndex].interval == 0">/
                                                    <small>сут.</small>
                                                </b>

                                            </template>

                                            <template v-else>
                                                <div class="error text-center m-1">Бронь закрыта :(</div>

                                            </template>
                                            <!--<small>с {{reservprice[roomIndex].checkin}} по {{reservprice[roomIndex].checkout}} </small>-->


                                        </template>
                                        <template v-else>
                                            от <span class="price">{{room.price}}&#8381;<small>/сут.</small></span>

                                        </template>

                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>


                </div>
                <!--</div>-->
            </div>

            <div class="row ml-4 ml-xl-1">
                <ul class="pagination m-2">
                    <li class="page-item">

                        <button type="button" class="page-link" v-if="page != 1" @click="page--"> Назад</button>
                    </li>
                    <li class="page-item">
                        <button type="button" class="page-link" v-for="pageNumber in pages.slice(page-1, page+5)"
                                @click="page = pageNumber"> {{pageNumber}}
                        </button>
                    </li>
                    <li class="page-item">
                        <button type="button" @click="page++" v-if="page < pages.length" class="page-link"> Вперед
                        </button>
                    </li>
                </ul>
            </div>


        </div>


    </div>


</template>

<script>

    export default {
        props: [
            'allrooms',
            'reservprice',

        ],


        data: function () {
            return {
                rooms: [''],
                page: 1,
                perPage: 12,
                pages: [],

                placeholder: '/images/placeholder.jpg',

                additionals: [],
                additional: [],

                rservices: [],
                rservice: [],

                types: [],
                type: [],

                distances: [],
                distance: [],
                sortprices: [],
                sortprice: 0,

                infrastructures: [],
                infrastructure: [],

                allroom: this.allrooms,
                allroom_display: [],
                allroom_distance: [],
                allroom_distance_unique: [],


                roomArr: [],
                arr: [],
                arr1: [],
                arr2: [],
                arr3: [],
                typeArr: [],
                additionalArr: [],
                mainPhoto: '',
                mainPhotoArr: [],

            }
        },

        mounted() {

            this.getAdditionals();
            this.getRservices();
            this.getInfrastructures();
            this.getTypes();
            this.getDistances();
            this.getSortprices();
            this.setTypes();
            this.getLookedRooms();
            this.allroom_display = this.allroom;
            this.rooms = this.allroom_display;
        },
        created() {
            this.getRooms();
        },
        watch: {
            sortprice: function () {
                this.setTypes()
            },
            rooms() {
                this.setPages();
            },
        },

        filters: {
            trimWords(value) {
                return value.split(" ").splice(0, 20).join(" ") + '...';
            }
        },


        methods:
            {
                getCookie(name) {
                    let matches = document.cookie.match(new RegExp(
                        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                    ));
                    return matches ? decodeURIComponent(matches[1]) : undefined;
                },

                getLookedRooms() {
                    for (let i = 0; i < this.rooms.length; i++) {
                        if (this.getCookie('room_seen' + this.rooms[i].id) != undefined) {
                            this.rooms[i].looked = true
                        }
                    }
                },

                getRooms() {
                    this.rooms = this.allroom_display;

                },

                setPages() {
                    this.pages = [];
                    let numberOfPages = Math.ceil(this.rooms.length / this.perPage);
                    for (let index = 1; index <= numberOfPages; index++) {
                        this.pages.push(index);
                    }
                },

                paginate(rooms) {
                    let page = this.page;
                    let perPage = this.perPage;
                    let from = (page * perPage) - perPage;
                    let to = (page * perPage);
                    return rooms.slice(from, to);
                },


                getAdditionals: function () {
                    axios.get('/additionals').then((response) => {
                        this.additionals = response.data;
                    });
                    // console.log(this.getLookedRooms())
                    // console.log(this.allroom_display.id);
                },

                getRservices: function () {
                    axios.get('/rservices').then((response) => {
                        this.rservices = response.data;
                    });
                },

                getInfrastructures: function () {
                    axios.get('/infrastructures').then((response) => {
                        this.infrastructures = response.data;

                    });
                },

                getTypes: function () {
                    axios.get('/types').then((response) => {
                        this.types = response.data;


                    });
                },

                getDistances: function () {
                    axios.get('/distances').then((response) => {
                        this.distances = response.data;

                    });

                },

                getSortprices: function () {
                    axios.get('/sortprices').then((response) => {
                        this.sortprices = response.data;
                        // this.allroom_display = this.allroom
                    });
                },


//Огромная функция фильтрации
            setTypes: function () {
                this.allroom_display = [];
                this.typeArr = [];
                this.arr = [];
                this.arr1 = [];
                this.arr2 = [];
                this.arr3 = [];
                this.allroom_distance = [];
                let checker = (arr, target) => target.every(v => arr.includes(v));
                //Проверка стоимости номера
                if (this.sortprice) {
                    this.allroom.forEach((room) => {
                        if (room.price <= this.sortprice) {
                            this.arr3.push(room)
                        }
                    });

                } else {
                    this.arr3 = this.allroom
                }

                //Проверка дистанции до моря
                if ((this.distance != 0)) {
                    this.arr3.forEach((room) => {
                        this.distance.forEach((di) => {
                            if ((room.object.distance_id != null) && (room.object.distance_id <= di)) {
                                this.allroom_distance.push(room);
                            }
                        });
                    });

                    //Удаляем повторяющиеся элементы массива
                    this.allroom_distance = Array.from(new Set(this.allroom_distance))

                } else {
                    this.allroom_distance = this.arr3
                }
                //this.allroom_distance_unique = this.arr3;
                // console.log('Промежуточный результат: ' + this.arr3);
                //Проверка типа объека (Гостиница, гостевой дом итд)
                this.allroom_distance.forEach((room) => {
                    // console.log(room);
                    if (this.type !== 0) {

                        let m = []
                        room.object.types.forEach((roomAdditionals) => {
                            m.push(roomAdditionals.id);
                        });
                        if (checker(m, this.type)) {
                            this.typeArr.push(room)
                        }
                    }
                });

                //Проверка доп услуг (проститутки)
                this.typeArr.forEach((room) => {
                    if (this.additional !== 0) {
                        let m = []
                        room.object.additionals.forEach((roomAdditionals) => {
                            m.push(roomAdditionals.id);
                        });
                        if (checker(m, this.additional)) {
                            this.arr.push(room)
                        }
                    }
                });

                //Проверка инфраструктуры
                this.arr.forEach((room) => {
                    if (this.infrastructure !== 0) {
                        let m = []
                        room.object.infrastructures.forEach((roomAdditionals) => {
                            m.push(roomAdditionals.id);
                        });
                        if (checker(m, this.infrastructure)) {
                            this.arr1.push(room)
                        }
                    }
                });

                //Проверка дополнительных условий номера
                this.arr1.forEach((room) => {
                    if (this.rservice !== 0) {
                        let m = []
                        room.rservices.forEach((roomAdditionals) => {
                            m.push(roomAdditionals.id);
                        });
                        if (checker(m, this.rservice)) {
                            this.allroom_display.push(room)
                        }
                    }
                });
                this.rooms = this.allroom_display;

            },


        },
        computed: {
            displayedRooms() {

                return this.paginate(this.rooms);
            }
        },

    }

</script>

<style scoped>


    .card-radius {
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: auto;

    }

    .card i {
        padding-right: 5px;
    }


    button.page-link {
        display: inline-block;
    }

    button.page-link {
        font-size: 20px;
        color: #29b3ed;
        font-weight: 500;
    }

    .offset {
        width: 500px !important;
        margin: 20px auto;
    }

</style>
