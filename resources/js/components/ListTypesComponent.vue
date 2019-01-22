<template>
    <div class="container">
        <table class="table">
            <thead>
            <tr><th>Name</th><th>Options</th></tr>
            </thead>
            <tbody>
                <tr v-for="type in types"><td>{{ type.name }}</td><td><button @click="deleteType(type.id)">Delete</button></td></tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                types: []
            }
        },
        methods: {
            readTypes: function () {
                window.axios({
                    method: 'get',
                    url: '/api/types'
                }).then(response => {
                    this.types = response.data
                });
            },
            deleteType: function (id) {
                window.axios({
                    method: 'delete',
                    url: '/api/types/' + id
                }).then(response => {
                    this.readTypes()
                });
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.readTypes();
        }
    }
</script>