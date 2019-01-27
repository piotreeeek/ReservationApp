<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <div>ReservationApp</div>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <router-link tag="li" :to="{ name: 'reservations' }">
                            <a class="nav-link">Reservations</a>
                        </router-link>
                        <router-link tag="li" :to="{ name: 'reservation' }">
                            <a class="nav-link">Create reservation</a>
                        </router-link>
                        <router-link tag="li" :to="{ name: 'types' }">
                            <a class="nav-link">Types</a>
                        </router-link>
                        <router-link tag="li" :to="{ name: 'type' }">
                            <a class="nav-link">Create type</a>
                        </router-link>
                        <router-link tag="li" :to="{ name: 'accessories' }">
                            <a class="nav-link">Accessories</a>
                        </router-link>
                        <router-link tag="li" :to="{ name: 'accessory' }">
                            <a class="nav-link">Create accessory</a>
                        </router-link>
                        <router-link tag="li" :to="{ name: 'workplaces' }">
                            <a class="nav-link">Workplaces</a>
                        </router-link>
                        <router-link tag="li" :to="{ name: 'workplace' }">
                            <a class="nav-link">Create workplace</a>
                        </router-link>
                        <router-link tag="li" :to="{ name: 'users' }">
                            <a class="nav-link">Users</a>
                        </router-link>
                        <router-link tag="li" :to="{ name: 'user' }">
                            <a class="nav-link">Create user</a>
                        </router-link>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <router-view></router-view>
        </main>
    </div>
    
</template>

<script>
    export default {
        name: "LayoutComponent"
    }
</script>

<style scoped>

</style>