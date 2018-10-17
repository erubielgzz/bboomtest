<template>
    <div id="notes-folders" class="p-0 border">
        <div class="p-2">
            <h4>Folders</h4>
        </div>
        <ul class="nav flex-column navbar-dark">
            <li class="nav-item">
                <router-link class="nav-link" :to="{ path: '', params: $route.params, query: { search: $route.query.search } }" append>
                    All
                </router-link>
            </li>
            <li v-for="folder in folders" class="nav-item">
                <router-link class="nav-link" :to="{ path: '', params: $route.params, query: { folder: folder.id, search: $route.query.search } }" append>
                    {{ folder.name }}
                </router-link>
            </li>
        </ul>
        <div class="mt-auto p-2">
            <button type="button" class="btn btn-sm btn-outline-secondary ph-3"><i class="fa fa-plus"></i> Folder </button>
        </div>
    </div>
</template>
<script>
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

    })
}
</script>
<style lang="scss" scoped>
#notes-folders{
    display: flex;
    flex-direction: column;
    width: 25%;
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
