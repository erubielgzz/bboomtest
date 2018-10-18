<template>
    <div id="note-container" class="p-0 border">

        <div id="notes-sub-menu">
            <button type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-save"></i></button>
        </div>
        <small class="p-1 note-meta">
            Created at: {{ note.created_at.date | date_to_human_short }} {{ note.created_at.date | hour_to_human }}<br />
            Updated at: {{ note.updated_at.date | date_to_human_short }} {{ note.updated_at.date | hour_to_human }}
        </small>
        <div class="p-4" style="max-height:400px; overflow-x:scroll;">

            <div
            v-if="!edit"
            @click="edit = !edit"
            class="text-muted" style="font-size: 0.9em; display: block;"
            v-html="noteOrPlaceholder"
            ></div>

            <div
            v-if="edit"
            contenteditable="true"
            class="text-muted"
            style="font-size: 0.9em; display: block;"
            @keyup="internal_note = $event.target.innerHTML"
            v-html="note.content"
            ></div>

        </div>

    </div>
</template>
<script>
export default {
    name: "",
    data: () => ({
        edit: false,
        internal_note: ''
    }),
    props: {
        'note': {
            type: Object,
            required: true
        }
    },
    watch: {
        note() {
            //do something when note value changes

        }
    },
    computed: {
        noteOrPlaceholder() {
            return (this.note.content != null ? this.note.content : 'Empty Note')
        }
    }
}
</script>
<style lang="scss" scoped>

#note-container{
    width: 75%;
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
