<style></style>

<template>
    <div class="article-preview-component home-article-card">
        <div class="image-wrapper">
            <img :src="image" :alt="title" @click="showModal = true">
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
        props: ['title', 'image', 'preview_text', 'article_link'],

        data() {
            return {
                showModal: false
            };
        }
    }
</script>