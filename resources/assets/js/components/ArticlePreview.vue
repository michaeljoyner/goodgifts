<template>
    <div class="article-preview-component home-article-card w-30-ns w-90 center mv3"
         :class="{'opened': showModal}">
        <div class="col-w-bg h3 h4-ns flex flex-column justify-end items-start strong-font br2 relative article-preview-card-face col-body-bg"
             @click="showModal = true"
             :class="">
            <p class="pl2 ma0 col-gr-l">{{ is_real ? 'Gifts for' : 'A List for' }}</p>
            <p class="pb2 pl2 ma0 f5 f4-ns">{{ article_target }}</p>
        </div>
        <modal :show="showModal">
            <div slot="header" class="col-p bt bb bw2">
            </div>
            <div slot="body">
                <div :style="{ backgroundImage: `url(${image})`, height: '250px', backgroundSize: 'cover'}"></div>
                <div class="flex flex-column items-center mw6 ph4 center">
                    <h4 class="ttu mv2 strong-font col-gr tc lh-copy"><span class="bb bw2 bcol-p">{{ title }}</span></h4>
                    <p class="body-font mt2 f6">{{ preview_text }}</p>
                    <a :href="article_link"
                       v-if="is_real"
                       class="col-p-bg col-d mv3 strong-font link f6 ttu pa2">Check it out</a>
                </div>
            </div>
            <div slot="footer" class="col-p-bg flex justify-around pv3 items-center">
                <a class="col-d strong-font ttu f6 link" href="/recommendations/signup">Get a custom list</a>
                <a class="col-d strong-font ttu f6 link" href="#"
                   @click.stop.prevent="showModal = false">Close</a>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['title', 'image', 'preview_text', 'article_link', 'article_target', 'grad', 'is_real'],

        data() {
            return {
                showModal: false
            };
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">
    @import "~@/_variables.scss";
    @import "~@/mixins/_media.scss";



    .article-preview-card-face {
        box-shadow: 2px 2px 5px rgba($brand_dark, .4);
        transition: .3s;

        &:hover {
            transform: translate3d(0, -2px, 0);
            box-shadow: 2px 4px 5px rgba($brand_dark, .7);
        }



        &:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 10px;
            width: 100%;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            background-color: $brand-primary;
        }
    }
</style>