<template>
    <div class="container">
        <type-component></type-component>
        <table class="table">
            <thead>
            <tr><th>Name</th><th>Options</th></tr>
            </thead>
            <tbody>
                <tr v-for="type in types">
                    <td>{{ type.name }}</td>
                    <td>
                        <button v-if="type.accessories.length < 1" @click="deleteType(type.id)">Delete</button>
                        <button @click="editType(type.id)">Edit</button>
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
                    console.log(response)
                }).catch(error => {
                    console.log(error.response)
                });
            },
            deleteType: function (id) {
                window.axios({
                    method: 'delete',
                    url: '/api/types/' + id
                }).then(response => {
                    console.log(response);
                    Event.$emit('clearAddEditComponent');
                    this.readTypes()
                }).catch(error => {
                    console.log(error.response)
                });
            },
            editType: function (typeId) {
                Event.$emit('editType', typeId)
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.readTypes();

            Event.$on('refreshTypesTable', () =>{
                this.readTypes();
            })
        }
    }
</script>