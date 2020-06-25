<template>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-dark table-striped  table-hover">
                <thead>
                <tr>

                    <th>№</th>
                    <th>Гость/телефон</th>
                    <th>Хозяин/телефон</th>
                    <th>заезд/выезд</th>
                    <th>Оплата</th>
                    <th>Статус</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="reservation in displayedReservations">


                    <td>
                        {{reservation.id}}
                        <a :href="'reservation/showReservation/'+reservation.id" style="margin: 0; padding: 0 5px;"
                           class=" btn btn-success"><i class="fas fa-eye"></i></a>

                    </td>
                    <td><a
                        :href="'reservation/showReservation/'+reservation.id"
                        :title="reservation.description"> {{reservation.user.name}}</a><br>{{reservation.user.phone}}
                    </td>


                    <td>
                        {{reservation.room.object.user.name}}
                        <br>
                        {{reservation.room.object.user.phone}}
                    </td>

                    <td>
                        <i>заезд: </i> {{ reservation.day_in }}
                        <br><i>выезд: </i> {{ reservation.day_out }}
                    </td>
                    <td><i
                        class="fas fa-angle-right"></i>{{reservation.price}}<br><i
                        class="fas fa-angle-double-right"></i>{{reservation.reward}}

                    </td>


                    <td>
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
i {
    color: white;
}
</style>
