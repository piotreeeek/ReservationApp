<template>
    <div class="container">
        <workplace-component></workplace-component>
        <table class="table table-bordered">
            <thead>
            <tr><th>Mark</th><th>Description</th><td>Accessories</td><th>Options</th></tr>
            </thead>
            <tbody>
            <tr v-for="workplace in workplaces">
                <td>{{ workplace.mark}}</td>
                <td>{{ workplace.description }}</td>
                <td>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Model</th>
                                <th>Mark</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="accessory in workplace.accessories">
                                <td>{{ accessory.model }}</td>
                                <td>{{ accessory.mark }}</td>
                                <td>{{ accessory.value }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <button v-if="workplace.accessories.length === 0" @click="deleteWorkplace(workplace.id)">Delete</button>
                    <button @click="editWorkplace(workplace.id)">Edit</button>
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
                workplaces: []
            }
        },
        methods: {
            readWorkplaces: function () {
                window.axios({
                    method: 'get',
                    url: '/api/workplaces'
                }).then(response => {
                    this.workplaces = response.data
                    console.log(response)
                }).catch(error => {
                    console.log(error.response)
                });
            },
            deleteWorkplace: function (id) {
                window.axios({
                    method: 'delete',
                    url: '/api/workplaces/' + id
                }).then(response => {
                    Event.$emit('clearAddEditComponent');
                    this.readWorkplaces()
                    console.log(response);
                }).catch(error => {
                    console.log(error.response)
                });
            },
            editWorkplace: function (workplaceId) {
                Event.$emit('editWorkplace', workplaceId)
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.readWorkplaces();

            Event.$on('refreshWorkplacesTable', () => {
                this.readWorkplaces();
            })
        }
    }
</script>