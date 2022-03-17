<template>
    <div>
        <div class="main-slider-container uk-visible@m">
            <div class="uk-background-default" style="height: 4.35em"></div>
            <div class="uk-inline uk-width-expand">
                <div dir="ltr" id="sliders-container" class="uk-position-relative" tabindex="-1"
                     data-uk-slideshow="autoplay: true;animation:fade;ratio:1920:860;max-height:860">
                    <ul class="uk-slideshow-items uk-child-width-1-1">
                        <li :data-index="index" v-for="(slider,index) in sliders">
                            <img class="slider-img uk-width-expand" :src="slider.picture">
                        </li>
                    </ul>
                </div>
                <div class="uk-overlay uk-position-cover uk-overflow-hidden" style="pointer-events: none">
                    <div class="uk-container uk-background-primary uk-position-relative">
                        <div class="slider-box uk-position-absolute uk-padding uk-width-large uk-position-relative"
                             :class="[{'fade' : pulse}, currentSlider.left ? 'left' : 'right']"
                             style="top:150px;">
                            <div class="animating-line leading"></div>
                            <div class="animating-line trailing"></div>
                            <div class="slider-content-bottom-line"></div>
                            <div class="content uk-position-relative" style="pointer-events: auto;z-index: 2">
                                <div class="uk-light">
                                    <p class="uk-heading-small uk-margin-remove-top uk-text-justify"
                                       style="text-align-last: left">{{currentSlider.title}}</p>
                                    <p class="uk-text-bold uk-text-large uk-text-primary uk-text-right">
                                        {{currentSlider.sub_title}}</p>
                                    <p class="uk-text-right uk-padding-small uk-padding-remove-horizontal">
                                        <a :href="currentSlider.url ? currentSlider.url : ''"
                                           class="uk-button uk-button-danger uk-border-rounded uk-width-1-2">{{currentSlider.button_text}}</a>
                                    </p>
                                </div>
                                <div class="uk-padding-small uk-padding-remove-horizontal uk-padding-remove-bottom">
                                    <ul uk-dotnav class="uk-dotnav uk-flex-center">
                                        <li @click="showSlider(index)" v-for="(slider,index) in sliders"
                                            :class="{'uk-active': index === parseInt(showingIndex)}"><a></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="uk-hidden@m">
            <div dir="ltr" id="mobile-sliders-container" class="uk-position-relative" tabindex="-1"
                 data-uk-slideshow="autoplay: true;animation:fade;ratio:1:1;">
                <ul class="uk-slideshow-items uk-child-width-1-1">
                    <li :data-index="index" v-for="(slider,index) in sliders">
                        <div class="uk-inline uk-width-expand">
                            <img class="slider-img uk-width-expand" :src="slider.picture">
                            <div class="uk-overlay-primary uk-position-cover uk-overlay-secondary">
                                <div class="uk-padding uk-position-absolute uk-position-center">
                                    <p class="uk-heading-small uk-margin-remove-top uk-text-justify"
                                       style="text-align-last: left">{{slider.title}}</p>
                                    <p class="uk-text-bold uk-text-large uk-text-primary uk-text-right">
                                        {{slider.sub_title}}</p>
                                    <p class="uk-text-center uk-padding-small uk-padding-remove-horizontal">
                                        <a :href="slider.url ? slider.url : ''"
                                           class="uk-button uk-button-danger uk-border-rounded uk-width-1-2">{{slider.button_text}}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="uk-slideshow-nav uk-dotnav uk-flex-center uk-margin uk-position-absolute uk-position-bottom-center"></ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['sliders'],
        data() {
            return {
                showingIndex: 0,
                currentSlider: this.sliders[0],
                pulse: null,
                firstTimer: true,
            }
        },
        mounted() {
            UIkit.util.on(document, 'itemshow', '#sliders-container', (item) => {
                this.showingIndex = item.srcElement.getAttribute('data-index');
            })
        },
        methods: {
            showSlider(index) {
                UIkit.slideshow('#sliders-container').show(index);
                UIkit.slideshow('#sliders-container').stopAutoplay();
            }
        },
        watch: {
            showingIndex: {
                handler: function (val, oldVal) {
                    if (this.firstTimer) {
                        this.firstTimer = false;
                        return;
                    }
                    this.currentSlider = this.sliders[val];
                    this.pulse = false;
                    setTimeout(() => {
                        this.pulse = true;
                    }, 0)
                }
            }
        }
    }
</script>

<style scoped>
    .slider-img {
        object-fit: cover;
        object-position: center;
        height: 100%;
    }

    .slider-content-bottom-line {
        height: 1px;
        width: 300vw;
        background: white;
        position: absolute;
        bottom: -1px;
        left: -100vw;
    }
</style>