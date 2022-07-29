<template>
    <div class="container-fluid px-0 vh-100">

        <h2>User Dashboard</h2>

        <router-link class="btn btn-primary"  role="button" to="/user/apartments">Apartments</router-link>

        <router-view></router-view>

    </div>
</template>

<script>
export default {
    mounted() {
        console.log('Component User mounted.')
    }
}
</script>
