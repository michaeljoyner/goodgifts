<style></style>

<template>
    <span class="product-swap-component">
        <modal :show="showModal" :wider="true">
            <div slot="header">
                <h5>Swap out a product</h5>
            </div>
            <div slot="body">
                <p class="component-section-title">To be removed</p>
                <div class="mentioned-products product-small-list-box" :class="{'has-selection': old_product !== null}">
                    <div class="mentioned-product product-box"
                         v-for="mentioned in mentioned_products"
                         @click="setOldProduct(mentioned)"
                         :class="{'selected': old_product && mentioned.itemid === old_product.itemid}"
                    >
                        <img :src="mentioned.image" width="50px" height="50px" alt="">
                        <span>{{ mentioned.title }}</span>
                    </div>
                </div>
                <p class="component-section-title">To be swapped in</p>
                <div class="stored-products product-small-list-box" :class="{'has-selection': new_product !== null}">
                    <div class="stored-product product-box"
                         v-for="stored in stored_products"
                         @click="setNewProduct(stored)"
                         :class="{'selected': new_product && stored.id === new_product.id}"
                    >
                        <img :src="stored.image" width="50px" height="50px" alt="">
                        <span>{{ stored.title }}</span>
                    </div>
                </div>
                <p class="component-section-title">Text for new text link (blank for same as old)</p>
                <input type="text" class="form-control" v-model="link_text">
            </div>
            <div slot="footer">
                <button class="btn btn-red"
                        v-on:click="resetProductSwap">
                    Reset
                </button>
                <button class="btn btn-grey"
                        v-on:click="showModal = false">
                    Cancel
                </button>
                <button class="btn"
                        v-on:click="swapProducts"
                        :disabled="!old_product && !new_product"
                >
                    Swap
                </button>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {

        props: ['article-id'],

        data() {
            return {
                mentioned_products: [],
                stored_products: [],
                old_product: null,
                new_product: null,
                link_text: '',
                showModal: false
            };
        },

        created() {
          this.$on('req-product-swap', () => this.showModal = true);
        },

        mounted() {
            this.fetchMentionedProducts();
            this.fetchStoredProducts();
        },

        methods: {

            fetchMentionedProducts() {
                this.$http.get(`/admin/services/articles/${this.articleId}/products`)
                        .then(({data}) => this.mentioned_products = data)
                        .catch(err => console.log(err.response));
            },

            fetchStoredProducts() {
                this.$http.get(`/admin/articles/${this.articleId}/products`)
                        .then(({data}) => this.stored_products = data)
                        .catch(err => console.log(err.response));
            },

            setOldProduct(product) {
                this.old_product = product;
            },

            setNewProduct(product) {
                this.new_product = product;
            },

            resetProductSwap() {
                this.old_product = null;
                this.new_product = null;
                this.link_text = '';
            },

            swapProducts() {
                this.$emit('product-swap', {
                    old_product: this.old_product,
                    new_product: this.new_product,
                    link_text: this.link_text,
                    text_link_html: this.textLinkHtml(this.new_product),
                    product_card_html: this.makeProductBox(this.new_product)
                });
                this.showModal = false;
            },

            makeProductBox(product) {
                const imgTag = `<div class="product-image-box"><a href="${product.link}"><img src="${product.image}" alt="${product.title}"></a></div>`;
                return `<div class="amazon-product-card" data-amzn-id="${product.itemid}">
                                        <p class="amazon-product-title">${product.title}</p>
                                        ${imgTag}
                                        <a href="${product.link}"><span class="vendor-name">amazon</span><span class="inner-price">${product.price}</span></a>
                                    </div>`;
            },

            textLinkHtml(product) {
                const link = `<a href="${product.link}" class="amzn-text-link">${this.link_text}</a>`;
                return link;
            }

        }
    }
</script>