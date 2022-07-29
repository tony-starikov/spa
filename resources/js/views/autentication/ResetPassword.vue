<template>
    <div class="col-12 col-md-4 mx-auto">
        <div class="card mt-5">
            <div class="card-header">
                Reset Password
            </div>
            <div class="card-body">
                <h2 class="text-center">Reset your password</h2>
                <form v-on:submit.prevent="onSubmit">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input v-model="user.email" type="email" class="form-control" id="email">
                        <div class="invalid-feedback d-inline-block" v-if="errors.email">{{errors.email[0]}}</div>
                    </div>
                    <div class="mb-3">
                        <label for="verification_code" class="form-label">Verification code</label>
                        <input v-model="user.verification_code" type="text" class="form-control" id="verification_code" required>
                        <div class="invalid-feedback d-inline-block" v-if="errors.verification_code">{{errors.verification_code[0]}}</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input v-model="user.password" type="password" class="form-control" name="password" id="password" placeholder="Enter new password" required>
                        <div class="invalid-feedback d-inline-block" v-if="errors.password">{{errors.password[0]}}</div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Password Confirm</label>
                        <input v-model="user.password_confirmation" type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                        <div class="invalid-feedback d-inline-block" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <router-link class="d-block link-primary" to="/reset-password-request">Resend Verification Code</router-link>
                <router-link class="d-block link-primary" to="/register">Register an Account</router-link>
                <router-link class="d-block link-primary" to="/login">Login</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import * as auth from "../../services/auth_service";
    export default {
        name: 'ResetPassword',
        data () {
            return {
                user: {
                    email: '',
                    verification_code: '',
                    password: '',
                    password_confirmation: '',
                },
                errors: {},
            }
        },
        beforeRouteEnter(to, from, next) {
            next(vm => {
                vm.user.email = to.params.email;
            });
        },
        mounted() {
            console.log('Component ResetPassword mounted.')
        },
        methods: {
            onSubmit: async function () {
                try {
                    this.error = {};
                    const response = await auth.resetPassword(this.user);

                    this.flashMessage.success({
                        message: response.data.message,
                        time: 5000
                    });

                    this.$router.push('/login');
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
