<template>
    <div id="notes-menu">

        <div class="pull-right" style="width:40%;">
            <input type="text" class="form-control" placeholder="Search" v-model="$route.query.search" @keyup="search()">
        </div>

        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group mr-2" role="group">
                <button type="button" class="btn btn-secondary" @click="switchFolderMenu">
                    <i class="fa" :class="[folder_menu_open ? 'fa-folder' : 'fa-folder-open']"></i>
                </button>
            </div>
            <div class="btn-group mr-2" role="group">
                <button type="button" class="btn btn-primary" @click="createNote">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="btn-group" role="group" v-if="$route.params.note_id">
                <button type="button" class="btn btn-danger" @click="deleteNote">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>


    </div>
</template>
<script>
import { eventBus } from '../../app';

export default {
    name: "NotesMenu",
    data: () => ({
        folder_menu_open: true,
        saving: false,
        searchQry: ''
    }),
    watch: {
        auxSearch(newValue) {
            this.searchQry = newValue;
        }
    },
    computed: {
        auxSearch() {
            return this.$route.query.search;
        }
    },
    methods: {
        switchFolderMenu() {
            if(this.folder_menu_open){
                $("#notes-folders").animate({width:'toggle'},100);
            }else{
                $("#notes-folders").animate({width:'toggle'},100);
            }

            this.folder_menu_open = !this.folder_menu_open
        },
        createNote(){
            var vm = this;
            if(vm.saving != true){
                vm.saving = true;

                var formData = new FormData();

                formData.append('_token', $('meta[name=csrf-token]').attr('content'));

                axios.post('/api/notes', formData)
                .then(response => {

                    console.log(response.status);

                    if(response.status == 200){
                        vm.saving = false;
                        vm.errors = {};
                        vm.$router.push({ name: 'note', params: { note_id: response.data.note.id }})
                    }

                })
                .catch(e => {
                    vm.saving = false;
                })
            }
        },
        deleteNote(){
            eventBus.$emit('noteDeleteModalShow');
        },
        search: _.debounce(function (e) {
            // this.$router.push({ name: 'note', params: this.$route.params, query: { search: this.$route.query.search } })
        }, 400),
    }
}
</script>
<style lang="scss" scoped>
#notes-menu{
    width: 100%;
    background: #d0d0d0;
    padding: 10px;
    border: 1px solid #e2e6e9;
}
</style>
