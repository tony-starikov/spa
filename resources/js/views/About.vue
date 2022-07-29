<template>
    <div class="col-12">

        <div class="row mt-3">

            <h2>About</h2>

        </div>

        <advanced-laravel-vue-paginate :data="apartments" @paginateTo="loadApartments"/>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
