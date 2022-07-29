<template>
    <div class="col-12 col-md-4 mx-auto">
        <div class="card mt-5">
            <div class="card-header">
                Confirm Email
            </div>
            <div class="card-body">
                <h2 class="text-center">Confirm your email</h2>
                <form v-on:submit.prevent="onSubmit">
                    <div class="mb-3">
                        <label for="verification_code" class="form-label">Verification code</label>
                        <input v-model="user.email_verification_code" type="text" class="form-control" id="verification_code" required>
                        <div class="invalid-feedback d-inline-block" v-if="errors.email_verification_code">{{errors.email_verification_code[0]}}</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Confirm Email</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <a class="d-block link-primary" v-on:click.prevent="emailResend">Resend Email Verification Code</a>
                <router-link class="d-block link-primary" to="/register">Register an Account</router-link>
                <router-link class="d-block link-primary" to="/login">Login</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import * as auth from "../../services/auth_service";
    export default {
        name: 'EmailConfirm',
        data () {
            return {
                user: {
                    email_verification_code: '',
                },
                errors: {},
            }
        },
        mounted() {
            console.log('Component EmailConfirm mounted.')
        },
        methods: {
            emailResend: async function () {
                try {
                    this.error = {};
                    const response = await auth.emailResend();

                    this.flashMessage.success({
                        message: response.data.message,
                        time: 5000
                    });
                } catch (error) {
                    switch (error.response.status) {
                        case 422:
                            this.errors = error.response.data.errors;
                            break;
                        case 401:
                            this.flashMessage.error({
                                message: error.response.data.message,
                                time: 5000
                            });
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
            },
            onSubmit: async function () {
                try {
                    this.error = {};
                    let response = await auth.emailConfirm(this.user);

                    this.flashMessage.success({
                        message: response.data.message,
                        time: 5000
                    });

                    response = await auth.getProfile();
                    this.$store.dispatch('authenticate', response.data);

                    this.$router.push('/user');
                } catch (error) {
                    switch (error.response.status) {
                        case 422:
                            this.errors = error.response.data.errors;
                            break;
                        case 401:
                            this.flashMessage.error({
                                message: error.response.data.message,
                                time: 5000
                            });
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
