<template>
    <div class="container">
        <div class="row pb-2 justify-content-center">
            <div class="col mb-1 bg-white col-1 shadow-sm p-2"><b>№</b></div>
            <div class="col mb-1 bg-white col-1 shadow-sm p-2"><b>Город</b></div>
            <div class="col mb-1 bg-white col-3 shadow-sm p-2"><b>Название</b></div>
            <div class="col mb-1 bg-white col-2 shadow-sm p-2"><b>Владелц</b></div>
            <div class="col mb-1 bg-white col-2 shadow-sm p-2"><b>Статус</b></div>
            <div class="col mb-1 bg-white col-2 shadow-sm p-2"><b>Номера</b></div>
        </div>


        <div class="row mb-2 justify-content-center" v-for="object in objects">
            <div class="col mb-1 bg-white col-1 shadow-sm p-2 text-center">
                <a :href="'/object/' + object.id">
                    {{object.id}}
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>

            <div class="col mb-1 bg-white col-1 shadow-sm p-2">{{object.city.name}}
            </div>

            <div class="col mb-1 bg-white col-3 shadow-sm p-2">{{object.name}} <br><a
                class="btn btn-success eye"
                :href="'/object/'+object.id" style="margin: 0; padding: 0 5px;"><i
                style="color: white" class="far fa-eye"></i></a>
                <a :href="'/admin/routes.saveobject/'+object.id" style="margin: 0; padding: 0 5px;"
                   class="btn btn-danger eye"
                ><i class="fas fa-cog" style="color: white"></i></a>
            </div>

            <div class="col mb-1 bg-white col-2 shadow-sm p-2">{{object.user.name}}
                <br>{{object.user.phone}}


            </div>


            <div class="col mb-1 bg-white col-2 shadow-sm p-2">


                <a v-if="object.status == 'moderated'" href="#" @click.prevent="unmoderate(object.id)"
                   class="btn btn-success">
                    Скрыть из поиска
                </a>

                <a v-else href="#" @click.prevent="moderate(object.id)" class="btn btn-danger">
                    Добавить в поиск
                </a>

            </div>


            <div class="col mb-1 bg-white col-2 shadow-sm p-2 text-center money-button">

                <a v-if="object.rooms" :href="'routes.saveroom/?object_id='+object.id"
                   :class="roomClass(object.rooms)">
                    {{object.rooms.length}} + добавить
                </a>
                <hr>
               <template v-for="room in object.rooms">
                id{{room.id}}
                <a :href="'/room/'+room.id" style="margin: 0; padding: 0 5px;"
                   class=" btn  btn-success eye"><i class="far fa-eye"></i></a>
                <a :href="'routes.saveroom/'+room.id" style="margin: 0; padding: 0 5px;"
                   class=" btn  btn-danger eye"><i class="fas fa-cog"></i></a>

                <a href="#" @click.prevent="removeRoom(room.id)" class="eye"
                ><i class="fas fa-trash-alt" style="color: #1b1e21;"></i></a>
                <br>
               </template>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        created() {
            this.getObjects()
        },
        data: function () {
            return {
                objects: [],
                page: 1,
                perPage: 25,
                pages: [],
            }
        },
        methods: {
            getObjects() {
                axios.get('/admin/ajax/objects').then((response) => {
                    this.objects = response.data;
                })
            },
            unmoderate(id) {
                axios.get('http://booking/admin/objects/unmoderate/' + id)
                    .then((response) => {
                        this.getObjects()
                    })
                    .catch((e) => {

                    })
            },
            moderate(id) {
                axios.get('http://booking/admin/objects/moderate/' + id)
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
            removeRoom(room) {
                axios.get('http://booking/admin/ajax/objects/rooms/' + room)
                    .then((response) => {
                        this.getObjects()
                    })
                    .catch((e) => {
                    })
            },

        }
    }
</script>

<style scoped>

</style>
