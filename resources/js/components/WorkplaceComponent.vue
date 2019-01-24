<template>
    <div class="container">
        <p>Create new accessory .</p>
        <form v-on:submit.prevent="save()">
            <label>Mark:</label>
            <input v-model="workplace.mark" type="text">
            <label>Description:</label>
            <textarea v-model="workplace.description"></textarea>

            <button class="btn">Add</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                workplace: {
                    mark: '',
                    description: ''
                }
            }
        },
        methods: {
            save: function () {
                window.axios({
                    method: 'post',
                    url: '/api/workplaces',
                    data: this.workplace
                }).then(response => {
                    console.log(response)
                }).catch(error => {
                    console.log(error.response.data)
                });
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>