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
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
