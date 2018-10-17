<template>
    <div class="form-group">
        <a target="_blank" class="pull-right btn btn-sm btn-primary" :href="image_url">
            <i class="fa fa-external-link"></i>
        </a>

        <button type="button" name="button" class="pull-right btn btn-sm btn-secondary" @click="copyToClipboard" style="margin-right: 5px;">
            <i class="fa fa-copy"></i>
        </button>
        <label for="comment">Image URL</label>
        <textarea class="form-control" rows="2"  placeholder="Image URL" id="image_url" v-model="image_url"></textarea>
    </div>
</template>
<script>
export default {
    name: "ImageURL",
    props: ['image_url'],
    methods: {
        copyToClipboard() {
            const el = document.createElement('textarea');
            el.value = document.getElementById('image_url').value;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        }
    }
}
</script>
