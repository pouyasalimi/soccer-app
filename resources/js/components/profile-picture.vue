<template>
    <div>
        <div class="cropper-context">
            <div style="width:200px;height:200px;">
                <vue-cropper
                    ref="cropper"
                    :guides="false"
                    :view-mode="2"
                    drag-mode="crop"
                    :autoCrop="true"
                    :zoomable="false"
                    :zoomOnWheel="false"
                    :initialAspectRatio="1/1"
                    :aspectRatio="1/1"
                    :minCropBoxWidth="50"
                    :minCropBoxHeight="50"
                    :cropBoxMovable="true"
                    :movable="false"
                    :cropBoxResizable="true"
                    :auto-crop-area="0.5"
                    :min-container-width="250"
                    :min-container-height="180"
                    :background="true"
                    :src="imgSrc"
                    alt="Source Image"
                    :img-style="{ 'width': '500px', 'height': '100px' }"
                ></vue-cropper>
            </div>
        </div>
        <div class="row direction-ltr">
            <div class="col">
                <button class="btn btn-primary btn-block" :disabled="working" @click="cropImage">Save</button>
            </div>
            <div class="col">
                <button class="btn btn-danger btn-block" :disabled="working" @click="close">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script>
    import VueCropper from "vue-cropperjs";
    import 'cropperjs/dist/cropper.css';
    export default {
        name: "ProfilePicture",
        props: {
            props: {
                type: Object,
                required: true
            },
            data:{
                type: Object,
                required: true
            }
        },
        data() {
            return {
                imgSrc: "",
                cropImg: "",
                working: false,
            };
        },
        mounted() {
            console.log(this.props);
            console.log(this.data);

            if (typeof FileReader === "function") {
                const reader = new FileReader();
                reader.onload = event => {
                    this.imgSrc = event.target.result;
                    // rebuild cropperjs with the updated source
                    this.$refs.cropper.replace(event.target.result);
                };
                reader.readAsDataURL(this.props.imageFile);
            } else {
                alert("Sorry, FileReader API not supported");
            }
        },
        computed:{
        },
        methods: {
            close() {
                this.props.show = false;
            },
            cropImage() {
                let self = this;
                // get image data for post processing, e.g. upload or setting image src
                this.cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL();
                this.working = true;
                this.$http.post(
                    `players/picture`,
                    {
                        'picture': this.cropImg,
                    }).then(res => {
                        console.log(res.data.isSuccessful);
                        if(res.data.isSuccessful){
                            this.data.picture = res.data.payload.picture;
                            this.data.pictureUrl = res.data.payload.pictureUrl;
                            this.props.show = false;
                        }
                    }).catch(err => {
                        this.working = false;
                        self.pictureHasError = true;
                    });
            },
            zoomIn() {
                this.$refs.cropper.zoomTo(0.6);
            },
            zoomOut() {}
        },
        components: {
            VueCropper
        }
    };
</script>

<style>
    .cropper-context {
        width: 100%;
        height: 12rem;
    }

    .cropper-context > div {
        width: 100% !important;
        height: 100% !important;
    }
</style>
