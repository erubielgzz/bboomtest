<template>
    <div id="notes-list" class="p-0 border" style="overflow-y:scroll;">
        <div class="d-flex flex-column">
            <template v-if="notes.length > 0">
                <template v-for="note in notes">
                    <router-link :to="{ name: 'note', params: { note_id: note.id }, query: $route.query }" :style="{ background: note.color }">
                        <div class="p-2 note-preview">
                            <span class="note-title" v-html="$options.filters.highlight(note.title, $route.query.search)"></span><br />
                            <span class="note-subtitle">{{ note.updated_at.date | date_to_human_short }}&nbsp;&nbsp;&nbsp;&nbsp;{{ note.subtitle }}</span><br />
                            <span class="note-folder" v-if="note.note_folder_id">
                                <i class="fa fa-folder"></i> {{ note.folder.name }}
                            </span>
                        </div>
                    </router-link>
                </template>
            </template>
            <div v-else class="alert alert-info" role="alert">
                <i class="fa fa-alert"></i> No notes found
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "",
    props: {
        'notes': {
            type: Array,
            required: true,
            default: function() {
                return []
            }
        }
    },
    data: () => ({

    })
}
</script>
<style lang="scss" scoped>
#notes-list{
    width: 35%;
}

a {
  color: #444;
  text-decoration: none; /* no underline */
}

.router-link-exact-active > .note-preview, .router-link-active > .note-preview{
    background: rgba(0,0,0, 0.4) !important;
    color: #fff;
    font-weight: bold;
}


.note-preview{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    // border-bottom: 1px solid #e2e6e9;
}

.note-title{
    font-size: 1.1em;
    font-weight: bold;
}
.note-subtitle{
    font-size: 0.9em;
    font-weight: lighter;
}

.note-folder{
    font-size: 0.9em;
    font-weight: lighter;
}

.note-preview:hover{
    background-color: rgba(253, 222, 128, 0.8) !important;
}


</style>
