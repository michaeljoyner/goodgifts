<template>
    <div class="product-swap-component">
        <header class="gg-page-header">
            <h1 class="header-title">Product Swap</h1>
            <div class="page-actions">
                <button class="btn" @click="swap" :disabled="!replacement.itemid">Swap</button>
            </div>
        </header>
        <div class="product-swap-component-inner">
            <div class="original-side">
                <h3>Swap this product</h3>
                <div class="swap-product">
                    <div class="image-box">
                        <img :src="original_image" alt="">
                    </div>
                    <div>
                        <p>{{ original_title }}</p>
                        <p>{{ original_price }}</p>
                    </div>
                </div>
            </div>
            <div class="replacement-side">
                <h3>For this product <span class="btn gg-btn" @click="clear" v-show="replacement.itemid">Clear</span>
                </h3>
                <div class="replacement-finder">
                    <form action=""
                          @submit.prevent.stop="fetchLinkProduct"
                          class="form-horizontal"
                          v-show="!replacement.itemid"
                    >
                        <div class="form-group">
                            <label>Amazon url: </label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Amazon url or id..."
                                       v-model="amazon_product_link">
                                <span class="input-group-btn">
                                <button class="btn btn-default btn-info" type="submit">Find</button>
                            </span>
                            </div>
                        </div>
                    </form>
                    <div v-show="replacement.itemid" class="swap-product">
                        <div class="image-box">
                            <img :src="replacement.image" alt="" height="200">
                        </div>
                        <div>
                            <p>{{ replacement.title }}</p>
                            <p>{{ replacement.price }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="taggings">
            <div class="product-tag-box">
                <item-tagger
                        :sync-url="`/admin/products/${original.id}/tags`"
                        :initial-tags="originalTags"
                        tag-type="product"
                ></item-tagger>
            </div>
        </div>
        <div class="suggestions card">
            <p class="card-title">Gift Reasons</p>
            <div class="product-suggestion"
                 v-for="suggestion in suggestions"
                 :key="suggestion.id"
            >
                <p class="lead">From: <a :href="`/admin/articles/${suggestion.article.id}`">{{ suggestion.article.title }}</a></p>
                <product-reason :article-id="suggestion.article_id"
                                :product-id="suggestion.product_id"
                                :reason-what="suggestion.what"
                                :reason-why="suggestion.why"
                ></product-reason>
            </div>

        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['original', 'original-tags', 'suggestions'],

        data() {
            return {
                original_image: this.original.image,
                original_title: this.original.title,
                original_price: this.original.price,
                replacement: {itemid: null, image: null, title: null, link: null, price: null},
                amazon_product_link: ''
            };
        },

        methods: {
            fetchLinkProduct() {
                this.$http.post('/admin/services/products/lookup', {itemid: this.amazon_product_link})
                    .then(({data}) => this.replacement = data[0])
                    .catch(err => console.log(err));
            },

            clear() {
                this.replacement = {itemid: null, image: null, title: null, link: null, price: null};
                this.amazon_product_link = '';
            },

            swap() {
                this.$http.post(`/admin/products/${this.original.id}`, {amazon_id: this.replacement.itemid})
                    .then(({data}) => this.setSwappedData(data))
                    .catch(err => console.log(err));
            },

            setSwappedData(data) {
                this.original_title = data.title;
                this.original_image = data.image;
                this.original_price = data.price;

                this.clear();
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">
    .product-swap-component-inner {
        display: flex;
        justify-content: space-between;
        background: #ffffff;
        padding: 20px;

        & > * {
            width: 47%;
            flex-grow: 0;
            flex-shrink: 0;
            flex-basis: auto;
        }
    }

    .swap-product {
        text-align: center;
        width: 300px;
        background: #ffffff;
        padding: 20px;

        .image-box {
            width: 200px;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #ffffff;
            margin: 0 auto;

            img {
                max-width: 100%;
            }
        }
    }

    .taggings {
        margin: 2em 0;
    }

    .suggestions {
        background: #fff;
        padding: 20px;
        margin: 2em 0;

        .card-title {
            text-transform: uppercase;
            font-size: 1.2em;
            color: dodgerblue;
        }

        .product-suggestion {
            margin: 1em 0;
        }
    }
</style>