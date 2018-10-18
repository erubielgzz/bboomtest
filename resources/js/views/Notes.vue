<template>
    <div class="row">
        <div class="col-sm-12">
            <h2>Note Taking App</h2>
        </div>
        <div class="col-sm-12">
            <notes-menu></notes-menu>
            <div class="notes-main-container">
                <div class="d-flex bg-light border" style="height:500px">
                    <notes-folders :folders="notes_folders"></notes-folders>
                    <notes-list :notes="notes"></notes-list>
                    <note-editor :note="note" :folders="notes_folders"></note-editor>
                </div>
            </div>

        </div>

        <note-delete-modal :note="note"></note-delete-modal>
        <note-folder-delete-modal></note-folder-delete-modal>

    </div>
</template>
<script>
import { eventBus } from '../app'

import NotesMenu from '../components/Notes/NotesMenu'
import NotesFolders from '../components/Notes/NotesFolders'
import NotesList from '../components/Notes/NotesList'
import NoteEditor from '../components/Notes/NoteEditor'
import NoteDeleteModal from '../components/Notes/NoteDeleteModal'
import NoteFolderDeleteModal from '../components/Notes/NoteFolderDeleteModal'

const getNotesFolders = (callback) => {

    axios
    .get('/api/notes_folders')
    .then(response => {
        callback(null, response.data);
    }).catch(error => {
        callback(error, error.response.data);
    });
};

const getNotes = (folder, search, callback) => {
    const params = { folder, search };

    axios
    .get('/api/notes', { params })
    .then(response => {
        callback(null, response.data);
    }).catch(error => {
        callback(error, error.response.data);
    });
};

const getNote = (note_id, callback) => {

    axios
    .get('/api/notes/' + note_id)
    .then(response => {
        callback(null, response.data);
    }).catch(error => {
        callback(error, error.response.data);
    });
};


export default {
    name: "",
    data: () => ({
        note:{
            title: '',
            subtitle: '',
            content: '',
            created_at: {},
            updated_at: {}
        },
        notes_folders: [],
        notes: []
    }),
    mounted() {
        let vm = this;
        eventBus.$on('noteUpdated', function (response) {
            let auxNote = _.find(vm.notes, function(o) { return o.id == response.id; });
            Object.assign(auxNote, response);
        });

        eventBus.$on('noteDeleted', function (response) {
            if(vm.$route.params.note_id == response.note_id){
                vm.$router.push({ name: 'notes', query: vm.$route.query });
            }

            getNotes(vm.$route.query.folder, vm.$route.query.search, (err, data) => {
                vm.setNotes(err, data);
            });
        });
    },
    beforeRouteEnter (to, from, next) {

        var p1 = new Promise((resolve, reject) => {
            getNotesFolders((err, data) => {
                if(err == null){
                    resolve({err, data})
                }else{
                    reject({err, data})
                }
            });
        });

        var p2 = new Promise((resolve, reject) => {
            getNotes(to.query.folder, to.query.search, (err, data) => {
                if(err == null){
                    resolve({err, data})
                }else{
                    reject({err, data})
                }
            });
        });

        var auxArr = [p1, p2];

        if(to.params.note_id){
            var p3 = new Promise((resolve, reject) => {
                getNote(to.params.note_id, (err, data) => {
                    if(err == null){
                        resolve({err, data})
                    }else{
                        reject({err, data})
                    }
                });
            });
            auxArr.push(p3);
        }

        Promise.all(auxArr).then(values => {
            next(vm => {
                vm.setNotesFolders(values[0].err, values[0].data)
                vm.setNotes(values[1].err, values[1].data)
                if(to.params.note_id){
                    vm.setNote(values[2].err, values[2].data)
                }
            });
        }).catch(e => {
            if(e.err.response.status == 404){
                next({ name: 'not-found' })
            }
        });

    },
    beforeRouteUpdate(to, from, next) {
        if(to.query.folder != from.query.folder || to.query.search != from.query.search){
            getNotes(to.query.folder, to.query.search, (err, data) => {
                this.setNotes(err, data);
            });
        }

        if(to.params.note_id != from.params.note_id && to.params.note_id != null){
            getNote(to.params.note_id, (err, data) => {
                this.setNote(null, data);
            });
        }

        if(to.params.note_id == null){
            this.note = {
                title: '',
                subtitle: '',
                content: '',
                created_at: {},
                updated_at: {}
            };
        }

        next();
    },
    methods: {
        setNotesFolders(err, { data: notes_folders }) {
            if (err) {
                this.error = err.toString();
            } else {
                this.notes_folders = notes_folders;
            }
        },
        setNotes(err, { data: notes }) {
            if (err) {
                this.error = err.toString();
            } else {
                this.notes = notes;
            }
        },
        setNote(err, { data: note }) {
            if (err) {
                this.error = err.toString();
                this.$router.push({ name: 'not-found'})
            } else {
                this.note = note;
            }
        },
    },
    components: {
        NotesMenu: NotesMenu,
        NotesFolders: NotesFolders,
        NotesList: NotesList,
        NoteEditor: NoteEditor,
        NoteDeleteModal: NoteDeleteModal,
        NoteFolderDeleteModal: NoteFolderDeleteModal,
    }
}
</script>
<style lang="scss" scoped>
.notes-main-container{
    width: 100%;
    background: #ffffff;
}
</style>
