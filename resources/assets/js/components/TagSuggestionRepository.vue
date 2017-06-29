<style></style>

<template>
    <span></span>
</template>

<script type="text/babel">
    export default {

        data() {
            return {
                article_tags: [],
                product_tags: []
            };
        },

        mounted() {
            this.fetchArticleTags();
            this.fetchProductTags();
            eventHub.$on('product-tags-updated', () => this.fetchProductTags());
        },

        methods: {
            fetchArticleTags() {
                this.$http.get('/admin/interests')
                    .then(({data}) => {this.article_tags = data; this.broadcastAvailableArticleTags()})
                    .catch(err => console.log(err.response));
            },

            fetchProductTags() {
                this.$http.get('/admin/tags')
                    .then(({data}) => {this.product_tags = data; this.broadcastAvailableProductTags()})
                    .catch(err => console.log(err.response));
            },

            broadcastAvailableArticleTags() {
                eventHub.$emit('article-tags-available', this.article_tags);
            },

            broadcastAvailableProductTags() {
                eventHub.$emit('product-tags-available', this.product_tags);
            }
        }
    }
</script>