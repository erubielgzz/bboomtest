<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="dimmer" :class="{ 'active' : saving }">
                    <div class="loader"></div>
                    <p class="dimmer-message">
                        Please wait while the image is being deleted...
                    </p>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-trash"></i> Delete Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-5 pb-5">
                    <img :src="image.path" alt="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" :disabled="saving" @click="deleteImage">Delete</button>
                    <button type="button" class="btn btn-secondary" :disabled="saving" @click="closeModal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { eventBus } from '../../app';

export default {
    name: "ImageDeleteModal",
    data: () => ({
        image: {},
        saving: false,
    }),
    created() {
        let self = this;
        eventBus.$on('imageDeleteModalShow', self.showModal);
    },
    mounted() {
        $(this.$el).on('hidden.bs.modal', function (event) {
            eventBus.$emit('ImageDeleteModalClosed');
        })
    },
    methods: {
        deleteImage(){
            var self = this;
            if(self.saving != true){
                self.saving = true;
                axios.delete('/api/images/' + this.image.id)
                .then(response => {
                    if(response.data.status == 'deleted'){
                        eventBus.$emit('imageDeleted', { image_id : this.image.id });
                        $(this.$el).modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }
                    self.saving = false;
                })
                .catch(e => {
                    self.saving = false;
                })
            }
        },
        showModal(event) {
            this.image = event;
            $(this.$el).modal('show');
        },
        closeModal() {
            $(this.$el).modal('hide');
        },
    }
}
</script>
<style lang="scss" scoped>

.modal-header{
    background: #e14436;
    color: #fff;
    border-bottom: 0px;
}

.modal-body{
    text-align: center;
}

.modal-body > img {
    max-width: 100%;
    max-height: 350px;
}

.close,
.close:not(:disabled):not(.disabled):hover,
.close:not(:disabled):not(.disabled):focus{
    color: #fff;
}

.loader{
    border-top: 12px solid #e14436;
}

</style>
