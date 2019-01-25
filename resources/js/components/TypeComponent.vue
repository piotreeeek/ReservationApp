<template>
    <div class="container">
        <div class="alert-success" v-if="success != false">{{ success }}</div>
        <p>Create new accessory type.</p>
        <form v-on:submit.prevent="save()">
            <div class="form-group">
                <label>Type name:</label>
                <input v-model="type.name" type="text">
                <p class="alert-danger" v-if="errors.name">{{ errors.name.join(' ') }}</p>
            </div>
            <button class="btn">Add</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                type: {
                    name: ''
                },
                errors: false,
                success: false
            }
        },
        methods: {
            save: function () {
                window.axios({
                    method: 'post',
                    url: '/api/types',
                    data: this.type
                }).then(response => {
                    console.log(response.status)
                    if(response.status = 201) {
                        this.success = "Added new Type"
                        setTimeout(() => {
                            this.success = false;
                        }, 3000);
                        this.errors = false
                    }
                }).catch(error => {
                    console.log(error.response)
                    this.errors = error.response.data.errors;
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>