<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-custom">
            <div class="container">
                <router-link class="navbar-brand" :to="{name: 'home'}">
                    Soccer App
                </router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <navigationMenu></navigationMenu>
                </div>
            </div>


        </nav>
        <main class="py-4 full-height">
            <router-view></router-view>
        </main>

        <footer class="footer">
            <div class="container">
                <p>&copy; Soccer Company</p>
            </div>

        </footer>
    </div>
</template>
<script>
    import navigationMenu from './components/Menu.vue'
    export default {
        name: 'App',
        data() {
            return {
            };
        },
        methods: {

        },
        components: {
            navigationMenu
        }
    }
</script>
