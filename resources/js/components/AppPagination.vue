<template>
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
</template>

<script>
    export default {
        props: [
            'itemsOut',
            'perPageOut',
        ],


        data: function () {
            return {
                items: '',
                page: 1,
                perPage: '',
                pages: [],

            }
        },
        methods: {

            setPages() {
                let numberOfPages = Math.ceil(this.items.length / this.perPage);

                for (let index = 1; index <= numberOfPages; index++) {
                    this.pages.push(index);
                }
            },
            paginate(items) {
                let page = this.page;
                let perPage = this.perPage;
                let from = (page * perPage) - perPage;
                let to = (page * perPage);
                return items.slice(from, to);
            },

        },
        created() {
            console.log('111111111111')
            this.getItems()
        },
        watch: {
            items() {
                this.setPages();
            }
        },
        computed: {
            displayedItems() {
                return this.paginate(this.items);
            }
        },
        mounted: {
            getItems() {
                this.items = this.itemsOut
                this.perPage = this.perPageOut
            },

        }
    }
</script>

<style scoped>

</style>
