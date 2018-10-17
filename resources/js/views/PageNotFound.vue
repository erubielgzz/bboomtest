<template>
    <div style="text-align:center;">
        <h2>404 - Page Not Found</h2>
        <p>
            You sure you were looking for this? <br />
        </p>
        <span class="frowny-face" v-show="!happy"><i class="fa fa-meh-o"></i></span>
        <span class="frowny-face" v-show="happy"><i class="fa fa-smile-o"></i></span>
        <router-link class="home-link" :to="{ name: 'welcome' }" @mouseenter.native="happy=true" @mouseleave.native="happy=false">Go Home</router-link>
    </div>
</template>
<script>
export default {
    name: "PageNotFound",
    data: () => ({
        happy: false
    })
}
</script>
<style lang="scss" scoped>

.frowny-face{
    line-height: 1em;
    font-size: 15em;
    width: 100%;
    z-index: 1;
    position: relative;
    display: block;
}

.fa-meh-o{
    height: 1em;
    width: 1em;
    background-color: #ffd88d;
    border-radius: 1em;
}

.fa-smile-o{
    height: 1em;
    width: 1em;
    background-color: #98ff8d;
    border-radius: 1em;
}

</style>
