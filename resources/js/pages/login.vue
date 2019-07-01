<template>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="card card-default" style="width: 500px">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <div class="alert alert-danger" v-if="hasError">
                        <p>{{ message }}</p>
                    </div>
                    <form autocomplete="off" @submit.prevent="login" method="post">
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                            <span class="help-block text-danger" v-if="hasError && errors.email">{{ errors.email[0] }}</span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" class="form-control" v-model="password" required>
                            <span class="help-block text-danger" v-if="hasError && errors.password">{{ errors.password[0] }}</span>
                        </div>
                        <button type="submit" class="btn btn-outline-info">Login</button>
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
                email: null,
                password: null,
                hasError: false,
                message: '',
                errors: {},
            }
        },
        mounted() {
            //
        },
        methods: {
            login() {
                // get the redirect object
                let redirect = this.$auth.redirect();
                let app = this;
                this.$auth.login({
                    data: {
                        email: app.email,
                        password: app.password
                    },
                    success: function() {

                        const redirectTo = redirect ? redirect.from.name : 'dashboard';
                        this.$router.push({name: redirectTo})
                    },
                    error: function(res) {
                        app.hasError = true;
                        app.message = res.response.data.message;
                        app.errors = res.response.data.errors || {};
                    },
                    rememberMe: true,
                    fetchUser: true
                })
            }
        }
    }
</script>
