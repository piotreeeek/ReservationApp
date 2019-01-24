<template>
    <div class="container">
        <table class="table">
            <thead>
            <tr><th>Mark</th><th>Options</th></tr>
            </thead>
            <tbody>
            <tr v-for="workplace in workplaces"><td>{{ workplace.mark}}</td><td><button @click="deleteType(workplace.id)">Delete</button></td></tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                workplaces: []
            }
        },
        methods: {
            readTypes: function () {
                window.axios({
                    method: 'get',
                    url: '/api/workplaces'
                }).then(response => {
                    this.workplaces = response.data
                    console.log(response)
                });
            },
            deleteType: function (id) {
                window.axios({
                    method: 'delete',
                    url: '/api/workplaces/' + id
                }).then(response => {
                    this.readTypes()
                    console.log(response);
                }).catch(error => {
                    console.log(error.response)
                });
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.readTypes();
        }
    }
</script>