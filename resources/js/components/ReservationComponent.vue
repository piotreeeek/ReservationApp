<template>
    <div class="container">
        <div class="alert-success" v-if="success != false">{{ success }}</div>
        <p v-if="editing">Edit existing reservation.</p>
        <p v-else>Create new reservation.</p>
        <form v-on:submit.prevent="save()">
            <div class="form-group">
                <label>User:</label>
                <select v-model="reservation.user_id">
                    <option v-for="user in users" :value="user.id">{{ user.email }}</option>
                </select>
                <p class="alert-danger" v-if="errors.user_id">{{ errors.user_id.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>Workplace:</label>
                <select v-model="reservation.workplace_id">
                    <option v-for="workplace in workplaces" :value="workplace.id">{{ workplace.mark}}</option>
                </select>
                <p class="alert-danger" v-if="errors.workplace_id">{{ errors.workplace_id.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>Start time:</label>
                <input v-model="reservation.occupation_time" type="datetime-local" step="3600">
                <p class="alert-danger" v-if="errors.occupation_time">{{ errors.occupation_time.join(' ') }}</p>
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
                reservation: {
                    user_id: '',
                    workplace_id: '',
                    occupation_time: ''
                },
                users: [],
                workplaces: [],
                errors: false,
                success: false,
                editing: false,
                editReservationId: ''
            }
        },
        methods: {
            save: function () {
                var method = this.editing ? 'put' : 'post';
                var url = this.editing ? '/api/reservations/' + this.editReservationId : '/api/reservations';
                window.axios({
                    method: method,
                    url: url,
                    data: this.reservation
                }).then(response => {
                    console.log(response)
                    if (response.status === 201 || response.status === 200) {
                        this.success = response.status === 200 ? "Save edited reservation." : "Added new reservation";
                        this.clearComponent();
                        setTimeout(() => {
                            this.success = false;
                        }, 3000);

                        Event.$emit('refreshReservationsTable')
                    }
                }).catch(error => {
                    console.log(error.response.data)
                    this.errors = error.response.data.errors;
                });
            },
            fetchUsers: function () {
                window.axios({
                    method: 'get',
                    url: '/api/users'
                }).then(response => {
                    this.users = response.data
                    console.log(response)
                });
            },
            fetchWorkplaces: function () {
                window.axios({
                    method: 'get',
                    url: '/api/workplaces'
                }).then(response => {
                    this.workplaces = response.data
                    console.log(response)
                });
            },
            setEditingReservation: function (editReservationId) {
                window.axios({
                    method: 'get',
                    url: 'api/reservations/' + editReservationId
                }).then(response => {
                    console.log(response.data)
                    this.editing = true;
                    this.reservation = {
                        user_id: response.data.user_id,
                        workplace_id: response.data.workplace_id,
                        occupation_time: response.data.occupation_time.replace(' ', 'T').slice(0, 16)
                    }
                    this.editReservationId = editReservationId
                }).catch(error => {
                    console.log(error.response)
                })
            },
            clearComponent: function () {
                this.errors = false
                this.reservation = {
                    user_id: '',
                    workplace_id: '',
                    occupation_time: ''
                };
                this.editing = false;
                this.editReservationId = ''
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.fetchWorkplaces()
            this.fetchUsers()

            Event.$on('editReservation', (editReservationId) => {
                this.setEditingReservation(editReservationId);
            })
            Event.$on('clearAddEditComponent', () =>{
                this.clearComponent();
            })
        }
    }
</script>

<style scoped>

</style>