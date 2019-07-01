<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">Create Player</div>
                    <div class="col-6 text-right"><router-link :to="{name: 'players' , params: { }}" class="btn btn-dark btn-sm">Players List</router-link></div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-danger" v-if="hasError">
                    <p>Can't create data</p>
                </div>
                <form autocomplete="off" @submit.prevent="create" v-if="!success" method="post">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group" v-bind:class="{ 'has-error': hasError && errors.name }">
                                <label for="name">Name:</label>
                                <input type="text" id="name" class="form-control" placeholder="Your name"
                                       v-model="player.user.name">
                                <span class="help-block text-danger" v-if="hasError && errors.name">{{ errors.name[0] }}</span>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': hasError && errors.email }">
                                <label for="email">E-mail:</label>
                                <input type="email" id="email" class="form-control" placeholder="user@example.com"
                                       v-model="player.user.email">
                                <span class="help-block text-danger"
                                      v-if="hasError && errors.email">{{ errors.email[0] }}</span>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': hasError && errors.password }">
                                <label for="password">Password:</label>
                                <input type="password" id="password" class="form-control" v-model="player.user.password">
                                <span class="help-block text-danger"
                                      v-if="hasError && errors.password">{{ errors.password[0] }}</span>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': hasError && errors.password }">
                                <label for="password_confirmation">Password confirmation:</label>
                                <input type="password" id="password_confirmation" class="form-control"
                                       v-model="player.user.password_confirmation">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="picture" @click="openInputFile">
                                <img :src="player.pictureUrl" class="img">
                                <input type="file" ref="inputFile" @change="imageInputChanged">
                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>

            </div>
        </div>
        <b-modal ref="modalRef" hide-footer hide-header v-model="modal.show">
            <div>
                <ProfilePicture :props="modal" :data="player" v-if="modal.show"></ProfilePicture>
            </div>
        </b-modal>
    </div>
</template>
<script>
    import ProfilePicture from "../../components/profile-picture";

    export default {
        components: {ProfilePicture},
        data() {
            return {
                hasError: false,
                player: {
                    user: {
                        name: '',
                        email: '',
                        password: '',
                        password_confirmation: ''
                    },
                    picture: '',
                    pictureUrl: ''
                },
                success: false,
                errors: {},
                modal: {
                    show: false
                },
                modalRef: '',
                inputFile: ''
            }
        },
        mounted() {

        },
        methods: {
            openInputFile() {
                this.$refs.inputFile.click();
            },
            imageInputChanged(event) {
                const file = event.target.files[0];

                if (!file.type.includes("image/")) {
                    alert("Please select an image file");
                    this.$refs.inputFile.value = "";
                    return;
                }
                this.modal.imageFile = file;
                this.$refs.inputFile.value = "";
                this.modal.show = true;
            },
            create() {
                let app = this;
                this.$http.post(
                    `players/`,
                    {
                        'name': this.player.user.name,
                        'email': this.player.user.email,
                        'password': this.player.user.password,
                        'password_confirmation': this.player.user.password_confirmation,
                        'picture': this.player.picture
                    })
                    .then(res => {
                        console.log(res);
                        this.$router.push({name: 'players'});
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

