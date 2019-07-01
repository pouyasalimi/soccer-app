<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">

                <div class="row">
                    <div class="col-6" v-if="team.name">{{team.name}}</div>
                    <div class="col-6 text-right"><router-link :to="{name: 'teams' , params: { }}" class="btn btn-dark btn-sm">Teams List</router-link></div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-danger" v-if="hasError">
                    <p>Can't update data</p>
                </div>
                <form autocomplete="off" @submit.prevent="update" v-if="!success" method="post">

                    <div class="form-group" v-bind:class="{ 'has-error': hasError && errors.name }">
                        <label for="name">Team Name:</label>
                        <input type="text" id="name" class="form-control" placeholder="Enter team name"
                               v-model="team.name">
                        <span class="help-block text-danger" v-if="hasError && errors.name">{{ errors.name[0] }}</span>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
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
                    name: '',
                },
                success: false,
                errors: {},
            }
        },
        mounted() {
            this.getTeam();
        },
        methods: {
            getTeam() {
                this.$http({
                    url: `teams/` + this.$route.params.id,
                    method: 'GET'
                })
                    .then((res) => {
                        this.team = res.data.payload;
                    }, () => {
                        this.hasError = true;

                    })
            },

            update() {
                let app = this;
                this.$http.put(
                    `teams/` + this.$route.params.id,
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

