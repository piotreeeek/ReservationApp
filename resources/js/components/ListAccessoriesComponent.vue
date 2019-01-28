<template>
    <div class="container">
        <accessory-component></accessory-component>
        <table class="table table-bordered">
            <thead>
            <tr><th>Model</th><th>Mark</th><th>Options</th></tr>
            </thead>
            <tbody>
            <tr v-for="accessory in accessories">
                <td>{{ accessory.model }}</td>
                <td>{{ accessory.mark }}</td>
                <td>
                    <button v-if="!accessory.workplace" @click="deleteAccessory(accessory.id)">Delete</button>
                    <button @click="editAccessory(accessory.id)">Edit</button>
                </td>
            </tr>
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
                    this.accessories = response.data;
                });
            },
            deleteAccessory: function (id) {
                window.axios({
                    method: 'delete',
                    url: '/api/accessories/' + id
                }).then(response => {
                    Event.$emit('clearAddEditComponent');
                    this.readAccessories()
                });
            },
            editAccessory: function(accessoryId) {
                Event.$emit('editAccessory', accessoryId)
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.readAccessories();

            Event.$on('refreshAccessoriesTable', () => {
                this.readAccessories();
            })
        }
    }
</script>