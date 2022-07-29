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
                        <router-link class="nav-link" to="/register">Register</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/login">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/reset-password-request">Reset Password</router-link>
                    </li>
                    <li v-if="$store.state.profile.role != null" class="nav-item">
                        <a class="nav-link" v-on:click="logout">Logout</a>
                    </li>
                    <li v-if="$store.state.profile.role != null && $store.state.profile.role === 'admin'" class="nav-item">
                        <router-link class="nav-link" to="/admin">Dashboard</router-link>
                    </li>
                    <li v-if="$store.state.profile.role != null && $store.state.profile.role === 'user'" class="nav-item">
                        <router-link class="nav-link" to="/user">Dashboard</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import * as auth from '../services/auth_service';
    export default {
        name: 'Header',
        mounted() {
            console.log('Component Header mounted.');
        },
        beforeCreate: async function() {
            try {
                if (auth.isLoggedIn()) {
                    const response = await auth.getProfile();
                    this.$store.dispatch('authenticate', response.data);
                }
            } catch (error) {
                auth.logout();
            }
        },
        methods: {
            logout: async function() {
                if (auth.isLoggedIn()) {
                    auth.logout();
                    if (this.$router.path !== '/login') {
                        this.$router.push('/login');
                    }
                }
            },
        },
    }
</script>
