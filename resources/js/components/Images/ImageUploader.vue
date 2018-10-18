<template>
    <div>
        <div v-if="error != ''" class="alert alert-danger" role="alert" v-html="error"></div>

        <button type="button" @click="uploadImage" class="btn btn-primary btn-sm btn-block" v-if="image" style="margin-bottom:15px;">
            <i class="fa fa-upload"></i> Upload Image
        </button>

        <div class="image-uploader-container"
            @click="triggerFileClick"
            @dragover.prevent="dragover=true"
            @dragenter="dragover=true"
            @dragleave="dragover=false"
            @dragexit="dragover=false"
            @drop="dropImage"
            :class="{ 'with-image' : image, 'dragover' : dragover}">

            <div class="image-uploader">
                <div class="dimmer" :class="{ 'active' : uploading }">
                    <div class="loader"></div>
                    <p class="dimmer-message">
                        Please wait while the image is being uploaded...
                    </p>
                </div>

                <h3 v-if="!image" style="font-size: 16px; color: #212121;">
                    Drag and Drop <br /> or Click <br />  to Upload Image
                </h3>
                <div v-show="image" style="position:relative;">
                    <div style="display: inline-block;">
                        <img @click="triggerFileClick" :src="image" />
                    </div>
                </div>
            </div>
        </div>
        <input class="fileInput" type="file" @change="onFileChange" style="display: none;" accept="image/*">
    </div>
</template>
<script>
export default {
    name: "ImageUploader",
    data: () => ({
        image: '',
        image_to_upload: '',
        error: '',
        errors: {},
        dragover: false,
        uploading: false
    }),
    methods: {
        uploadImage(){
            var vm = this;
            if(vm.uploading != true){
                vm.uploading = true;

                var formData = new FormData();

                formData.append('_token', $('meta[name=csrf-token]').attr('content'));
                if(typeof this.image_to_upload !== "undefined"){
                    formData.append('image', this.image_to_upload);
                }

                axios.post('/api/images', formData)
                .then(response => {

                    if(response.status == 200){
                        vm.uploading = false;
                        vm.errors = {};
                        vm.$router.push({ name: 'image', params: { image_id: response.data.image.id }})
                    }

                })
                .catch(e => {
                    vm.uploading = false;
                })
            }

        },
        dropImage(e) {
            let vm = this;
            e.stopPropagation();
            e.preventDefault();

            vm.dragover = false;

            var imageTypes = ['image/png', 'image/gif', 'image/bmp', 'image/jpg', 'image/jpeg'];
            if (e.dataTransfer && e.dataTransfer.files) {

                var fileType = e.dataTransfer.files[0].type;
                if (!imageTypes.includes(fileType)) {
                    vm.error = 'The dropped file type: <strong><em>' + fileType + '</em></strong> is not a valid image.';
                    return;
                }else{
                    vm.error = '';
                }
            }

            var files = e.dataTransfer.files;
            this.createImage(files[0]);
            this.image_to_upload = files[0];
        },
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length){
                return;
            }
            this.createImage(files[0]);
            this.image_to_upload = files[0];
        },
        createImage(file) {
            var image = new Image();
            var reader = new FileReader();
            var vm = this;

            if ( file.size > 1048576 * 4) {
                vm.error = 'The file is too big, please provide a file not bigger than 4MB.';
                return;
            }else{
                vm.error = '';
            }

            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        triggerFileClick: _.debounce(function (e) {
            $(this.$el).find('.fileInput').trigger('click');
        }, 200),
    }
}
</script>
<style lang="scss" scoped>
.fileInput{
    display: none;
}

.image-uploader-container{
    width: 100%;
    border: 3px dotted #444;
    height: 400px;
    background-size: 4% 4%;
    background-image:repeating-linear-gradient(0deg, #eee, #eee 1px, transparent 1px, transparent 40px),repeating-linear-gradient(-90deg, #eee, #eee 1px, transparent 1px, transparent 40px);
    display: table;
    margin-bottom: 20px;
}

.image-uploader{
    position: relative;
    display: table-cell !important;
    vertical-align: middle !important;
    text-align: center !important;
    height: 400px;
}

.image-uploader-container.dragover{
    border: 3px dotted #f5c175 !important;
}

.image-uploader-container.with-image{
    border: 3px solid #888;
}

img{
    max-width: 100%;
    max-height: 400px;
}

.loader{
    border-top: 12px solid #3490dc;
}

</style>
