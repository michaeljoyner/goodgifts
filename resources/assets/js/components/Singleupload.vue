<style>

</style>

<template>
    <div>
        <label for="profile-upload" class="single-upload-label">
            <img :src="imageSrc" alt="" class="profile-image"
                 v-bind:style="{width: prevWidth, height: prevHeight}"
                 v-bind:class="{'processing' : uploading, 'large': size === 'large', 'round': shape === 'round', 'full': size === 'full' }"/>
            <input v-on:change="processFile" type="file" id="profile-upload"/>
        </label>
        <div class="upload-progress-container" v-show="uploading">
        <span class="upload-progress-bar"
              v-bind:style="{width: uploadPercentage + '%'}"></span>
        </div>
        <p class="upload-message"
           v-bind:class="{'error': uploadStatus === 'error', 'success': uploadStatus === 'success'}"
           v-show="uploadMsg !== ''">{{ uploadMsg }}
        </p>
    </div>

</template>

<script type="text/babel">
    import { generatePreview } from './PreviewGenerator.js';
    export default {
        props: {
            default: null,
            url: String,
            shape: { type: String, default: 'square'},
            size: { type: String, default: 'large'},
            previewWidth: {type: Number, default: 300},
            previewHeight: {type: Number, default: 300}
        },
        data() {
            return {
                imageSource: '',
                uploadMsg: '',
                uploading: false,
                uploadStatus: '',
                uploadPercentage: 0
            }
        },
        computed: {
            imageSrc() {
                return this.imageSource ? this.imageSource : this.default;
            },
            prevWidth() {
                if(this.size === 'preview') {
                    return this.previewWidth + 'px';
                }
                if(this.size === 'large') {
                    return '300px';
                }
                return '200px';
            },
            prevHeight() {
                if(this.size === 'preview') {
                    return 'auto';
                }
                if(this.size === 'large') {
                    return '300px';
                }
                return '200px';
            }
        },
        methods: {
            processFile(ev) {
                var file = ev.target.files[0];
                this.clearMessage();
                if (file.type.indexOf('image') === -1) {
                    this.showInvalidFile(file.name);
                    return;
                }
                this.handleFile(file);
            },
            showInvalidFile(name) {
                this.uploadMsg = name + ' is not a valid image file';
                this.uploadStatus = 'error';
            },
            handleFile(file) {
                generatePreview(file, {pWidth: this.previewWidth, pHeight: this.previewHeight})
                        .then((src) => this.imageSource = src)
                        .catch((err) =>console.log(err));
                this.uploadFile(file);
            },
            uploadFile(file) {
                this.uploading = true;
                this.$http.post(this.url, this.prepareFormData(file), this.getUploadOptions())
                        .then(res => this.onUploadSuccess(res))
                        .catch(err => this.onUploadFailed(err));
            },
            prepareFormData: function (file) {
                let fd = new FormData();
                fd.append('image', file);
                return fd;
            },
            onUploadSuccess(res) {
                this.uploadMsg = "Uploaded successfully";
                this.uploadStatus = 'success'
                this.uploading = false;
                eventHub.$emit('singleuploadcomplete', res.data);
            },
            onUploadFailed(err) {
                this.uploadMsg = 'The upload failed';
                this.uploadStatus = 'error';
                console.log(err);
            },
            getUploadOptions() {
                return {
                    progress: (ev) => this.showProgress(parseInt(ev.loaded / ev.total * 100))
                }
            },
            showProgress(progress) {
                this.uploadPercentage = progress;
            },
            clearMessage() {
                this.uploadMsg = ''
            }
        }
    }
</script>