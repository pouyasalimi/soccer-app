<template>
    <div class="container">
        <div>
            <div class="row">
                <div class="col-md-5">
                    <model-select :options="players"
                                  v-model="playersSelect"
                                  placeholder="select a player">
                    </model-select>
                </div>
                <div class="col-md-5">
                    <model-select :options="teams"
                                  v-model="teamsSelect"
                                  placeholder="select a team">
                    </model-select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success" @click="addPlayerTeam()">Add Player Team</button>
                </div>

            </div>
            <div class="mb-2 mt-2">
                <p v-if="addPlayerTeamMessage.error" class="text-danger">{{addPlayerTeamMessage.error}}</p>
                <p v-if="addPlayerTeamMessage.success" class="text-success">{{addPlayerTeamMessage.success}}</p>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header">Player Teams List</div>
            <div class="card-body">
                <div class="alert alert-danger" v-if="hasError">
                    <p>Can't load data</p>
                </div>

                <table class="table">
                    <tr>
                        <th scope="col">Picture</th>
                        <th scope="col">Name</th>
                        <th scope="col">Team</th>
                        <th scope="col">Created</th>
                        <th scope="col">Manage</th>

                    </tr>
                    <tr v-for="(playerTeam,index) in playerTeams" v-bind:key="playerTeam.id" style="margin-bottom: 5px;">
                        <th scope="row"><img :src="playerTeam.player.picture" width="150" /></th>
                        <td>
                            <router-link :to="{name: 'playerShow' , params: { id: playerTeam.player.id}}">{{ playerTeam.player.user.name }}</router-link>
                        </td>
                        <td>
                            <router-link :to="{name: 'teamShow' , params: { id: playerTeam.team.id}}">{{ playerTeam.team.name }}</router-link>
                        </td>
                        <td>
                            {{ playerTeam.created_at}}
                        </td>
                        <td>
                            <a @click.prevent="deletePlayerTeams(playerTeam.id, index)" class="btn btn-outline-danger" href="#">Delete</a>
                        </td>

                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    import { ModelSelect } from 'vue-search-select';
    export default {
        components: {
            ModelSelect
        },
        data() {
            return {
                hasError: false,
                playerTeams: null,
                playerTeam: {
                    player: {
                        user: {
                            name:''
                        }
                    },
                    team: {
                        name:''
                    }
                },
                players: [],
                teams: [],
                playersSelect: '',
                teamsSelect: '',
                addPlayerTeamMessage: {
                    error: '',
                    success: ''
                }
            }
        },
        mounted() {
            this.getPlayerTeams();
            this.getPlayers();
            this.getTeams();
        },
        methods: {
            getPlayerTeams() {
                this.$http({
                    url: `player/teams`,
                    method: 'GET'
                })
                .then((res) => {
                    this.playerTeams = res.data.payload;
                    console.log(this.teams);
                }, () => {
                    this.hasError = true;

                })
            },
            getPlayers() {
                this.$http({
                    url: `players`,
                    method: 'GET'
                })
                .then((res) => {
                    this.players = res.data.payload.map(function(player) {
                        return {
                            value: player.id,
                            text: player.user.name
                        };
                    });
                }, () => {
                    this.hasError = true;

                })
            },
            getTeams() {
                this.$http({
                    url: `teams`,
                    method: 'GET'
                })
                .then((res) => {
                    //this.teams = res.data.payload;
                    this.teams = res.data.payload.map(function(team) {
                        return {
                            value: team.id,
                            text: team.name
                        };
                    });
                }, () => {
                    this.hasError = true;

                })
            },
            addPlayerTeam: function () {
                this.addPlayerTeamMessage.error = '';
                this.addPlayerTeamMessage.success = '';

                if (typeof this.playersSelect === 'string' || typeof this.teamsSelect === 'string') {
                    this.addPlayerTeamMessage.error = "Please select a player and a team!";
                    return false;
                }
                this.$http.post(`player/teams/`, {
                    player_id: parseInt(this.playersSelect),
                    team_id: parseInt(this.teamsSelect),
                })
                    .then(res => {
                        this.playerTeams.unshift(res.data.payload);
                        this.addPlayerTeamMessage.success = res.data.message;
                    }).catch(err => {
                        this.addPlayerTeamMessage.error = err.response.data.message;
                });
            },
            deletePlayerTeams(id, index) {
                if(confirm("Do you really want to delete?")){
                    let app = this;
                    this.$http.delete(`player/teams/` + id)
                        .then(res => {
                            this.playerTeams.splice(index, 1);
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

