<template>
    <div>
        <menu-component></menu-component>
        <map-component></map-component>
    </div>
</template>

<script>
    import MenuComponent from "./MenuComponent";
    import MapComponent from "./MapComponent";
    export default {
        name: "AppComponent",
        components: {MapComponent, MenuComponent},

        created() {
            window._app = this;
        },

    }
</script>

<style scoped>

</style>