<template>
    <div class="container-fluid px-0">

        <Header />

        <div class="container" style="min-height: 80vh">
            <div class="row">
                <router-view></router-view>
            </div>
        </div>

        <Footer />
    </div>
</template>

<script>
    import Footer from "./Footer";
    export default {
        components: {Footer},
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
