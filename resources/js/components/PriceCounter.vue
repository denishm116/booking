<template>
    <div class="row">

     <div class="col-md-3" v-for="room in allroom">

              <!--<div v-for="room in rooms">-->




                  <div class="col">

                      <div class="thumbnail">
                          <img class="img-responsive img-circle" :src="room.photos.path" alt="...">
                          <div class="caption">
                              <h3>Номер {{room.room_number}} <small class="orange bolded">{{ room.price }}$</small> </h3>
                              <p>{{ room.rservices }}</p>
                              <!--<p>-->

                                  <!--@foreach($room->rservices as $rservice)-->
                                  <!--{{$rservice->title}}-->
                                  <!--@endforeach-->
                              <!--</p>-->
                              <!--<p>-->
                                  <!--@foreach($room->object->additionals as $additional)-->
                                  <!--{{$additional->title}}-->
                                  <!--@endforeach-->
                              <!--</p>-->


                              <p><a href="#" class="btn btn-primary" role="button">Подробнее</a><a href="#" class="btn btn-success pull-right" role="button">Забронировать</a></p>
                          </div>
                      </div>
                  </div>





              <!--</div>-->


     </div>
   </div>
</template>

<script>
    export default {
        props: [
          'allrooms',
            'additional'
        ],

        data: function() {
            return {
                filtered: [],
                allroom: this.allrooms,
                addit: this.additional,

            }
        },
        mounted() {
            this.getAllRooms();
            this.cslog();

        },


        methods: {
            getAllRooms: function () {

                axios.get('/roomSearchFilter').then((response)=>{
                    this.filtered = response.data;
                });
            },
        cslog: function () {
                console.log(this.allroom);
            },

        },

    }
</script>

<style scoped>

</style>
