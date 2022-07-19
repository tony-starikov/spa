<template>
    <div class="col-12 col-md-4 mx-auto">
        <div class="card mt-5">
            <div class="card-header">
                Register an Account
            </div>
            <div class="card-body">
                <form v-on:submit.prevent="register">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input v-model="user.name" type="text" class="form-control" id="name" name="name">
                        <div class="invalid-feedback d-inline-block" v-if="errors.name">{{errors.name[0]}}</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input v-model="user.email" type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                        <div class="invalid-feedback d-inline-block" v-if="errors.email">{{errors.email[0]}}</div>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input v-model="user.password" type="password" class="form-control" name="password" id="password">
                        <div class="invalid-feedback d-inline-block" v-if="errors.password">{{errors.password[0]}}</div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Password Confirm</label>
                        <input v-model="user.password_confirmation" type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                        <div class="invalid-feedback d-inline-block" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <router-link class="d-block link-primary" to="/reset-password">Reset Password</router-link>
                <router-link class="d-block link-primary" to="/login">Login</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import * as auth from '../../services/auth_service'
    export default {
        name: 'Register',
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                user: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
                errors: {},
            }
        },
        methods: {
            register: async function() {
                try {
                    await auth.register(this.user);
                    this.errors = {};
                    this.user = {
                        name: '',
                        email: '',
                        password: '',
                        password_confirmation: '',
                    };
                    this.flashMessage.success({
                        message: 'Registered successfully!',
                        time: 5000
                    });
                    this.$router.push('login');
                } catch (error) {
                    switch (error.response.status) {
                        case 422:
                            this.errors = error.response.data.errors;
                            break;
                        case 500:
                            this.flashMessage.error({
                                message: error.response.data.message,
                                time: 5000
                            });
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
