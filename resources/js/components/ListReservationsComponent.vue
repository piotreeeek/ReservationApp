<template>
    <div class="container">
        <reservation-component></reservation-component>
        <table class="table table-bordered">
            <thead>
            <tr><th>User name</th><th>User email</th><th>Workplace mark</th><th>Occupation time</th><th>Options</th></tr>
            </thead>
            <tbody>
            <tr v-for="reservation in reservations">
                <td>{{ reservation.user.name }} {{reservation.user.surname}} </td>
                <td>{{ reservation.user.email }}</td>
                <td>{{ reservation.workplace.mark }}</td>
                <td>{{ reservation.occupation_time }}</td>
                <td>
                    <button v-if="new Date(reservation.occupation_time) > new Date()" @click="deleteReservation(reservation.id)">Delete</button>
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
                });
            },
            deleteReservation: function (id) {
                window.axios({
                    method: 'delete',
                    url: '/api/reservations/' + id
                }).then(response => {
                    Event.$emit('clearAddEditComponent');
                    this.readReservations()
                });
            },
            editReservation: function(id) {
                Event.$emit('editReservation', id)
            }
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