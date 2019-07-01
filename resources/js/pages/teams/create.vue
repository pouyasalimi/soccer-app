<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">Create Team</div>
                    <div class="col-6 text-right"><router-link :to="{name: 'teams' , params: { }}" class="btn btn-dark btn-sm">Teams List</router-link></div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-danger" v-if="hasError">
                    <p>Can't create data</p>
                </div>
                <form autocomplete="off" @submit.prevent="create" v-if="!success" method="post">

                    <div class="form-group" v-bind:class="{ 'has-error': hasError && errors.name }">
                        <label for="name">Name:</label>
                        <input type="text" id="name" class="form-control" placeholder="Your name"
                               v-model="team.name">
                        <span class="help-block text-danger" v-if="hasError && errors.name">{{ errors.name[0] }}</span>
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {

        data() {
            return {
                hasError: false,
                team: {
                    name :''
                },
                success: false,
                errors: {},
            }
        },
        mounted() {

        },
        methods: {
            create() {
                let app = this;
                this.$http.post(
                    `teams/`,
                    {
                        'name': this.team.name,
                    })
                    .then(res => {
                        console.log(res);
                        this.$router.push({name: 'teams'});
                    }).catch(err => {
                        app.hasError = true;
                        app.message = err.response.data.message;
                        app.errors = err.response.data.errors || {};
                        console.log(err.response);
                    })
            }
        }
    }
</script>

