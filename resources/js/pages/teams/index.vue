<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">Teams List</div>
                    <div class="col-6 text-right"><router-link :to="{name: 'teamCreate' , params: { }}" class="btn btn-success btn-sm">New Team</router-link></div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-danger" v-if="hasError">
                    <p>Can't load data</p>
                </div>
                <table class="table">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Manage</th>

                    </tr>
                    <tr v-for="(team,index) in teams" v-bind:key="team.id" style="margin-bottom: 5px;" :class="'team-'+index">
                        <th scope="row">{{ team.id }}</th>
                        <td>
                            <router-link :to="{name: 'teamShow' , params: { id: team.id}}">{{ team.name }}</router-link>
                        </td>
                        <td>
                            <router-link :to="{name: 'teamEdit' , params: { id: team.id}}" class="btn btn-outline-primary">Edit</router-link>
                            <a @click.prevent="deleteTeam(team.id, index)" class="btn btn-outline-danger" href="#">Delete</a>
                        </td>

                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                hasError: false,
                teams: null,
            }
        },
        mounted() {
            this.getTeams();
        },
        methods: {
            getTeams() {
                this.$http({
                    url: `teams`,
                    method: 'GET'
                })
                    .then((res) => {
                        this.teams = res.data.payload;
                        console.log(this.teams);
                    }, () => {
                        this.hasError = true;

                    })
            },
            deleteTeam(id, index) {
                if(confirm("Do you really want to delete?")){
                    let app = this;
                    this.$http.delete(`teams/` + id)
                        .then(res => {
                            console.log(res);
                            this.teams.splice(index, 1);
                        }).catch(err => {
                            app.hasError = true;
                            app.message = err.response.data.message;
                            app.errors = err.response.data.errors || {};
                            console.log(err.response);
                        });
                }
            }

        }
    }
</script>

