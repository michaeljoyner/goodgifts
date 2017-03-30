<style></style>

<template>
    <span class="product-link-generator-component">
        <modal :show="showModal" :wider="true">
            <div slot="header">
                <h5>Insert Amazon Product Link</h5>
            </div>
            <div slot="body">
                <div class="tab-nav">
                    <div :class="{'selected': link_mode === 'text'}"
                         @click="link_mode = 'text'"
                         class="text-link-tab-nav"
                    >Text Link
                    </div>
                    <div :class="{'selected': link_mode === 'card'}"
                         @click="link_mode = 'card'"
                         class="card-link-tab-nav"
                    >Product Card Links
                    </div>
                </div>
                <div class="product-selection-outer">
                    <div class="text-link-tab link-tab" v-show="link_mode === 'text'">
                        <div class="link-text-input-holder">
                            <div class="form-group">
                                <label>Link Text: </label>
                                <input type="text" class="form-control" v-model="link_text">
                            </div>
                        </div>
                        <div class="product-list-item"
                             :class="{'selected': hasInSelection(product)}"
                             v-for="product in article_products"
                             @click="selectProduct(product)"
                        >
                            <img :src="product.image" alt="" width="50px">
                            <p class="title">{{ product.title }}</p>
                        </div>
                    </div>
                    <div class="card-link-tab link-tab" v-show="link_mode === 'card'">
                        <div class="link-maker-product-card"
                             v-for="product in article_products"
                             :class="{'selected': hasInSelection(product)}"
                             @click="selectProduct(product)"
                        >
                            <img :src="product.image" alt="">
                            <p class="card-title">{{ product.title }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div slot="footer">
                <button class="btn btn-red"
                        v-show="selected_products.length"
                        v-on:click="resetProductLink">
                    Reset
                </button>
                <button class="btn btn-grey"
                        v-on:click="showModal = false">
                    Cancel
                </button>
                <button class="btn"
                        v-on:click="generateLink"
                        :disabled="!selected_products.length"
                >
                    Insert
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
                article_products: [],
                selected_products: [],
                showModal: false,
                link_text: '',
                link_mode: 'text'
            }
        },

        created() {
            this.$on('req-product-link-maker', (data) => this.setAndShow(data));
        },

        mounted() {
            this.fetchProducts();
            console.log('mounteeee');
        },

        methods: {

            fetchProducts() {
                this.$http.get(`/admin/articles/${this.articleId}/products`)
                        .then(({data}) => this.article_products = data)
                        .catch(err => console.log(err));
            },

            setAndShow(options) {
                this.link_text = options.selection;
                if (options.selection === "") {
                    this.link_mode = 'card';
                }
                this.showModal = true;
            },

            selectProduct(product) {
                if (this.hasInSelection(product)) {
                    return this.deselectProduct(product);
                }

                if (this.link_mode === 'text') {
                    return this.selected_products = [product];
                }

                if (this.selected_products.length >= 3) {
                    return;
                }

                this.selected_products.push(product);
            },

            deselectProduct(product) {
                this.selected_products.splice(this.selected_products.indexOf(this.selected_products.find(prod => prod.id === product.id)), 1);
            },

            hasInSelection(product) {
                return this.selected_products.find(prod => prod.id === product.id);
            },

            resetProductLink() {
                this.selected_products = [];
                this.link_text = '';
            },

            generateLink() {
                if(this.link_text === "" && this.link_mode === 'text') {
                    return;
                }

                let html = '';
                if(this.link_mode === 'text') {
                    html = this.textLinkHtml(this.selected_products[0]);
                } else if (this.link_mode === 'card') {
                    html = this.productCardsHtml();
                }

                this.$emit('product-link-made', {type: this.link_mode, html: html});

                this.resetProductLink();
                this.showModal = false;
            },

            productCardsHtml() {
                const contents = this.selected_products.map(product => this.makeProductBox(product)).join('');
                let container = `<div class="product-card-container count-${this.selected_products.length}">${contents}</div><p></p>`
                return container;
            },


            makeProductBox(product) {
                const imgTag = `<div class="product-image-box"><a href="${product.link}"><img src="${product.image}" alt="${product.title}"></a></div>`;
                return `<div class="amazon-product-card" data-amzn-id="${product.itemid}">
                                        <p class="amazon-product-title">${product.title}</p>
                                        ${imgTag}
                                        <a href="${product.link}">At Amazon for ${product.price}</a>
                                    </div>`;
            },

            textLinkHtml(product) {
                const link = `<a href="${product.link}" class="amzn-text-link">${this.link_text}</a>`;
                return link;
            }
        }
    }
</script>