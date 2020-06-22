<template>
    <div class="container">
        <div class="row pb-2">
            <div class="col mb-1 bg-white col-1 shadow-sm p-2"><b>№</b></div>
            <div class="col mb-1 bg-white col-3 shadow-sm p-2"><b>Гость/телефон</b></div>
            <div class="col mb-1 bg-white col-3 shadow-sm p-2"><b>Хозяин/телефон</b></div>
            <div class="col mb-1 bg-white col-3 shadow-sm p-2"><b>заезд/выезд</b></div>
            <div class="col mb-1 bg-white col-1 shadow-sm p-2"><b>Оплата</b></div>
            <div class="col mb-1 bg-white col-1 shadow-sm p-2"><b>Статус</b></div>
        </div>


        <div class="row mb-2" v-for="reservation in displayedReservations">

            <div class="col mb-1 bg-white col-1 shadow-sm p-2 text-center">
                <a :href="'admin/reservation/showReservation'+reservation.id">
                    {{reservation.id}}
                    <i class="fas fa-user-cog"></i>
                </a>
            </div>
            <div class="col mb-1 bg-white col-3 shadow-sm p-2"><a
                :href="'admin/reservation/showReservation'+reservation.id"
                :title="reservation.description"> {{reservation.user.name}}</a><br>{{reservation.user.phone}}
            </div>


            <div class="col mb-1 bg-white col-3 shadow-sm p-2">
                {{reservation.room.object.user.name}}
                <br>
                {{reservation.room.object.user.phone}}
            </div>

            <div class="col mb-1 bg-white col-3 shadow-sm p-2">
                <i>заезд: </i> {{ reservation.day_in }}
                <br><i>выезд: </i> {{ reservation.day_out }}
            </div>
            <div class="col mb-1 bg-white col-1 shadow-sm p-2"><i
                class="fas fa-angle-right"></i>{{reservation.price}}<br><i
                class="fas fa-angle-double-right"></i>{{reservation.reward}}

            </div>


            <div class="col mb-1 bg-white col-1 shadow-sm p-2 text-center money-button">
                <template v-if="reservation.status">
                    <a href="#" class="btn btn-success">

                        <i v-if="reservation.paid" class="fas fa-ruble-sign"></i>

                        <i v-else class="fas fa-ellipsis-h"></i>

                    </a>
                </template>
                <template v-else>

                    <a :href="'/admin/confirmReservation/'+ reservation.id" class="btn btn-danger">

                        <i v-if="reservation.paid" class="fas fa-ruble-sign"></i>

                        <i v-else class="fas fa-ellipsis-h"></i>

                    </a>
                </template>


            </div>
        </div>

            <ul class="pagination mb-3">
                <li class="page-item">
                    <a v-if="page != 1" @click.prevent="page = 1" class="page-link" href="#">
                        Первая
                    </a>
                </li>

                <li class="page-item">
                    <a v-if="page != 1" @click.prevent="page--"  class="page-link" href="#" aria-label="Предыдущая">
                        <span aria-hidden="true">«</span>
                        <span class="sr-only">Предыдущая</span>
                    </a>
                </li>
                <li class="page-item" v-for="pageNumber in pages.slice(page-1, page+4)" @click="page = pageNumber" :class="active(pageNumber)">

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


        data: function () {
            return {
                reservations: [],
                page: 1,
                perPage: 25,
                pages: [],
            }
        },
        methods: {
            getReservations() {
                axios.get('/admin/ajax/reservations').then((response) => {
                    this.reservations = response.data;

                });
            },
            setPages() {
                let numberOfPages = Math.ceil(this.reservations.length / this.perPage);

                for (let index = 1; index <= numberOfPages; index++) {
                           this.pages.push(index);
                }
            },
            paginate(reservations) {
                let page = this.page;
                let perPage = this.perPage;
                let from = (page * perPage) - perPage;
                let to = (page * perPage);
                return reservations.slice(from, to);
            },
            active(pageNumber) {
                if (this.page == pageNumber) {
                    return 'active'
                }
            }
        },
        created() {
            this.getReservations()
        },
        watch: {
            reservations() {
                this.setPages();
            }
        },
        computed: {
            displayedReservations() {
                return this.paginate(this.reservations);
            }
        }
    }
</script>

<style scoped>

</style>
