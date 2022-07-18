<template>
    <div class="col-12">
        <div class="row mt-3">
            <h1>Apartments</h1>

            <h2>Create new apartment</h2>

            <form v-on:submit.prevent="createApartment">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" v-model="apartmentData.name" class="form-control" id="name">
                    <div class="invalid-feedback d-inline-block" v-if="errors.name">{{errors.name[0]}}</div>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <div class="my-3" v-if="apartmentData.image.name">
                        <img class="img-fluid" alt="img" src="" ref="newApartmentImageDisplay">
                    </div>
                    <input type="file" v-on:change="attachImage" ref="newApartmentImage" class="form-control" id="image">
                    <div class="invalid-feedback d-inline-block" v-if="errors.image">{{errors.image[0]}}</div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div class="row mt-3">

            <h2>Apartments list</h2>

            <div v-for="(apartment, index) in apartments" :key="index" class="col-6 col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <p>{{apartment.id}}</p>
                        <p>{{apartment.name}}</p>
                        <img :src="`${$store.state.serverPath}/storage/${apartment.image}`" class="img-fluid" :alt="apartment.name">
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import * as apartmentService from '../services/apartment_service'
    export default {
        name: 'apartment',
        data() {
            return {
                apartments: [],
                apartmentData: {
                    name: '',
                    image: ''
                },
                errors: {}
            }
        },
        mounted() {
            this.loadApartment();
        },
        methods: {
            loadApartment: async function() {
                try {
                    const response = await apartmentService.loadAllApartment();
                    this.apartments = response.data.data;
                    console.log(this.apartments);
                } catch (error) {
                    this.flashMessage.error({
                        message: 'Some error occurred, Please refresh!',
                        time: 5000
                    });
                }
            },
            attachImage() {
                this.apartmentData.image = this.$refs.newApartmentImage.files[0];
                let reader = new FileReader();

                reader.addEventListener('load', function () {
                    this.$refs.newApartmentImageDisplay.src = reader.result
                }.bind(this), false);

                reader.readAsDataURL(this.apartmentData.image);
            },
            createApartment: async function() {
                let formData = new FormData();
                formData.append('name', this.apartmentData.name);
                formData.append('image', this.apartmentData.image);

                try {
                    const response = await apartmentService.createApartment(formData);
                    // console.log(response);

                    this.apartments.unshift(response.data)

                    this.flashMessage.success({
                        message: 'Apartment stored successfully!',
                        time: 5000
                    });
                } catch (error) {
                    // console.log(error.response.status);
                    switch (error.response.status) {
                        case 422:
                            this.errors = error.response.data.errors;
                            break;
                        default:
                            this.flashMessage.error({
                                message: 'Some error occurred, Please try again!',
                                time: 5000
                            });
                            break;
                    }
                }
            }
        }
    }
</script>
