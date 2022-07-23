<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-0">
        <div class="container">
            <router-link class="navbar-brand" to="/">MyBooking</router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/" exact>Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/about">About</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/apartments">Apartments</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/register">Register</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/login">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/reset-password">Reset Password</router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" v-on:click="logout">Logout</a>
                    </li>
                    <li class="nav-item" v-if="$store.state.profile.role != null">
                        <a class="nav-link" v-on:click="userScope()">User</a>
                    </li>
                    <li class="nav-item" v-if="$store.state.profile.role != null">
                        <a class="nav-link" v-on:click="adminScope()">Admin</a>
                    </li>
<!--                    <li class="nav-item" v-if="$store.state.role == 'user'">-->
<!--                        <a class="nav-link">{{$store.state.profile.role}}</a>-->
<!--                    </li>-->
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import * as auth from '../services/auth_service'
    import * as user from '../services/user_service'
    export default {
        name: 'Header',
        mounted() {
            console.log('Component Header mounted.');
        },
        methods: {
            logout: async function() {
                if (auth.isLoggedIn()) {
                    auth.logout();
                }
                this.$router.push('/login');
            },
            userScope: async function() {
                try {
                    const response = await user.userScope();
                    console.log(response);
                } catch (error) {
                    console.log(' ' + error, error.response.status);
                }
            },
            adminScope: async function() {
                try {
                    const response = await user.adminScope();
                    console.log(response);
                } catch (error) {
                    console.log(' ' + error, error.response.status);
                }
            },
        },
    }
</script>
