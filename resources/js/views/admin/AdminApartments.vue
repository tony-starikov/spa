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

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form v-on:submit.prevent="updateApartment">
                            <div class="mb-3">
                                <label for="nameEdit" class="form-label">Name</label>
                                <input type="text" v-model="editApartmentData.name" class="form-control" id="nameEdit">
                                <div class="invalid-feedback d-inline-block" v-if="errors.name">{{errors.name[0]}}</div>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <div class="my-3" v-if="editApartmentData.image">
                                    <img class="img-fluid" alt="img" :src="`${$store.state.serverPath}/storage/${editApartmentData.image}`" ref="editApartmentImageDisplay">
                                </div>
                                <input type="file" v-on:change="editAttachImage" ref="editApartmentImage" class="form-control" id="imageEdit">
                                <div class="invalid-feedback d-inline-block" v-if="errors.image">{{errors.image[0]}}</div>
                            </div>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-3">

            <h2>Apartments list</h2>

            <div v-for="(apartment, index) in apartments.data" :key="index" class="col-6 col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <p>{{apartment.id}}</p>
                        <p>{{apartment.name}}</p>
                        <img :src="`${$store.state.serverPath}/storage/${apartment.image}`" class="img-fluid" :alt="apartment.name">
                        <div class="btn-group mt-3" role="group">
                            <!-- Button trigger modal -->
                            <button v-on:click="editApartment(apartment)" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Update</button>
                            <button v-on:click="deleteApartment(apartment)" type="button" class="btn btn-outline-primary">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <advanced-laravel-vue-paginate :data="apartments" @paginateTo="loadApartments"/>

    </div>

</template>

<script>
import * as apartmentService from '../../services/admin_apartment_service';
export default {
    name: 'apartments',
    data() {
        return {
            apartments: {},
            apartmentData: {
                name: '',
                image: ''
            },
            editApartmentData: {
                id: '',
                name: '',
                image: ''
            },
            errors: {}
        }
    },
    mounted() {
        this.loadApartments();
    },
    methods: {
        // async getResults(page = 1) {
        //     const response = await apartmentService.loadAllApartmentPaginate(page);
        //     this.laravelData = response.data;
        // },
        loadApartments: async function(page = 1) {
            try {
                const response = await apartmentService.loadAdminAllApartmentPaginate(page);
                this.apartments = response.data;
                // const response = await apartmentService.loadAllApartment();
                // this.apartments = response.data.data;
                // console.log(this.apartments);
                // console.log(response.meta);
            } catch (error) {
                this.flashMessage.error({
                    message: 'Some error occurred, Please refresh!',
                    time: 5000
                });
            }
        },
        editApartment: async function(apartment) {
            this.editApartmentData.id = apartment.id;
            this.editApartmentData.name = apartment.name;
            this.editApartmentData.image = apartment.image;
            console.log(apartment.id);
        },
        updateApartment: async function() {
            try {
                const formData = new FormData();
                formData.append('name', this.editApartmentData.name);
                formData.append('image', this.editApartmentData.image);
                formData.append('_method', 'put');

                const response = await apartmentService.updateAdminApartment(this.editApartmentData.id, formData);
                // await console.log(response.data);
                // await this.apartments.data.map(
                //     apartment => {
                //         if (apartment.id == response.data.id) {
                //             apartment.name = response.data.name;
                //             apartment.image = response.data.image;
                //             // console.log(response.data);
                //             // for (let key in response.data) {
                //             //     console.log(apartment.key);
                //             //     apartment.key = response.data[key];
                //             // }
                //         }
                //     }
                // );

                await this.loadAllApartmentPaginate();

                this.flashMessage.success({
                    message: 'Apartment updated successfully!',
                    time: 5000
                });
            } catch (error) {
                // console.log(error);
                this.flashMessage.error({
                    message: 'Some error occurred on update, Please refresh!',
                    time: 5000
                });
            }

            this.hideEditApartmentModal();
        },
        deleteApartment: async function(apartment) {
            if (!window.confirm(`Are you sure you want to delete ${apartment.name}`)) {
                return;
            }

            try {
                await apartmentService.deleteAdminApartment(apartment.id);

                // this.apartments.data = this.apartments.data.filter(
                //     obj => {
                //         return obj['id'] != apartment.id;
                //     }
                // );

                await this.loadApartments();

                this.flashMessage.success({
                    message: 'Apartment deleted successfully!',
                    time: 5000
                });
            } catch (error) {
                this.flashMessage.error({
                    message: error.response.data.message,
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
        editAttachImage() {
            this.editApartmentData.image = this.$refs.editApartmentImage.files[0];
            let reader = new FileReader();

            reader.addEventListener('load', function () {
                this.$refs.editApartmentImageDisplay.src = reader.result
            }.bind(this), false);

            reader.readAsDataURL(this.editApartmentData.image);
        },
        createApartment: async function() {
            let formData = new FormData();
            formData.append('name', this.apartmentData.name);
            formData.append('image', this.apartmentData.image);

            try {
                const response = await apartmentService.createAdminApartment(formData);
                // console.log(response);

                // this.apartments.data = Object.entries(this.apartments.data);
                //
                // Object.assign()
                // this.apartments.data.unshift(response.data);
                //
                // this.apartments.data = Object.fromEntries(this.apartments.data);

                // await console.log(this.apartments.data);

                await this.loadAllApartmentPaginate();

                this.flashMessage.success({
                    message: 'Apartment stored successfully!',
                    time: 5000
                });

                this.apartmentData = {
                    name: '',
                    image: ''
                }

                let input = document.getElementById('image');
                input.value = ''
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
        },
        hideEditApartmentModal() {
            console.log('modal closed');
            // this.$refs.exampleModal.on("hidden.bs.modal", () => {})
        }
    }
}
</script>
