<template>
    <div class="container">
        <ul class="pagination pagination-sm mb-3">
            <li class="page-item">
                <a v-if="page != 1" @click.prevent="page = 1" class="page-link" href="#">
                    Первая
                </a>
            </li>

            <li class="page-item">
                <a v-if="page != 1" @click.prevent="page--" class="page-link" href="#" aria-label="Предыдущая">
                    <span aria-hidden="true">«</span>
                    <span class="sr-only">Предыдущая</span>
                </a>
            </li>
            <li class="page-item" v-for="pageNumber in pages.slice(page-1, page+4)" @click="page = pageNumber"
                :class="active(pageNumber)">

                <a class="page-link" href="#">{{pageNumber}}</a>
            </li>

            <li class="page-item">
                <a class="page-link" href="#" @click="page++" v-if="page < pages.length" aria-label="Следующая">
                    <span aria-hidden="true">»</span>
                    <span class="sr-only">Следующая</span>
                </a>
            </li>
            <li class="page-item">
                <a @click="page = pages.length" v-if="page < pages.length" class="page-link" href="#">
                    Последняя
                </a>
            </li>
        </ul>
        <div class="table-responsive">
        <table class="table table-dark table-striped  table-hover">
            <thead>
            <tr>
                <th>№</th>
                <th>Город</th>
                <th>Название</th>
                <th>Владелц</th>
                <th>Статус</th>
                <th>Номера</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="object in displayedObjects">

                <td :name="object.id"> {{object.id}}

                </td>

                <td>{{object.city.name.substr(0,10)}}
                </td>

                <td>
                    {{object.name}}<br>
                    <a
                        class="btn btn-success eye"
                        :href="'/object/'+object.id" style="margin: 0; padding: 0 5px;"><i
                        style="color: white" class="far fa-eye"></i></a>

                    <a :href="'/admin/routes.saveobject/'+object.id" style="margin: 0; padding: 0 5px;"
                       class="btn btn-info"
                    ><i class="fas fa-cog" style="color: white"></i></a>

                    <a href="#" @click.prevent="removeObject(object.id)" style="margin: 0; padding: 0 5px;"
                       class="btn btn-danger eye">

                        <i class="fas fa-trash-alt"></i>
                    </a>

                </td>

                <td>{{object.user.name}}
                    <br>{{object.user.phone}}
                    <div class="row justify-content-between">
                        <div class="col">

                            <button style="margin: 0; padding: 0 5px;"
                                    class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="fas fa-envelope" style="color: white"></i>
                            </button>

                            <app-mail-send
                                :User=object.user
                            ></app-mail-send>

                        </div>

                        <div class="col">
                            <button style="margin: 0; padding: 0 5px;"
                                    class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="fas fa-sms" style="color: white"></i></button>
                            <app-sms-send
                                :User=object.user
                            ></app-sms-send>
                        </div>


                    </div>

                </td>


                <td>


                    <a v-if="object.status == 'moderated'" href="#" @click.prevent="unmoderate(object.id)"
                       class="btn btn-success">
                        Скрыть из поиска
                    </a>

                    <a v-else href="#" @click.prevent="moderate(object.id)" class="btn btn-danger">
                        Добавить в поиск
                    </a>

                </td>


                <td>

                    <a v-if="object.rooms" :href="'routes.saveroom/?object_id='+object.id"
                       :class="roomClass(object.rooms)">
                        {{object.rooms.length}} + добавить
                    </a>
                    <hr>
                    <template v-for="room in object.rooms">
                        id{{room.id}}
                        <a :href="'/room/'+room.id" style="margin: 0; padding: 0 5px;"
                           class=" btn  btn-success"><i class="far fa-eye"></i></a>
                        <a :href="'routes.saveroom/'+room.id" style="margin: 0; padding: 0 5px;"
                           class=" btn  btn-info"><i class="fas fa-cog"></i></a>

                        <a href="#" @click.prevent="removeRoom(room.id)" style="margin: 0; padding: 0 5px;"
                           class="btn btn-danger eye"
                        ><i class="fas fa-trash-alt"></i></a>
                        <br>
                    </template>
                </td>

            </tr>
            </tbody>
        </table>
        </div>


        <ul class="pagination mb-3">
            <li class="page-item">
                <a v-if="page != 1" @click.prevent="page = 1" class="page-link" href="#">
                    Первая
                </a>
            </li>

            <li class="page-item">
                <a v-if="page != 1" @click.prevent="page--" class="page-link" href="#" aria-label="Предыдущая">
                    <span aria-hidden="true">«</span>
                    <span class="sr-only">Предыдущая</span>
                </a>
            </li>
            <li class="page-item" v-for="pageNumber in pages.slice(page-1, page+4)" @click="page = pageNumber"
                :class="active(pageNumber)">

                <a class="page-link" href="#">{{pageNumber}}</a>
            </li>

            <li class="page-item">
                <a class="page-link" href="#" @click="page++" v-if="page < pages.length" aria-label="Следующая">
                    <span aria-hidden="true">»</span>
                    <span class="sr-only">Следующая</span>
                </a>
            </li>
            <li class="page-item">
                <a @click="page = pages.length" v-if="page < pages.length" class="page-link" href="#">
                    Последняя
                </a>
            </li>
        </ul>


    </div>
