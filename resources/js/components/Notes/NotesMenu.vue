<template>
    <div id="notes-menu">

        <div class="pull-right" style="width:40%;">
            <input type="text" class="form-control" placeholder="Search">
        </div>

        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group mr-2" role="group">
                <button type="button" class="btn btn-secondary">
                    <i class="fa fa-folder"></i>
                </button>
            </div>
            <div class="btn-group mr-2" role="group">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>


    </div>
</template>
<script>
export default {
    name: "NotesMenu",
    data: () => ({

    })
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
