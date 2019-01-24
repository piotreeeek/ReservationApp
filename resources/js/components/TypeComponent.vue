<template>
    <div class="container">
        <p>Create new accessory type.</p>
        <form v-on:submit.prevent="save()">
            <label>Type name:</label>
            <input v-model="type.name" type="text">
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
                }
            }
        },
        methods: {
            save: function () {
                window.axios({
                    method: 'post',
                    url: '/api/types',
                    data: this.type
                }).then(response => {
                    console.log(response)
                }).catch(error => {
                    console.log(error.response)
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>