<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">
                <div class="row">
                    <div class="col-6" v-if="player.user.name">{{player.user.name}}</div>
                    <div class="col-6 text-right"><router-link :to="{name: 'players' , params: { }}" class="btn btn-dark btn-sm">Players List</router-link></div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-danger" v-if="hasError">
                    <p>Can't load data</p>
                </div>
                Other Player Data!
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                hasError: false,
                player: {
                    user: {
                        name:'',
                    }
                },
            }
        },
        mounted() {
            this.getPlayer();
        },
        methods: {
            getPlayer() {
                this.$http({
                    url: `players/` + this.$route.params.id,
                    method: 'GET'
                })
                .then((res) => {
                    this.player = res.data.payload;
                }, () => {
                    this.hasError = true;

                })
            },
        }
    }
</script>

