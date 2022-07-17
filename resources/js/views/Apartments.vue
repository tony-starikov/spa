<template>
    <div class="col-12">
        <h1 class="mt-3">Apartments</h1>

        <form v-on:submit.prevent="createApartment">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" v-model="apartmentData.name" class="form-control" id="name">
                <div class="invalid-feedback d-inline-block" v-if="errors.name">{{errors.name[0]}}</div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <div class="my-3" v-if="apartmentData.image.name">
                    <img alt="img" src="" ref="newApartmentImageDisplay">
                </div>
                <input type="file" v-on:change="attachImage" ref="newApartmentImage" class="form-control" id="image">
                <div class="invalid-feedback d-inline-block" v-if="errors.image">{{errors.image[0]}}</div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</template>

<script>
    import * as apartmentService from '../services/apartment_service'
    export default {
        name: 'apartment',
        data() {
            return {
                apartmentData: {
                    name: '',
                    image: ''
                },
                errors: {}
            }
        },
        methods: {
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
                } catch (error) {
                    // console.log(error.response.status);
                    switch (error.response.status) {
                        case 422:
                            this.errors = error.response.data.errors;
                            break;
                        default:
                            alert('Some error occured');
                            break;
                    }
                }
            }
        }
    }
</script>
