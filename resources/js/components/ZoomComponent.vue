<template>

<div :class="this.$parent.isZoom() ? 'd-none': ''">
    <div style="z-index: 1; position: fixed; text-align: center; width:100%;">
            <img :src="this.$parent.zoomimg" style="width:50%;height: 50%;"> <br>
            <button type="button" @click.prevent="Close()" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Закрыть</button>
    </div>
</div>

</template>

<script>

    export default {

        methods: {

            Close(){
                this.$parent.zoomimg = null;
            }

        }
        
    }

</script>
