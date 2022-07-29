<template>
    <div class="container-fluid px-0 vh-100">

        <h2>Admin Dashboard</h2>

        <router-link class="btn btn-primary"  role="button" to="/admin/apartments">Apartments</router-link>

        <router-view></router-view>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component Admin mounted.')
        }
    }
</script>
