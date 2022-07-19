<template>
    <div class="col-4 mx-auto">
        <div class="card mt-5">
            <div class="card-header">
                Reset Password
            </div>
            <div class="card-body">
                <h2 class="text-center">Forgot your password?</h2>
                <p class="text-center">
                    Enter your email address and we wil send you instructions on how to reset your password.
                </p>
                <form>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
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
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
