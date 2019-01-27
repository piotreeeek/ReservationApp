<template>
    <div class="container">
        <div class="alert-success" v-if="success != false">{{ success }}</div>
        <p v-if="editing">Edit existing user.</p>
        <p v-else>Create new user.</p>
        <form v-on:submit.prevent="save()">
            <div class="form-group">
                <label>Name:</label>
                <input v-model="user.name" type="text">
                <p class="alert-danger" v-if="errors.name">{{ errors.name.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>Surname:</label>
                <input v-model="user.surname" type="text">
                <p class="alert-danger" v-if="errors.surname">{{ errors.surname.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>phone:</label>
                <input v-model="user.phone" type="tel" pattern="[0-9]{11}">
                <p class="alert-danger" v-if="errors.phone">{{ errors.phone.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea v-model="user.description"></textarea>
                <p class="alert-danger" v-if="errors.description">{{ errors.description.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input v-model="user.email" type="email">
                <p class="alert-danger" v-if="errors.email">{{ errors.email.join(' ') }}</p>
            </div>
            <button class="btn" v-if="editing">Save</button>
            <button class="btn" v-else>Add</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    name: '',
                    surname: '',
                    phone: '',
                    description: '',
                    email: ''
                },
                errors: false,
                success: false,
                editing: false,
                editUserId: ''
            }
        },
        methods: {
            save: function () {
                var method = this.editing ? 'put' : 'post';
                var url = this.editing ? '/api/users/' + this.editUserId : '/api/users';
                window.axios({
                    method: method,
                    url: url,
                    data: this.user
                }).then(response => {
                    console.log(response)
                    if(response.status === 201 || response.status === 200) {
                        this.success = response.status === 200 ? "Save edited user." : "Added new user";
                        this.clearComponent();
                        setTimeout(() => {
                            this.success = false;
                        }, 3000);

                        Event.$emit('refreshUsersTable')
                    }
                }).catch(error => {
                    console.log(error.response.data)
                    this.errors = error.response.data.errors;
                });
            },
            setEditingUser: function (editUserId) {
                window.axios({
                    method: 'get',
                    url: 'api/users/' + editUserId
                }).then(response => {
                    console.log(response.data)
                    this.editing = true;
                    this.user = {
                        name: response.data.name,
                        surname: response.data.surname,
                        phone: response.data.phone,
                        description: response.data.description,
                        email: response.data.email
                    }
                    this.editUserId = editUserId
                }).catch(error => {
                    console.log(error.response)
                })
            },
            clearComponent: function () {
                this.errors = false
                this.user = {
                    name: '',
                    surname: '',
                    phone: '',
                    description: '',
                    email: ''
                };
                this.editing = false;
                this.editUserId = ''
            }
        },
        mounted() {
            console.log('Component mounted.')

            Event.$on('editUser', (id) => {
                this.setEditingUser(id);
            })
            Event.$on('clearAddEditComponent', () =>{
                this.clearComponent();
            })
        }
    }
</script>

<style scoped>

</style>