<template>
    <ul class="navbar-nav">
        <li v-if="!$auth.check()" v-for="(route, key) in routes.unlogged" v-bind:key="route.path" class="nav-item">
            <router-link :to="{ name : route.path }" :key="key" class="nav-link">
                {{route.name}}
            </router-link>
        </li>

        <li v-if="$auth.check()" v-for="(route, key) in routes.user" v-bind:key="route.path" class="nav-item">
            <router-link :to="{ name : route.path }" :key="key" class="nav-link">
                {{route.name}}
            </router-link>
        </li>

        <li v-if="$auth.check()" class="nav-item">
            <a href="#" @click.prevent="$auth.logout()" class="nav-link">Logout</a>
        </li>
    </ul>
</template>
<script>
    export default {
        data() {
            return {
                routes: {
                    unlogged: [
                        {
                            name: 'Register',
                            path: 'register'
                        },
                        {
                            name: 'Login',
                            path: 'login'
                        }
                    ],
                    user: [
                        {
                            name: 'Dashboard',
                            path: 'dashboard'
                        },
                        {
                            name: 'Players',
                            path: 'players'
                        },
                        {
                            name: 'Teams',
                            path: 'teams'
                        },
                        {
                            name: 'Player Teams',
                            path: 'playerTeamsIndex'
                        }
                    ],
                }
            }
        },
        mounted() {
            //
        }
    }
</script>
