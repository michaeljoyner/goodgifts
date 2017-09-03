<style></style>

<template>
    <div class="article-preview-component home-article-card" :class="{'opened': showModal}">
        <div class="article-preview-card-face" @click="showModal = true" :class="`grad-${grad}`">
            <p class="card-face-opener">Gifts for</p>
            <p class="article-target">{{ article_target }}</p>
        </div>
        <modal :show="showModal">
            <div slot="header">
            </div>
            <div slot="body">
                <div class="image-bg-holder" :style="{ backgroundImage: `url(${image})`, height: '300px'}">

                </div>
                <!--<img :src="image" :alt="title">-->
                <div class="preview-detail">
                    <h4 class="preview-title">{{ title }}</h4>
                    <p class="preview-text">{{ preview_text }}</p>
                    <a :href="article_link" class="action-button btn-block restricted">Check it out</a>
                </div>
            </div>
            <div slot="footer">
                <a href="/recommendations/signup" class="secondary-button">Get a custom list</a>
                <a href="#" @click.stop.prevent="showModal = false" class="secondary-button">Close</a>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['title', 'image', 'preview_text', 'article_link', 'article_target', 'grad'],

        data() {
            return {
                showModal: false
            };
        }
    }
</script>