<template>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="card card-default" style="width: 500px">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <div class="alert alert-danger" v-if="hasError && !success">
                        <p>{{ message }}</p>
                    </div>
                    <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">

                        <div class="form-group" v-bind:class="{ 'has-error': hasError && errors.name }">
                            <label for="name">Name:</label>
                            <input type="text" id="name" class="form-control" placeholder="Your name" v-model="name">
                            <span class="help-block text-danger" v-if="hasError && errors.name">{{ errors.name[0] }}</span>
                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': hasError && errors.email }">
                            <label for="email">E-mail:</label>
                            <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email">
                            <span class="help-block text-danger" v-if="hasError && errors.email">{{ errors.email[0] }}</span>
                        </div>
                        <div class="form-group" v-bind:class="{ 'has-error': hasError && errors.password }">
                            <label for="password">Password:</label>
                            <input type="password" id="password" class="form-control" v-model="password">
                            <span class="help-block text-danger" v-if="hasError && errors.password">{{ errors.password[0] }}</span>
                        </div>
                        <div class="form-group" v-bind:class="{ 'has-error': hasError && errors.password }">
                            <label for="password_confirmation">Password confirmation:</label>
                            <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-outline-info">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                hasError: false,
                message: '',
                errors: {},
                success: false
            }
        },
        mounted() {
            //this.$router.push({name: 'login', params: {successRegistrationRedirect: true}});
        },
        methods: {
            register() {

                let self = this;
                this.$auth.register({
                    data: {
                        name: self.name,
                        email: self.email,
                        password: self.password,
                        password_confirmation: self.password_confirmation
                    },
                    success: function () {
                        self.success = true;
                        self.$router.push({path: '/auth/login'});
                    },
                    error: function (res) {
                        self.hasError = true;
                        self.message = res.response.data.message;
                        self.errors = res.response.data.errors || {};
                    }
                })
            }
        }
    }
</script>
