<template>
    <div class="container-fluid px-0 vh-100">

        <Header />

        <div class="container" style="min-height: 80vh">
            <div class="row">
                <router-view></router-view>
            </div>
        </div>

        <FlashMessage :position="'right bottom'"></FlashMessage>

        <Footer />
    </div>
</template>

<script>
    import * as auth from '../services/auth_service';
    export default {
        name: 'App',
        mounted() {
            console.log('Component App mounted.')
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
