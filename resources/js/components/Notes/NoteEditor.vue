<template>
    <div id="note-container" class="p-0 border">

        <div id="notes-sub-menu" v-if="note.id">

            <div class="btn-toolbar pull-right" role="toolbar">

                <div class="btn-group mr-2" role="group">
                    <button type="button" @click="realNoteUpdate" class="btn btn-sm btn-outline-secondary"><i class="fa fa-save"></i></button>
                </div>
                <div class="btn-group" role="group" v-if="$route.params.note_id">
                    <button type="button" class="btn btn-sm" @click="autosave = !autosave" :class="[autosave ? 'btn-success' : 'btn-outline-secondary']">
                        <i class="fa fa-clock-o"></i> Autosave
                    </button>
                </div>
            </div>


            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group mr-2" role="group">
                    <div class="dropdown">
                        <button class="btn btn-dark btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-circle" :style="{ color: selected_color}"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding: 0px;">
                            <template v-for="color in ['#FFFFFF', '#F5A9A9', '#F5D0A9', '#F2F5A9', '#A9F5A9', '#A9F5F2', '#A9D0F5', '#F5A9F2']">
                                <a class="dropdown-item" :style="{ background: color }" @click.prevent="selected_color = color">&nbsp;</a>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="btn-group mr-2" role="group">
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ selected_folder.name }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" @click.prevent="selected_folder = { name: 'No Folder' }">No Folder</a>
                            <template v-for="folder in folders">
                                <a class="dropdown-item" @click.prevent="selected_folder = folder">{{ folder.name }}</a>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <small class="p-1 note-meta" v-if="note.id">
            <span v-if="updating" class="pull-left">Updating...</span>
            Created at: {{ note.created_at.date | date_to_human_short }} {{ note.created_at.date | hour_to_human }}<br />
            Updated at: {{ note.updated_at.date | date_to_human_short }} {{ note.updated_at.date | hour_to_human }}
        </small>
        <div class="p-4" style="max-height:400px; overflow-x:scroll;">
            <!-- <span
            v-if="!edit"
            @click="edit = !edit"
            class="text-muted" style="font-size: 0.9em; display: block;"
            v-html="noteOrPlaceholder"
            ></span> -->

            <span
            id="editable-container"
            contenteditable="true"
            class="text-muted"
            style="font-size: 0.9em; display: block; min-height:300px;"
            @keyup="updateNote"
            ><span v-html="note.content"></span></span>

        </div>

    </div>
</template>
<script>
import { eventBus } from '../../app'

export default {
    name: "",
    data: () => ({
        edit: false,
        internal_note: '',
        selected_color: '#ffffff',
        selected_folder: {
            id: '',
            name: "No Folder"
        },
        updating: false,
        autosave: false,
    }),
    props: {
        'note': {
            type: Object,
            required: true
        },
        'folders': {
            type: Array,
            required: true,
            default: function() {
                return []
            }
        }
    },
    watch: {
        note() {
            //do something when note value changes
            this.internal_note = this.note.content;
            this.selected_color = this.note.color;
            if(this.note.folder){
                this.selected_folder = this.note.folder;
            }
        },
        selected_color(){
            if(this.note.color != this.selected_color){
                this.realNoteUpdate();
            }
        },
        selected_folder(){
            if(this.note.note_folder_id != this.selected_folder.id){
                this.realNoteUpdate();
            }
        },
    },
    computed: {
        noteOrPlaceholder() {
            var aux = "You can create a new note by clicking on the blue button with the plus icon at the top menu.";
            return (this.note.content != "" && this.note.content != null ? this.note.content : (this.$route.params.note_id ? 'Empty Note' : aux))
        }
    },
    methods: {
        updateNote(event){
            this.internal_note = event.target.innerHTML;
            if(this.autosave){
                this.updateThrottled();
            }
        },
        updateThrottled: _.throttle(function (e){
            this.realNoteUpdate();
        }, 4000),
        realNoteUpdate() {

            var vm = this;
            if(vm.updating != true){
                vm.updating = true;

                var formData = new FormData();

                formData.append('_token', $('meta[name=csrf-token]').attr('content'));
                formData.append('content', this.internal_note);
                formData.append('color', this.selected_color);
                formData.append('note_folder_id', ( this.selected_folder.id != null ? this.selected_folder.id : '' ));

                axios.post('/api/notes/' + this.note.id, formData)
                .then(response => {

                    if(response.status == 200){
                        vm.updating = false;
                        vm.errors = {};
                        this.note.created_at.date = response.data.note.created_at.date;
                        this.note.updated_at.date = response.data.note.updated_at.date;
                        this.note.color = response.data.note.color;
                        this.note.note_folder_id = response.data.note.note_folder_id;
                        eventBus.$emit('noteUpdated', response.data.note);
                    }

                })
                .catch(e => {
                    if(e.status == 400){
                        vm.errors = e.response.data.errors;
                    }
                    vm.updating = false;
                })
            }

        },
    }
}
</script>
<style lang="scss" scoped>

#note-container{
    width: 65%;
    overflow: hidden;
}

#notes-sub-menu{
    width: 100%;
    background: #e2e6e9;
    padding: 10px;
    border: 1px solid #e2e6e9;
    text-align: center;
}

[contenteditable="true"]:active,
[contenteditable="true"]:focus{
    border:none;
    outline:none;
}

.note-meta{
    color: #949494;
    display: block;
    width: 100%;
    text-align: right;
}

</style>
