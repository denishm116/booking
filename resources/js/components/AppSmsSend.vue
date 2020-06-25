<template>
    <div class="dropdown-menu">
        <div class="card shadow-lg shadow-orange shadow-sm">

            <div class="card-header"><h4 class="text-center"> Отправить CMC для {{user.name}}</h4></div>
            <div class="card-body bg-light-dark">
                E-mail
                <input type="phone" class="form-control" name="phone"
                       v-model="user.phone">
                Сообщение
                <textarea cols="4" id="sms-message" name="sms-message"
                          class="form-control"  v-model="message"></textarea>

                <button @click="send()" class="btn btn-success mt-3" v-text="'Отправить'"></button>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        props: ['User'],
        data: function () {
            return {
                message: '',
                user: this.User
            }
        },
        methods: {
            send() {
                let str = '/admin/ajax/sendSms/' + this.user.phone + '/' + this.message
                console.log(str)
                axios.get(str)
                    .then((response) => {
                        
                    })
                    .catch((error) => {

                    });
            }
        }
    }
</script>

<style scoped>
.display {
    display: none;
}
</style>
