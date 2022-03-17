<template>
    <div>
        <auto-complete v-if="interactive"
                       v-model="search" api="/map/search" search="address" class="uk-margin-small-bottom"></auto-complete>
        <div :class="{'clickable' : interactive}" id="map" class="uk-border-rounded">
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            interactive: {
                type: Boolean,
                default: false,
            },
            markers: {},
            locate: {
                type: Boolean,
                default: false,
            },
            value: {},
            latName: {
                default: 'lat'
            },
            lngName: {
                default: 'lng'
            }
        },
        data() {
            return {
                map: null,
                keyword: '',
                search: null,
                marker: null,
                cursorLng: null,
                cursorLat: null,
                center: this.value ? this.value : [51.420470, 35.729054]
            }
        },
        mounted() {
            if (this.value) {
                this.center = this.value;
            }
            if (this.locate)
                navigator.geolocation.getCurrentPosition((pos) => {
                    let crd = pos.coords;
                    this.center[0] = crd.longitude;
                    this.center[1] = crd.latitude;
                    this.initMap();
                }, (error) => {
                    console.log(error.message);
                }, {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0,
                });
            else
                this.initMap();

            this.map.on('load', () => {
                this.map.resize();
            });
        },
        methods: {
            updateMarker() {
                this.marker.setLngLat([this.cursorLng, this.cursorLat]);
                this.$emit('input', {[this.latName]: this.cursorLat, [this.lngName]: this.cursorLng});
            },
            initMap() {
                this.map = new mapboxgl.Map({
                    container: 'map',
                    style: `mapbox://styles/mapbox/streets-v11`,
                    center: this.center,
                    zoom: 12
                });
                this.cursorLat = this.map.getCenter().lat;
                this.cursorLng = this.map.getCenter().lng;
                this.map.addControl(new mapboxgl.NavigationControl({
                    showCompass: false,
                }));
                this.map.on('mousemove', (e) => {
                    this.cursorLat = e.lngLat.wrap().lat;
                    this.cursorLng = e.lngLat.wrap().lng;
                });
                if (!_.isEmpty(this.markers)) {
                    let bounds = new mapboxgl.LngLatBounds();
                    _.forEach(this.markers, (marker) => {
                        this.addMarker(marker, marker[2]);
                        // console.log(marker);
                        bounds.extend([marker[0], marker[1]]);
                    });
                    this.map.fitBounds(bounds, {
                        padding: 50
                    });
                }
                if (this.interactive) {
                    this.map.on('click', this.updateMarker);
                    this.addMarker();
                }
            },
            addMarker(coords, cssClass = 'default') {
                coords = coords ? coords : this.map.getCenter();
                let el = document.createElement('div');
                el.className = 'marker';
                el.classList += ` ${cssClass}`;
                this.marker = new mapboxgl.Marker(el).setLngLat(coords).addTo(this.map);
            }
        },
        watch: {
            search(value) {
                this.map.flyTo({
                    center: [
                        value.geom.coordinates[0],
                        value.geom.coordinates[1]
                    ]
                })
            },
        }
    }

</script>

<style scoped>
    #map {
        width: 100%;
        min-height: 300px;
    }
</style>