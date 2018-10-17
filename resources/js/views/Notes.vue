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
                    <div id="note-container" class="p-0 border">
                        <notes-sub-menu></notes-sub-menu>
                        <note-editor></note-editor>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>

import NotesMenu from '../components/Notes/NotesMenu'
import NotesSubMenu from '../components/Notes/NotesSubMenu'
import NotesFolders from '../components/Notes/NotesFolders'
import NotesList from '../components/Notes/NotesList'
import NoteEditor from '../components/Notes/NoteEditor'
import NoteDeleteModal from '../components/Notes/NoteDeleteModal'

const getNotesFolders = (callback) => {

    axios
    .get('/api/notes_folders')
    .then(response => {
        callback(null, response.data);
    }).catch(error => {
        callback(error, error.response.data);
    });
};

const getNotes = (page, callback) => {
    const params = { page };

    axios
    .get('/api/notes', { params })
    .then(response => {
        callback(null, response.data);
    }).catch(error => {
        callback(error, error.response.data);
    });
};

export default {
    name: "",
    data: () => ({
        notes_folders: [],
        notes: []
    }),
    beforeRouteEnter (to, from, next) {
        function getCompanyDetails() {
            return  axios.get('/getCompanyDetails')
        }

        function getUsers() {
            return axios.get('/getusers');
        }

        axios.all([getCompanyDetails(), getUsers()])
            .then(axios.spread(function (company_details, company_users) {
                next((vm) => { vm.setUser(err, company_users); vm.setDetails(err, company_details); })
            }));


        // axios.all([getNotesFolders(err, data), getNotes(err, data)])
        // .then(axios.spread(function (notes_folders, notes) {
        //     next((vm) => { vm.setNotesFolders(err, notes_folders); vm.setNotes(err, notes); })
        // }));
    },
    // beforeRouteEnter (to, from, next) {
    //     var err1, err2, data1, data2;
    //
    //     getNotesFolders((err, data) => {
    //         console.log(data);
    //         err1 = err;
    //         data1 = data;
    //     });
    //     getNotes(to.query.page, (err, data) => {
    //         console.log(data);
    //         err2 = err;
    //         data2 = data;
    //     });
    //
    //     next((vm) => {
    //         console.log(data1);
    //         console.log(data2);
    //
    //         vm.setNotesFolders(err1, data1);
    //         vm.setNotes(err2, data2)
    //     });
    //
    // },
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
    },
    components: {
        NotesMenu: NotesMenu,
        NotesSubMenu: NotesSubMenu,
        NotesFolders: NotesFolders,
        NotesList: NotesList,
        NoteEditor: NoteEditor,
        NoteDeleteModal: NoteDeleteModal,
    }
}
</script>
<style lang="scss" scoped>

#note-container{
    width: 75%;
}

.notes-main-container{
    width: 100%;
    background: #ffffff;
}
</style>
