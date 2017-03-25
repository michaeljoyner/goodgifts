<style></style>

<template>
    <div class="article-products-component">
        <div class="article-product" v-for="product in products">
            <img :src="product.image" alt="" width="80px">
            <p class="title">{{ product.title }}</p>
            <span class="price">{{ product.price }}</span>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['article-id'],

        data() {
            return {
                products: []
            }
        },

        mounted() {
            this.fetchProducts();
        },

        methods: {
            fetchProducts() {
                this.$http.get(`/admin/services/articles/${this.articleId}/products`)
                        .then(({data}) => this.products = data)
                        .catch(err => console.log(err));
            }
        }
    }
</script>