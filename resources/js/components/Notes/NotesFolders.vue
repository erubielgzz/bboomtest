<template>
    <div id="notes-folders" class="p-0 border">
        <div class="p-2">
            <h4>Folders</h4>
        </div>
        <div style="height:300px; overflow-x: scroll;">
            <ul class="nav flex-column navbar-dark">
                <li class="nav-item">
                    <router-link v-if="$route.query.search" class="nav-link" :to="{ name: $route.name, params: $route.params, query: { search: $route.query.search } }">
                        All
                    </router-link>
                    <router-link v-else class="nav-link" :to="{ name: $route.name, params: $route.params }">
                        All
                    </router-link>
                </li>
                <li class="nav-item" style="margin-bottom: 20px;">
                    <router-link v-if="$route.query.search" class="nav-link" :to="{ name: $route.name, params: $route.params, query: { folder: 'no-folder', search: $route.query.search } }">
                        Notes without folder
                    </router-link>
                    <router-link v-else class="nav-link" :to="{ name: $route.name, params: $route.params, query: { folder: 'no-folder' } }">
                        Notes without folder
                    </router-link>
                </li>
                <li v-for="folder in folders" class="nav-item">
                    <router-link v-if="$route.query.search" class="nav-link" :to="{ name: $route.name, params: $route.params, query: { folder: folder.id, search: $route.query.search } }">
                        {{ folder.name }}
                    </router-link>
                    <router-link v-else class="nav-link" :to="{ name: $route.name, params: $route.params, query: { folder: folder.id } }">
                        {{ folder.name }}
                    </router-link>
                </li>
            </ul>
        </div>
        <div class="mt-auto p-2">

            <button v-if="!creating_folder && !editing_folders" type="button" class="btn btn-sm btn-outline-secondary mb-2" @click="creating_folder = true">
                <i class="fa fa-plus"></i> Folder
            </button>
            <button v-if="!creating_folder && !editing_folders" type="button" class="btn btn-sm btn-outline-secondary mb-2" @click="editing_folders = true">
                <i class="fa fa-edit"></i> Edit
            </button>

            <input v-if="creating_folder"
            @keyup.enter="saveFolder"
            type="text"
            class="form-control"
            placeholder="New folder's name"
            v-model="new_folder_name"
            style="margin-bottom:10px;"
            />

            <div v-if="errors.name" class="alert alert-danger">
                {{ errors.name[0] }}
            </div>


            <div style="width:100%; text-align:right;">
                <button v-if="creating_folder" type="button" class="btn btn-sm btn-outline-primary mb-2" @click="saveFolder">
                    <i class="fa fa-save"></i> Save
                </button>
                <button v-if="creating_folder" type="button" class="btn btn-sm btn-outline-secondary mb-2" @click="creating_folder = false; new_folder_name = ''">
                    <i class="fa fa-times"></i> Cancel
                </button>
            </div>

            <select v-show="editing_folders" class="custom-select" v-model="selected_folder" style="margin-bottom:10px;">
                <option :value="{}" selected disabled>Choose folder</option>
                <template v-for="folder in folders" >
                    <option :value="folder">{{ folder.name }}</option>
                </template>
            </select>
            <input v-if="editing_folders && selected_folder.id"
            @keyup.enter="updateFolder"
            type="text"
            class="form-control"
            placeholder="Folder's name"
            v-model="edited_folder_name"
            style="margin-bottom:10px;"
            />

            <div style="width:100%; text-align:right;">
                <button v-if="editing_folders && selected_folder.id" type="button" class="btn btn-sm btn-outline-danger pull-left mb-2" @click="deleteFolder">
                    <i class="fa fa-trash"></i>
                </button>
                <button v-if="editing_folders && selected_folder.id" type="button" class="btn btn-sm btn-outline-primary mb-2" @click="updateFolder">
                    <i class="fa fa-save"></i>
                </button>
                <button v-if="editing_folders" type="button" class="btn btn-sm btn-outline-secondary mb-2" @click="editing_folders = false;">
                    <i class="fa fa-times"></i> Cancel
                </button>
            </div>

        </div>
    </div>
</template>
<script>
import { eventBus } from '../../app';

export default {
    name: "",
    props: {
        'folders': {
            type: Array,
            required: true,
            default: function() {
                return []
            }
        }
    },
    data: () => ({
        new_folder_name: '',
        creating_folder: false,
        selected_folder: {},
        edited_folder_name: '',
        editing_folders: false,
        errors:{},
        saving: false,
        updating: false,
    }),
    watch: {
        selected_folder(newValue) {
            this.edited_folder_name = newValue.name;
        }
    },
    methods: {
        saveFolder(){
            var vm = this;
            if(vm.saving != true){
                vm.saving = true;

                var formData = new FormData();

                formData.append('_token', $('meta[name=csrf-token]').attr('content'));
                formData.append('name', this.new_folder_name);

                axios.post('/api/notes_folders', formData)
                .then(response => {

                    if(response.status == 200){
                        vm.saving = false;
                        vm.errors = {};
                        vm.new_folder_name = "";
                        vm.creating_folder = false;
                        this.folders.push(response.data.folder)
                    }

                })
                .catch(e => {
                    vm.errors = e.response.data.errors;
                    vm.saving = false;
                })
            }

        },
        updateFolder(){
            var vm = this;
            if(vm.updating != true){
                vm.updating = true;

                var formData = new FormData();

                formData.append('_token', $('meta[name=csrf-token]').attr('content'));
                formData.append('name', this.edited_folder_name);

                axios.post('/api/notes_folders/' + this.selected_folder.id, formData)
                .then(response => {

                    if(response.status == 200){
                        vm.updating = false;
                        vm.errors = {};
                        vm.new_folder_name = "";
                        vm.editing_folders = false;
                        this.selected_folder.name = response.data.folder.name
                    }

                })
                .catch(e => {
                    vm.errors = e.response.data.errors;
                    vm.updating = false;
                })
            }
        },
        deleteFolder(){
            eventBus.$emit('noteFolderDeleteModalShow', this.selected_folder);
        }
    }
}
</script>
<style lang="scss" scoped>
#notes-folders{
    display: flex;
    flex-direction: column;
    width: 30%;
    background-color: #e2e6e9;
    font-weight: bold;
}

.nav-item .nav-link{
    color: #8d8f90;
    font-weight: bold;
}

.nav-item .nav-link.router-link-exact-active{
    background: #499be1;
    color: #ffffff;
    font-weight: bold;
}
</style>
