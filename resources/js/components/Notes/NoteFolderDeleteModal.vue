<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="dimmer" :class="{ 'active' : saving }">
                    <div class="loader"></div>
                    <p class="dimmer-message">
                        Please wait while the folder is being deleted...
                    </p>
                </div>

                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-trash"></i> Delete Folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-5 pb-5">
                    {{ folder.name }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" :disabled="saving" @click="deleteFolder(true)">Delete with notes</button>
                    <button type="button" class="btn btn-danger" :disabled="saving" @click="deleteFolder(false)">Delete without notes</button>
                    <button type="button" class="btn btn-secondary" :disabled="saving" @click="closeModal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { eventBus } from '../../app';

export default {
    name: "NoteFolderDeleteModal",
    data: () => ({
        folder: {},
        saving: false,
    }),
    created() {
        let self = this;
        eventBus.$on('noteFolderDeleteModalShow', self.showModal);
    },
    mounted() {
        $(this.$el).on('hidden.bs.modal', function (event) {
            eventBus.$emit('noteFolderDeleteModalClosed');
        })
    },
    methods: {
        deleteFolder(){
            var self = this;
            if(self.saving != true){
                self.saving = true;
                axios.delete('/api/notes_folders/' + this.folder.id)
                .then(response => {
                    if(response.data.status == 'deleted'){
                        eventBus.$emit('noteFolderDeleted', { folder_id : this.folder.id });
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
            this.folder = event;
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
