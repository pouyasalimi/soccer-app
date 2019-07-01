<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">
                <div class="row">
                    <div class="col-6" v-if="team.name">{{team.name}}</div>
                    <div class="col-6 text-right"><router-link :to="{name: 'players' , params: { }}" class="btn btn-dark btn-sm">Players List</router-link></div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-danger" v-if="hasError">
                    <p>Can't load data</p>
                </div>
                <div class="col">
                    Created at: {{team.created_at}}
                </div>
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
                    name:'',
                },
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
        }
    }
</script>

