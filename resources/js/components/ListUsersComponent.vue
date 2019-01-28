<template>
    <div class="container">
        <user-component></user-component>
        <table class="table table-bordered">
            <thead>
            <tr><th>Name</th><th>Email</th><th>Options</th></tr>
            </thead>
            <tbody>
            <tr v-for="user in users">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                    <button v-if="user.reservations.length === 0" @click="deleteUser(user.id)">Delete</button>
                    <button @click="editUser(user.id)">Edit</button>
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
                users: []
            }
        },
        methods: {
            readUsers: function () {
                window.axios({
                    method: 'get',
                    url: '/api/users'
                }).then(response => {
                    this.users = response.data;
                    console.log(response)
                }).catch(error => {
                    console.log(error.data);
                });
            },
            deleteUser: function (id) {
                window.axios({
                    method: 'delete',
                    url: '/api/users/' + id
                }).then(response => {
                    console.log(response);
                    Event.$emit('clearAddEditComponent');
                    this.readUsers()
                }).catch(error => {
                    console.log(error.response)
                });
            },
            editUser: function(id) {
                Event.$emit('editUser', id)
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.readUsers();

            Event.$on('refreshUsersTable', () => {
                this.readUsers();
            })
        }
    }
</script>

<style scoped>

</style>