</template>

<script>
    export default {
        created() {
            this.getObjects()
        },
        data: function () {
            return {

                isActive: false,
                showSendMail: false,
                showSendSms: false,
                objects: [],
                page: 1,
                perPage: 25,
                pages: [],
            }
        },
        methods: {
            sendMail(email) {
                this.showSendMail = !this.showSendMail;
                console.log(this.show)

            },
            sendSms(phone) {

                this.showSendSms = !this.showSendSms
                console.log(this.showSendSms)
            },
            getObjects() {
                axios.get('/admin/ajax/objects').then((response) => {
                    this.objects = response.data;
                }).catch((e) => {

                })
            },
            unmoderate(id) {
                axios.get('/admin/objects/unmoderate/' + id)
                    .then((response) => {
                        this.getObjects()
                    })
                    .catch((e) => {

                    })
            },
            moderate(id) {
                axios.get('/admin/objects/moderate/' + id)
                    .then((response) => {
                        this.getObjects()
                    })
                    .catch((e) => {

                    })
            },
            roomClass(rooms) {
                if (rooms.length) {
                    return 'btn btn-success'
                } else {
                    return 'btn btn-danger'
                }
            },
            removeRoom(id) {
                if (confirm('Вы действительно хотите удалить номер:' + id)) {
                    axios.get('http://booking/admin/ajax/objects/rooms/' + id)
                        .then((response) => {
                            this.getObjects()
                        })
                        .catch((e) => {
                        })
                } else {

                }

            },
            removeObject(id) {
                if (confirm('Вы действительно хотите удалить объект:' + id)) {
                    axios.get('http://booking/admin/ajax/objects/' + id)
                        .then((response) => {
                            this.getObjects()
                        })
                        .catch((e) => {
                        })
                } else {

                }

            },
            setPages() {
                let numberOfPages = Math.ceil(this.objects.length / this.perPage);
                for (let index = 1; index <= numberOfPages; index++) {
                    this.pages.push(index);
                }
            },
            paginate(objects) {
                let page = this.page;
                let perPage = this.perPage;
                let from = (page * perPage) - perPage;
                let to = (page * perPage);
                return objects.slice(from, to);
            },
            active(pageNumber) {
                if (this.page == pageNumber) {
                    return 'active'
                }
            }
        },
        computed: {
            displayedObjects() {
                return this.paginate(this.objects);
            }
        },
        watch: {
            objects() {
                this.setPages();
            }
        },
    }
</script>

<style scoped>

    i {
        color: white;
    }
</style>
