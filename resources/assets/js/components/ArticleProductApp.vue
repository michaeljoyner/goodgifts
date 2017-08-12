<style></style>

<template>
    <div class="article-products-app-component">
        <div class="product-lookup-section">
            <form action=""
                  @submit.prevent.stop="fetchLinkProduct"
                  class="form-horizontal"
            >
                <div class="form-group">
                    <label>Amazon url: </label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Amazon url or id..."
                               v-model="amazon_product_link">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-info" type="submit">Add</button>
                            </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="products-list-section article-products-component">
            <div v-for="product in products" :key="product.id" class="article-product-outer">
                <div class="article-product">
                    <img :src="product.image" alt="" width="80px">
                    <p class="title">{{ product.title }}</p>
                    <span>{{ product.price }}</span>
                    <a :href="product.link" class="btn" target="_blank">Amazon</a>
                    <button class="btn btn-red" @click="removeProduct(product)">Remove</button>
                </div>
                <product-reason :article-id="articleId"
                                :product-id="product.id"
                                :reason-what="product.pivot.what"
                                :reason-why="product.pivot.why"
                ></product-reason>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['article-id'],

        data() {
            return {
                products: [],
                amazon_product_link: ''
            }
        },

        mounted() {
            this.fetchProducts();
        },

        methods: {

            fetchProducts() {
                this.$http.get(`/admin/articles/${this.articleId}/products`)
                        .then(({data}) => this.products = data)
                        .catch(err => console.log(err));
            },

            fetchLinkProduct() {
                this.$http.post(`/admin/articles/${this.articleId}/products`, {item_ids: this.amazon_product_link})
                        .then(({data}) => this.onSuccess(data))
                        .catch(err => this.onFailure(err.response));
            },

            onSuccess(data) {
                this.products = data;
                this.amazon_product_link = '';
            },

            onFailure(err) {
                console.log(err);
                eventHub.$emit('user-alert', {
                    type: 'error',
                    title: 'Oh Shit',
                    text: 'Unable to process item. Refresh and try again or give up.',
                    confirm: true
                });
            },

            removeProduct(product) {
                this.$http.delete(`/admin/articles/${this.articleId}/products/${product.id}`)
                        .then(this.removeProductFromView(product))
                        .catch(err => console.log(err));
            },

            removeProductFromView(product) {
                this.products.splice(this.products.indexOf(this.products.find(prod => prod.id === product.id)), 1);
            }
        }
    }
</script>