<template>
    <div class="col-12 col-md-4 mx-auto">
        <div class="card mt-5">
            <div class="card-header">
                Reset Password Request
            </div>
            <div class="card-body">
                <h2 class="text-center">Forgot your password?</h2>
                <p class="text-center">
                    Enter your email address and we wil send you instructions on how to reset your password.
                </p>
                <form v-on:submit.prevent="onSubmit">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input v-model="user.email" type="email" class="form-control" id="email" aria-describedby="emailHelp" required>
                        <div class="invalid-feedback d-inline-block" v-if="errors.email">{{errors.email[0]}}</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Reset Password Request</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <router-link class="d-block link-primary" to="/register">Register an Account</router-link>
                <router-link class="d-block link-primary" to="/login">Login</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import * as auth from "../../services/auth_service";
export default {
    name: 'ResetPasswordRequest',
    data () {
        return {
            user: {
                email: '',
            },
            errors: {},
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        onSubmit: async function () {

            // this.$router.push({name: 'reset-password', params: {email: this.user.email} });
            try {
                this.error = {};
                const response = await auth.resetPasswordRequest(this.user);

                this.flashMessage.success({
                    message: response.data.message,
                    time: 5000
                });

                this.$router.push({name: 'reset-password', params: {email: this.user.email} });

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
