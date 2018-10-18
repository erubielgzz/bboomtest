<template>
    <div style="margin-bottom:15px;">
        <div class="btn-group pull-right" role="group" aria-label="Zoom controls">
            <button type="button" class="btn btn-secondary" @click="zoomOut"><i class="fa fa-search-minus"></i></button>
            <button type="button" class="btn btn-secondary" @click="zoomIn"><i class="fa fa-search-plus" ></i></button>
        </div>
        <div class="image-zoom-container">
            <div id="myresult" class="img-zoom-result" @resize="appendZoomLens('myimage', 'myresult')"></div>
        </div>
    </div>
</template>
<script>
export default {
    name: "ImageZoom",
    data: () => ({
        zoomSize: 10,
        maxZoomSize: null,
    }),
    props: ['image_url'],
    watch: {
        image_url(newValue, oldValue) {
            if(newValue != oldValue){
                this.appendZoomLens("myimage", "myresult");
            }
        }
    },
    mounted() {
        let vm = this;
        $( window ).resize(function() {
            vm.appendZoomLens("myimage", "myresult");
        });

        let img = document.getElementById("myimage");
        img.onload = function() { vm.appendZoomLens("myimage", "myresult"); }
    },
    methods: {
        appendZoomLens(imgID, resultID) {
            var img, lens, result, cx, cy;
            img = document.getElementById(imgID);
            result = document.getElementById(resultID);
            /*create lens:*/
            if(document.getElementById("myzoomlens")){
                lens = document.getElementById("myzoomlens");
            }else{
                lens = document.createElement("DIV");
                lens.setAttribute("id", "myzoomlens");
                lens.setAttribute("class", "img-zoom-lens");
                /*insert lens:*/
                img.parentElement.insertBefore(lens, img);
            }

            lens.style.left = 0;
            lens.style.top = 0;

            /*calculate the ratio:*/
            let auxLensHeight, auxLensWidth, ratioResult;

            ratioResult = result.offsetWidth / result.offsetHeight;
            auxLensHeight = this.zoomSize * 2;
            auxLensWidth = this.zoomSize * 2 * ratioResult;

            if(auxLensHeight <= img.height && auxLensWidth <= img.width){
                lens.style.height = auxLensHeight + "px";
                lens.style.width = auxLensWidth + "px";
                this.maxZoomSize = false;
            }else if(img.height > img.width){
                this.maxZoomSize = true;
                lens.style.height = img.width * (1/ratioResult) + "px";
                lens.style.width = img.width + "px";
            }else{
                this.maxZoomSize = true;
                lens.style.height = img.height * (1/ratioResult) + "px";
                lens.style.width = img.width + "px";
            }

            /*calculate the ratio between result DIV and lens:*/
            cx = result.offsetWidth / lens.offsetWidth;
            cy = result.offsetHeight / lens.offsetHeight;
            /*set background properties for the result DIV:*/
            result.style.backgroundImage = "url('" + img.src + "')";
            result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
            /*execute a function when someone moves the cursor over the image, or the lens:*/
            lens.addEventListener("mousemove", moveLens);
            img.addEventListener("mousemove", moveLens);
            /*and also for touch screens:*/
            // lens.addEventListener("touchmove", moveLens);
            // img.addEventListener("touchmove", moveLens);

            function moveLens(e) {
                var pos, x, y;
                /*prevent any other actions that may occur when moving over the image:*/
                e.preventDefault();
                /*get the cursor's x and y positions:*/
                pos = getCursorPos(e);
                /*calculate the position of the lens:*/
                x = pos.x - (lens.offsetWidth / 2);
                y = pos.y - (lens.offsetHeight / 2);
                /*prevent the lens from being positioned outside the image:*/
                if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
                if (x < 0) {x = 0;}
                if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
                if (y < 0) {y = 0;}
                /*set the position of the lens:*/
                lens.style.left = x + "px";
                lens.style.top = y + "px";
                /*display what the lens "sees":*/
                result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
            }
            function getCursorPos(e) {
                var a, x = 0, y = 0;
                e = e || window.event;
                /*get the x and y positions of the image:*/
                a = img.getBoundingClientRect();
                /*calculate the cursor's x and y coordinates, relative to the image:*/
                x = e.pageX - a.left;
                y = e.pageY - a.top;
                /*consider any page scrolling:*/
                x = x - window.pageXOffset;
                y = y - window.pageYOffset;
                return {x : x, y : y};
            }

        },
        zoomOut(){
            if(this.maxZoomSize == false){
                this.zoomSize = this.zoomSize * 2;
            }
            this.appendZoomLens("myimage", "myresult");
        },
        zoomIn(){
            if ((this.zoomSize / 2) > 1){
                this.zoomSize = this.zoomSize / 2;
            }
            this.appendZoomLens("myimage", "myresult");
        }
    }
}
</script>
<style lang="scss">

.img-zoom-container {
    position: relative;
}

.img-zoom-lens {
    position: absolute;
    border: 1px solid rgba(200,200,200,0.7);
}

.img-zoom-result {
    border: 1px solid #d4d4d4;
    /*set the size of the result div:*/
    width: 100%;
    height: 280px;
}
</style>
