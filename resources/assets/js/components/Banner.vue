<style></style>

<template>
    <canvas id="canvas"></canvas>
</template>

<script type="text/babel">
    import Sunburst from "./Sunburst";

    export default {

        props: ['logo', 'colour'],

        data() {
            return {
                sunburst: null,
                width: null
            };
        },

        computed: {
            height_factor() {
                return this.is_narrow_screen ? .6 : .3;
            },

            is_narrow_screen() {
                return this.width < 500;
            }
        },

        mounted() {
            this.width = window.innerWidth;
            this.sunburst = new Sunburst({canvas: this.$el, logo_src: this.logo, colour: this.colour});
            this.drawSunburst(false);
            window.addEventListener('resize', () => this.drawSunburst());
        },

        methods: {

            sunburstDimensions() {
                const base_width = this.width * 3;
                const base_height = base_width * this.height_factor;
                return {
                    centerPoint: {
                        x: this.is_narrow_screen ? base_width / 2 : base_width / 4.5,
                        y: base_height / 2
                    },
                    base_width,
                    base_height,
                    image_width: this.is_narrow_screen ? base_width * .7 : base_width / 3,
                    image_position_factor: this.is_narrow_screen ? 2 : 2.5
                };
            },

            drawSunburst(isRedraw) {
                if(isRedraw && (window.innerWidth === this.width)) {
                    return;
                }

                this.width = window.innerWidth;
                this.sunburst.draw(this.sunburstDimensions());
            }
        }
    }
</script>