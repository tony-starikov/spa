<template>
    <div class="col-12">

        <div class="row mt-3">

            <h2>Apartments</h2>

            <div v-for="(apartment, index) in apartments.data" :key="index" class="col-6 col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <p>{{apartment.id}}</p>
                        <p>{{apartment.name}}</p>
                        <img :src="`${$store.state.serverPath}/storage/${apartment.image}`" class="img-fluid" :alt="apartment.name">
                    </div>
                </div>
            </div>
        </div>

        <advanced-laravel-vue-paginate :data="apartments" @paginateTo="loadApartments"/>

    </div>

</template>

<script>
import * as apartmentService from '../services/apartment_service'
export default {
    name: 'Main',
    data() {
        return {
            apartments: {},
        }
    },
    mounted() {
        this.loadApartments();
    },
    methods: {
        loadApartments: async function(page = 1) {
            try {
                const response = await apartmentService.loadAllApartmentPaginate(page);
                this.apartments = response.data;
            } catch (error) {
                this.flashMessage.error({
                    message: 'Some error occurred, Please refresh!',
                    time: 5000
                });
            }
        },
    }
}
</script>
