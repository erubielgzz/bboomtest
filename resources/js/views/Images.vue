<template>
    <div class="row">

        <div class="col-sm-12">
            <h2>
                Image Preview Tool
                <router-link
                :to="{ name: 'images' }"
                class="btn btn-sm btn-secondary" v-if="current_view=='previewer'"
                >Upload Another Image</router-link>

            </h2>
        </div>

        <div class="col-sm-7">
            <image-uploader v-if="current_view=='uploader'"></image-uploader>
            <image-preview :image="image" v-else></image-preview>
        </div>
        <div class="col-sm-5">
            <image-zoom :image_url="image.path" v-if="current_view=='previewer'"></image-zoom>
            <image-url :image_url="image.path" v-if="current_view=='previewer'"></image-url>
        </div>
        <div class="col-sm-12">
            <image-gallery v-if="meta.total > 0" :images="images" :meta="meta"></image-gallery>
        </div>

        <image-delete-modal></image-delete-modal>

    </div>
</template>
<script>
import { eventBus } from '../app';

import ImageUploader from '../components/Images/ImageUploader'
import ImagePreview from '../components/Images/ImagePreview'
import ImageZoom from '../components/Images/ImageZoom'
import ImageUrl from '../components/Images/ImageUrl'
import ImageGallery from '../components/Images/ImageGallery'
import ImageDeleteModal from '../components/Images/ImageDeleteModal'

const getImages = (page, callback) => {
    const params = { page };

    axios
    .get('/api/images', { params })
    .then(response => {
        callback(null, response.data);
    }).catch(error => {
        callback(error, error.response.data);
    });
};

const getImage = (image_id, callback) => {

    axios
    .get('/api/images/' + image_id)
    .then(response => {
        callback(null, response.data);
    }).catch(error => {
        callback(error, error.response.data);
    });
};

export default {
    name: "Images",
    data: () => ({
        image:{},
        images: [],
        meta: {},
        links: {
            first: null,
            last: null,
            next: null,
            prev: null,
        },
        error: '',
    }),
    mounted() {
        let vm = this;
        if(vm.$route.params.image_id){
            getImage(vm.$route.params.image_id, (err, data) => {
                vm.setImage(err, data);
            });
        }
        eventBus.$on('imageDeleted', function (response) {
            if(vm.$route.params.image_id == response.image_id){
                vm.$router.push({ name: 'images', query: vm.$route.query });
            }

            getImages(vm.$route.query.page, (err, data) => {
                vm.setImages(err, data);
            });

        });
    },
    watch: {
        image_id(newValue, oldValue) {
            if(oldValue != newValue && newValue != null){
                this.image = {};
                getImage(this.$route.params.image_id, (err, data) => {
                    this.setImage(null, data);
                });
            }
        }
    },
    beforeRouteEnter (to, from, next) {
        getImages(to.query.page, (err, data) => {
            next(vm => vm.setImages(err, data));
        });
    },
    beforeRouteUpdate (to, from, next) {
        if(to.query.page != from.query.page || (to.params.image_id != null && from.params.image_id == null)){
            getImages(to.query.page, (err, data) => {
                this.setImages(err, data);
            });
        }
        next();
    },
    computed: {
        image_id(){
            return this.$route.params.image_id;
        },
        current_view() {
            return ( this.$route.params.image_id ? 'previewer' : 'uploader' );
        }
    },
    methods: {
        setImage(err, { data: image }) {
            if (err) {
                this.error = err.toString();
                this.$router.push({ name: 'not-found'})
            } else {
                this.image = image;
            }
        },
        setImages(err, { data: images, links, meta }) {
            if (err) {
                this.error = err.toString();
            } else {
                this.images = images;
                this.links = links;
                this.meta = meta;
            }
        },
    },
    components: {
        ImageUploader: ImageUploader,
        ImagePreview: ImagePreview,
        ImageZoom: ImageZoom,
        ImageUrl: ImageUrl,
        ImageGallery: ImageGallery,
        ImageDeleteModal: ImageDeleteModal,
    }
}
</script>
<style lang="scss" scoped>
</style>
