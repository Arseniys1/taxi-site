<template>
    <div id="menu" class="menu mt-3 col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
        <button type="button" class="btn btn-dark mb-3 d-xl-none d-lg-none d-md-none" v-if="!view.showMap" @click="showMap">
            <font-awesome-icon icon="map-marked"/>
            Показать карту
        </button>

        <button type="button" class="btn btn-dark d-xl-none d-lg-none d-md-none" v-if="view.showMap" @click="showPaper">
            <font-awesome-icon icon="bars"/>
            Показать меню
        </button>

        <div class="paper p-2 m-1" v-if="!view.showMap">
            <div class="form">
                <form-taxi-order-component v-if="view.viewForm === this.$root.VIEW_FORM_TAXI_ORDER"></form-taxi-order-component>
                <form-register-by-code-component v-if="view.viewForm === this.$root.VIEW_FORM_REGISTER_BY_CODE"></form-register-by-code-component>
            </div>
        </div>
    </div>
</template>

<script>
    import FormTaxiOrderComponent from "./FormTaxiOrderComponent";
    import FormRegisterByCodeComponent from "./FormRegisterByCodeComponent";
    export default {
        name: "MenuComponent",
        components: {FormRegisterByCodeComponent, FormTaxiOrderComponent},

        created() {
            window._menu = this;
        },

        data() {
            return {
                view: {
                    viewForm: 1,
                    intervalID: null,
                    showMap: false,
                },
            }
        },

        methods: {
            showMap() {
                this.view.showMap = true;
                this.screenListenerStart();
            },

            showPaper() {
                this.view.showMap = false;

                if (this.view.intervalID) this.screenListenerStop();
            },

            screenListenerStart() {
                this.view.intervalID = setInterval(() => {
                    this.screenListener();
                }, 100);
            },

            screenListenerStop() {
                clearInterval(this.view.intervalID);
                this.view.intervalID = null;
            },

            screenListener() {
                const width = document.body.clientWidth;

                if (width >= 768) {
                    this.view.showMap = false;
                    this.screenListenerStop();
                }
            },

        },

    }
</script>

<style scoped>
    .menu {
        position: absolute;
        z-index: 1000;
        max-height: calc(100vh - 2rem);
        overflow-y: auto;
    }

    .menu .paper {
        background-color: #fff;
        box-shadow: 0 0 5px rgba(0,0,0,0.5);
        /*height: 700px;*/
    }
</style>