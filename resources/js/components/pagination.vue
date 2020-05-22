<template>
    <div class="container text-center">
        <div class="row ">

        <div class="pagination_left"><a class="btn bg-info" href="#" @click="changePage(prevPage)">prev</a> </div>
        <div class="pagination_right"><a class="btn bg-info" href="#" @click="changePage(prevPage)">next</a> </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "Test",
        props: {
            current: {
                type: Number,
                default: 1,
            }
        },

        computed: {
          nextPage: function () {
              return this.current + 1
          },
            prevPage: function () {
              return this.current - 1
          },

        },
        methods: {
            changePage: function (page) {
                this.$emit('page-changed', page)
            }
        }
    }
</script>

<style scoped>

</style>
