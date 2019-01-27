<template>
    <div class="container">
        <table class="table">
            <thead>
            <tr><th>User</th><th>Workplace</th><th>Occupation time</th><th>Options</th></tr>
            </thead>
            <tbody>
            <tr v-for="reservation in reservations">
                <td>{{ reservation.user.name }} {{reservation.user.surname}} </td>
                <td>{{ reservation.workplace.mark }}</td>
                <td>{{ reservation.occupation_time }}</td>
                <td>
                    <button @click="deleteReservation(reservation.id)">Delete</button>
                    <button @click="editReservation(reservation.id)">Edit</button>
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
                reservations: []
            }
        },
        methods: {
            readReservations: function () {
                window.axios({
                    method: 'get',
                    url: '/api/reservations'
                }).then(response => {
                    this.reservations = response.data;
                    console.log(response)
                }).catch(error => {
                    console.log(error.data);
                });
            },
            deleteReservation: function (id) {
                window.axios({
                    method: 'delete',
                    url: '/api/reservations/' + id
                }).then(response => {
                    console.log(response);
                    Event.$emit('clearAddEditComponent');
                    this.readReservations()
                }).catch(error => {
                    console.log(error.response)
                });
            },
            // editUser: function(id) {
            //     Event.$emit('editUser', id)
            // }
        },
        mounted() {
            console.log('Component mounted.')
            this.readReservations();

            Event.$on('refreshReservationsTable', () => {
                this.readReservations();
            })
        }
    }
</script>

<style scoped>

</style>