<template>

<div v-if="this.$parent.zoomimg">
    <div style="z-index: 1; position: fixed; text-align: center; width:100%;">
            <img @click.prevent="Close()" :src="this.$parent.zoomimg" style="width:50%;height: 50%;">
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
