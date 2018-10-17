<template>
    <div>
        <div class="image-preview-container">
            <div class="image-preview">
                <div class="dimmer" :class="{ 'active' : !image }">
                    <div class="loader"></div>
                    <p class="dimmer-message">
                        Please wait while the image is being loaded...
                    </p>
                </div>
                <div style="position:relative; top:0; width: 100%">
                    <div style="display: inline-block; position: relative;">
                        <img :src="image.path" id="myimage"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "ImagePreview",
    props: ['image']
}
</script>
<style lang="scss" scoped>

.image-preview-container{
    width: 100%;
    border: 3px solid #888;
    height: 400px;
    background-size: 4% 4%;
    background-image:repeating-linear-gradient(0deg, #eee, #eee 1px, transparent 1px, transparent 40px),repeating-linear-gradient(-90deg, #eee, #eee 1px, transparent 1px, transparent 40px);
    display: table;
    margin-bottom: 20px;
}

.image-preview{
    position: relative;
    display: table-cell !important;
    vertical-align: middle !important;
    text-align: center !important;
    height: 400px;
}

img{
    max-width: 100%;
    max-height: 400px;
}

</style>
