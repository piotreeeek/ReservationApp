<template>
    <div class="container">
        <div class="alert-success" v-if="success != false">{{ success }}</div>
        <p>Create new accessory .</p>
        <form v-on:submit.prevent="save()">
            <div class="form-group">
                <label>Mark:</label>
                <input v-model="workplace.mark" type="text">
                <p class="alert-danger" v-if="errors.mark">{{ errors.mark.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea v-model="workplace.description"></textarea>
                <p class="alert-danger" v-if="errors.description">{{ errors.description.join(' ') }}</p>
            </div>

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
                },
                errors: false,
                success: false
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
                    this.success = "Added new Workplace"
                    setTimeout(() => {
                        this.success = false;
                    }, 3000);
                    this.errors = false
                }).catch(error => {
                    console.log(error.response.data)
                    this.errors = error.response.data.errors;
                });
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>