<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">Players List</div>
                    <div class="col-6 text-right"><router-link :to="{name: 'playerCreate' , params: { }}" class="btn btn-success btn-sm">New Player</router-link></div>
                </div>

            </div>
            <div class="card-body">
                <div class="alert alert-danger" v-if="hasError">
                    <p>Can't load data</p>
                </div>

                <table class="table">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Picture</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Manage</th>

                    </tr>
                    <tr v-for="(player, index) in players" v-bind:key="player.id" style="margin-bottom: 5px;">
                        <th scope="row">{{ player.id }}</th>
                        <td><img :src="player.picture" width="150" /></td>
                        <td>
                            <router-link :to="{name: 'playerShow' , params: { id: player.id}}">{{ player.user.name }}</router-link>
                        </td>
                        <td>{{ player.user.email }}</td>
                        <td>
                            <router-link :to="{name: 'playerEdit' , params: { id: player.id}}" class="btn btn-outline-primary">Edit player</router-link>
                            <a @click.prevent="deletePlayer(player.id, index)" class="btn btn-outline-danger" href="#">Delete</a>
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
                players: null,
            }
        },
        mounted() {
            this.getPlayers();
        },
        methods: {
            getPlayers() {
                this.$http({
                    url: `players`,
                    method: 'GET'
                })
                    .then((res) => {
                        this.players = res.data.payload;
                    }, () => {
                        this.hasError = true;

                    })
            },
            deletePlayer(id, index) {
                if(confirm("Do you really want to delete?")){
                    let app = this;
                    this.$http.delete(`players/` + id)
                        .then(res => {
                            console.log(res);
                            this.players.splice(index, 1);
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

