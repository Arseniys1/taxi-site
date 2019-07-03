<template>
    <div id="map">
        <div id="leaflet-map" class="leaflet-map"></div>
    </div>
</template>

<script>
    export default {
        name: "MapComponent",

        created() {
            window._map = this;
        },

        mounted() {
            var map = L.map('leaflet-map', {
                zoomControl: false,
            }).setView([58.2673, 54.9312], 15);

            this.map = map;

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.control.zoom({
                'position': 'bottomright',
            }).addTo(map);

            $(window).on("resize", function() {
                $("#map").height($(window).height()).width($(window).width());
                map.invalidateSize();
            }).trigger("resize");

            map.on('click', function (e) {
                this.onMapClick(e);
            }.bind(this));
        },

        data() {
            return {
                map: null,
                marker1: null,
                marker2: null,
                polyline: null,
            }
        },

        methods: {
            onMapClick(e) {
                if (this.marker1 == null) {
                    this.marker1 = new L.marker(e.latlng, {draggable: true});
                    this.marker1.on('dragend', function(event) {
                        this.sendPost();
                    }.bind(this));
                    this.map.addLayer(this.marker1);
                }
                else if (this.marker2 == null) {
                    this.marker2 = new L.marker(e.latlng, {draggable: true});
                    this.marker2.on('dragend', function(event) {
                        this.sendPost();
                    }.bind(this));
                    this.map.addLayer(this.marker2);
                    this.sendPost();
                }
            },

            sendPost() {
                if (this.marker2 != null && this.marker1 != null) {
                    let p1 = this.marker1.getLatLng(),
                        p2 = this.marker2.getLatLng();

                    const coords = p1.lng + ',' + p1.lat + ';' + p2.lng + ',' + p2.lat;

                    $.get(
                        'https://router.project-osrm.org/route/v1/driving/' + coords,
                        {
                            overview: false,
                            alternatives: true,
                            steps: true,
                        },
                        function(data) {

                            if (data) {
                                if (this.polyline) {
                                    this.map.removeLayer(this.polyline);
                                }

                                if (data.routes.length > 0) {
                                    const points = [];

                                    data.routes[0].legs[0].steps.map((step) => {
                                        console.log(step);

                                        points.push(
                                            polyline.decode(step.geometry)
                                        );
                                    });

                                    console.log(points);

                                    this.polyline = new L.polyline(points, {color: 'red'});
                                    this.map.addLayer(this.polyline);
                                    this.map.fitBounds(this.polyline.getBounds());
                                } else console.error('Маршрутов 0', data);
                            }
                        }.bind(this), "json"
                    );

                }
            }
        }

    }
</script>

<style scoped>
    .leaflet-map {
        background: #eee;
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>