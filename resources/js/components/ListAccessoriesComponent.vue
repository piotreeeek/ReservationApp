<template>
    <div class="container">
        <table class="table">
            <thead>
            <tr><th>Model</th><th>Options</th></tr>
            </thead>
            <tbody>
            <tr v-for="accessory in accessories"><td>{{ accessory.model }}</td><td><button @click="deleteAccessory(accessory.id)">Delete</button></td></tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                accessories: []
            }
        },
        methods: {
            readAccessories: function () {
                window.axios({
                    method: 'get',
                    url: '/api/accessories'
                }).then(response => {
                    this.accessories = response.data
                    console.log(response)
                }).catch(error => {
                    console.log(error.data);
                });
            },
            deleteAccessory: function (id) {
                window.axios({
                    method: 'delete',
                    url: '/api/accessories/' + id
                }).then(response => {
                    console.log(response)
                    this.readAccessories()
                }).catch(error => {
                    console.log(error.response)
                });
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.readAccessories();
        }
    }
</script>