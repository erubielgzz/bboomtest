<template>
    <div>
        <h4 >Image Gallery</h4>

        <nav v-if="meta && meta.last_page > 1">
            <ul class="pagination">
                <li class="page-item" v-for="pageNumber in meta.last_page" v-if="Math.abs(pageNumber - meta.current_page) < 3 || pageNumber == meta.last_page || pageNumber == 1">
                    <router-link class="page-link"
                        :class="{'last': (pageNumber == meta.last_page && Math.abs(pageNumber - meta.current_page) > 3), 'first':(pageNumber == 1 && Math.abs(pageNumber - meta.current_page) > 3)}"
                        :to="{ name: $route.name, params: $route.params, query: { page: pageNumber } }">{{ pageNumber }}
                    </router-link>
                </li>
            </ul>
        </nav>

        <hr />

        <div class="row text-center text-lg-left">

            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6" v-for="image in images" :key="image.key">
                <router-link style="display:block;" :to="{ name: 'image', params: { image_id: image.id }, query: $route.query }">
                    <div class="p-2 image-tb">
                        <div style="display:table-cell; vertical-align: middle; text-align:center; text-align:center;">
                            <img class="img-fluid img-thumbnail" :src="image.path" alt="">
                        </div>
                    </div>
                </router-link>
                <div class="mb-4">
                    <button type="button" class="btn btn-danger btn-block" @click="deleteImage(image)"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import { eventBus } from '../../app';

export default {
    name: "ImageGallery",
    props: {
        'images': {
            type: Array,
            required: true,
        },
        'meta':{
            type: Object,
            required: true
        }
    },
    methods: {
        deleteImage(image){
            eventBus.$emit('imageDeleteModalShow', image);
        },
    }
}
</script>
<style lang="scss" scoped>

.img-thumbnail{
    max-height: 80px !important;
}

.image-tb{
    display:table;
    height:100px;
    width:100%;
    background: #e2e6e9;
}

.router-link-exact-active > .image-tb,
.router-link-active > .image-tb{
    background: #3c4249;
}

a.first::after {
    content:'...'
}

a.last::before {
    content:'...'
}

.router-link-exact-active.page-link{
    z-index: 1;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.btn.btn-danger.btn-block{
    border-radius: 0em 0em 0.25em 0.25em;
}


</style>
