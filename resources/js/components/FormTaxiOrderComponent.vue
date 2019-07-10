<template>
    <div id="form-taxi-order">
        <form>
            <div class="form-group">
                <label for="from">Откуда</label>
                <input type="text" class="form-control" id="from" v-model="query.from" v-on:input="fromSearch" placeholder="Откуда">
                <div class="search-results" v-if="query.results.length > 0 && query.resultsOf === 1">
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(item, index) in query.results" :key="index" @click="resultSelect(1, index)">{{ item.display_name }}</li>
                    </ul>
                </div>
                <a href="#" class="d-block mt-2" v-if="query.nullResult && query.resultsOf === 1" @click="selectMarker(1)">Не нашли адрес в поиске? Укажите метку на карте.</a>
            </div>
            <div class="form-group">
                <label for="to">Куда</label>
                <input type="text" class="form-control" id="to" v-model="query.to" v-on:input="toSearch" placeholder="Куда">
                <div class="search-results" v-if="query.results.length > 0 && query.resultsOf === 2">
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(item, index) in query.results" :key="index" @click="resultSelect(2, index)">{{ item.display_name }}</li>
                    </ul>
                </div>
                <a href="#" class="d-block mt-2" v-if="query.nullResult && query.resultsOf === 2" @click="selectMarker(2)">Не нашли адрес в поиске? Укажите метку на карте.</a>
            </div>
            <div class="form-group">
                <label for="phone">Номер телефона</label>
                <input type="text" class="form-control" id="phone" placeholder="Номер телефона">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="delivery">
                <label class="form-check-label" for="delivery">Доставка</label>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="children">
                <label class="form-check-label" for="children">Дети</label>
            </div>
            <div class="form-group">
                <label for="comment">Комментарий к заказу</label>
                <textarea class="form-control" style="resize: none" id="comment" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-dark">Заказать</button>
        </form>
    </div>
</template>

<script>
    import throttle from '../Taxi/throttle';
    import time from '../Taxi/time';

    export default {
        name: "FormTaxiOrderComponent",

        created() {
            window._form_taxi_order = this;
        },

        data() {
            return {
                query: {
                    lastRequestTime: 0,
                    from: '',
                    to: '',
                    results: [],
                    // 1 = Откуда | 2 = Куда
                    resultsOf: 1,
                    nullResult: false,
                },
                route: {
                    from: '',
                    to: '',
                },
            }
        },

        methods: {
            fromSearch() {
                this.query.resultsOf = 1;

                if (this.query.lastRequestTime < time()) {
                    this.query.lastRequestTime = time();
                    this.geocoderSearch(this.query.from);
                } else throttle(this.fromSearch, 1000);
            },

            toSearch() {
                this.query.resultsOf = 2;

                if (this.query.lastRequestTime < time()) {
                    this.query.lastRequestTime = time();
                    this.geocoderSearch(this.query.to);
                } else throttle(this.toSearch, 1000);
            },

            resultSelect(point, index) {
                // point 1 = Откуда | 2 = Куда

                if (point === 1) {
                    this.route.from = this.query.results[index];
                    this.query.from = this.route.from.display_name;
                } else if (point === 2) {
                    this.route.to = this.query.results[index];
                    this.query.to = this.route.to.display_name;
                }

                this.query.results = [];
                this.query.nullResult = false;
            },

            selectMarker(point) {
                // point 1 = Откуда | 2 = Куда

                this.query.nullResult = false;
            },

            geocoderSearch(query) {
                console.log(query);

                query = 'Россия, Пермский край, ' + query;

                let params = {
                    q: query,
                    format: 'json',
                };

                axios.get('https://nominatim.openstreetmap.org/search', {
                    params : params,
                })
                    .then(function (response) {
                        console.log(response);

                        this.query.results = response.data;

                        if (this.query.results.length === 0) this.query.nullResult = true;
                    }.bind(this))
                    .catch(function (error) {
                        console.error(error);
                    });

            },

            geocoderSearchByLatLng(point, latLng) {
                // point 1 = Откуда | 2 = Куда

                let params = {
                    lat: latLng.lat,
                    lon: latLng.lng,
                    format: 'json',
                };

                axios.get('https://nominatim.openstreetmap.org/reverse', {
                    params : params,
                })
                    .then(function (response) {
                        console.log(response);

                        if (point === 1) {
                            this.query.from = response.data.display_name;
                        } else if (point === 2) {
                            this.query.to = response.data.display_name;
                        }

                    }.bind(this))
                    .catch(function (error) {
                        console.error(error);
                    });

            },
        }
    }
</script>

<style scoped>
    .search-results {
        max-height: 700px;
        overflow-y: auto;
    }

    .search-results li {
        cursor: pointer;
    }

    .search-results li:hover {
        color: #1d68a7;
    }
</style>