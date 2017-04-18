<style></style>

<template>
    <div class="similar-search-component">
        <p class="lead" v-show="!Object.keys(products).length">Just hold your horses sir...</p>
        <div class="product-listing">
            <div v-for="product in products" class="similar-product-card">
                <p class="product-title">{{ product.title }}</p>
                <div class="img-box">
                    <img :src="product.image" alt="">
                </div>
                <p>{{ product.price }}</p>
                <a :href="product.link" class="btn">See on Amazon</a>
                <button class="btn" @click="startSave(product)">Save Product</button>
                <button class="btn" @click="updateProducts(product.itemid)">More like this</button>
            </div>
        </div>
        <modal :show="showModal" :wider="true">
            <div slot="header">
                <h4>Add this product to an article</h4>
            </div>
            <div slot="body">
                <p class="lead">Select an article to add this product to</p>
                <div class="list-group">
                    <label class="list-group-item" v-for="article in articles" :for="`article_${article.id}`">
                        <input type="checkbox" :value="article.id" v-model="article_ids" :id="`article_${article.id}`">
                        <span>{{ article.title }}</span>
                    </label>
                </div>
            </div>
            <div slot="footer">
                <button class="btn btn-grey"
                        v-on:click="showModal = false">
                    Cancel
                </button>
                <button class="btn"
                        :disabled="!article_ids.length"
                        @click="saveProduct"
                >
                    Save
                </button>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['itemid', 'articles'],

        data() {
            return {
                products: {},
                showModal: false,
                article_ids: [],
                selected_product: null
            };
        },

        mounted() {
            this.fetchProducts();
        },

        methods: {

            fetchProducts() {
                this.$http.get(`/admin/services/products/similar/${this.itemid}`)
                        .then(({data}) => this.products = data)
                        .catch(err => console.log(err.response));
            },

            updateProducts(itemid) {
                this.$http.get(`/admin/services/products/similar/${itemid}`)
                        .then(({data}) => this.products = data)
                        .catch(err => console.log(err.response));
            },

            startSave(product) {
                this.selected_product = product;
                this.showModal = true;
            },

            saveProduct() {
                Promise.all(this.article_ids.map(article_id => this.$http.post(`/admin/articles/${article_id}/products`, {item_ids: this.selected_product.itemid}))).then(() => this.onSuccess()).catch(err => this.onFailure());
            },

            onSuccess() {
                this.selected_product = null;
                this.article_ids = [];
                this.showModal = false;
                eventHub.$emit('user-alert', {
                    type: 'success',
                    title: 'Good Job Soldier!',
                    text: 'The product has been saved to the article. Go forth and edit.',
                    confirm: true
                });
            },

            onFailure() {
                eventHub.$emit('user-alert', {
                    type: 'error',
                    title: 'Kak Bru',
                    text: 'Something failed. I suggest you refresh and try again.',
                    confirm: true
                });
            }
        }
    }
</script>