<template>
    <div>
        <div class="gg-page-header">
            <h1 class="header-title">Featured Products</h1>
            <div class="page-actions">
                <product-finder @product-selected="addFeaturedProduct"></product-finder>
            </div>
        </div>
        <div class="featured-product-grid">
            <div v-for="product in products" :key="product.id" class="featured-product">
                <img :src="product.image"
                     alt="" height="150px">
                <p>{{ product.title }}</p>
                <button class="btn btn-red" @click="removeProduct(product)">Remove</button>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                products: []
            }
        },

        mounted() {
            this.fetchProducts();
        },

        methods: {
            addFeaturedProduct(product) {
                this.$http.post('/admin/featured-products', {product_id: product.id})
                    .then(() => this.fetchProducts())
                    .catch(err => console.log(err));
            },

            fetchProducts() {
                this.$http.get('/admin/services/featured-products')
                    .then(({data}) => this.products = data)
                    .catch(err => console.log(err));
            },

            removeProduct(product) {
                this.$http.delete(`/admin/featured-products/${product.id}`)
                    .then(() => this.fetchProducts())
                    .catch(err => console.log(err));
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

    .featured-product-grid {
        display: flex;
        flex-wrap: wrap;
        margin: 50px 0;
        justify-content: space-between;

        .featured-product {
            width: 30%;
            display: flex;
            flex-direction: column;
            background: #fff;
            align-items: center;
            padding: 20px;

            p {
                margin: 1em 0;
            }
        }
    }
</style>