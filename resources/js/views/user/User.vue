<template>
    <div class="container-fluid px-0 vh-100">

        <h2>User Dashboard</h2>

        <div class="row">
            <div v-if="$store.state.profile.role != null && $store.state.profile.email_verified != 0" class="col-md-12">
                <router-link class="btn btn-primary"  role="button" to="/user/apartments">Apartments</router-link>
            </div>
            <div v-else class="col-md-12">
                <router-link class="btn btn-primary"  role="button" to="/email-confirm">Verify your email</router-link>
            </div>
        </div>

        <router-view></router-view>

    </div>
</template>

<script>
import * as auth from "../../services/auth_service";

export default {
    mounted() {
        console.log('Component User mounted.');
        // console.log(this.$store.state.profile.email_verified);
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
}
</script>
