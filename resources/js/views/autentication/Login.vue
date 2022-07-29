<template>
    <div class="col-12 col-md-4 mx-auto">
        <div class="card mt-5">
            <div class="card-header">
                Login
            </div>
            <div class="card-body">
                <form v-on:submit.prevent="login">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input v-model="user.email" type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                        <div class="invalid-feedback d-inline-block" v-if="errors.email">{{errors.email[0]}}</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input v-model="user.password" type="password" class="form-control" name="password" id="password">
                        <div class="invalid-feedback d-inline-block" v-if="errors.password">{{errors.password[0]}}</div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me">
                        <label class="form-check-label" for="remember_me">Remember me</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <router-link class="d-block link-primary" to="/register">Register an Account</router-link>
                <router-link class="d-block link-primary" to="/reset-password">Reset Password</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import * as auth from "../../services/auth_service";
    export default {
        name: 'Login',
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                user: {
                    email: '',
                    password: '',
                    remember_me: false,
                },
                errors: {},
            }
        },
        methods: {
            login: async function() {
                try {
                    const response = await auth.login(this.user);

                    console.log(response);
                    this.errors = {};
                    this.user = {
                        name: '',
                        email: '',
                        remember_me: false,
                    };

                    this.flashMessage.success({
                        message: 'Login successfully!',
                        time: 5000
                    });

                    if (auth.getUserRole() === 'admin') {
                        this.$router.push('/admin');
                    } else {
                        this.$router.push('/user');
                    }

                    // this.$router.push('/');
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
        },
    }
</script>
