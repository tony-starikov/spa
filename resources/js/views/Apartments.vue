<template>
    <div class="col-12">
        <h1>Apartments</h1>

        <form v-on:submit.prevent="createApartment">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" v-model="apartmentData.name" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Name</label>
                <input type="file" v-on:change="attachImage" class="form-control" id="image">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</template>

<script>
    export default {
        name: 'apartment',
        data() {
            return {
                apartmentData: {
                    name: '',
                    image: ''
                }
            }
        },
        methods: {
            attachImage() {
                // use file reader
            },
            createApartment() {
                console.log('form submitted')
            }
        }
    }
</script>
