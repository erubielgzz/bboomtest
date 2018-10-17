<template>
    <div id="notes-list" class="p-0 border" style="overflow-y:scroll;">
        <div class="d-flex flex-column">
            <div class="p-2 note-preview" v-for="note in notes">
                <span class="note-title">{{ note.title }}</span><br />
                <span class="note-subtitle">{{ note.subtitle }}</span>
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
    width: 25%;
}

.note-preview{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    border-bottom: 1px solid #e2e6e9;
}
</style>
