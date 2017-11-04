<template>
    <div class="mt4">
        <div class="flex-ns ba b--black-30">
            <div class="br b--black-30 pa2 pr4-ns w5-ns">
                <p class="strong-font">For this budget:</p>
                <div class="nowrap">
                    <input name="budget"
                           type="radio"
                           v-model="budget"
                           :value="5000"
                           id="budget-one"
                           class="dn">
                    <label for="budget-one"
                           class="check-label">
                        $50
                    </label>
                </div>
                <div class="nowrap">
                    <input name="budget"
                           type="radio"
                           v-model="budget"
                           :value="10000"
                           id="budget-two"
                           class="dn">
                    <label for="budget-two"
                           class="check-label">
                        $100
                    </label>
                </div>
                <div class="nowrap">
                    <input name="budget"
                           type="radio"
                           id="budget-three"
                           v-model="budget"
                           :value="50000"
                           class="dn">
                    <label for="budget-three"
                           class="check-label">
                        $500
                    </label>
                </div>
                <div class="nowrap">
                    <input name="budget"
                           type="radio"
                           v-model="budget"
                           :value="150000"
                           id="budget-four"
                           class="dn">
                    <label for="budget-four"
                           class="check-label">
                        $1500
                    </label>
                </div>
                <div class="nowrap">
                    <input name="budget"
                           type="radio"
                           v-model="budget"
                           :value="null"
                           id="budget-five"
                           class="dn">
                    <label for="budget-five"
                           class="check-label">
                        No limit
                    </label>
                </div>
            </div>
            <div class="flex-auto pa2">
                <p class="strong-font">And these interests:</p>
                <div class="flex justify-between items-stretch">
                    <div @click="prevPage"
                         class="flex items-center page-arrow w3-ns justify-center"
                         :class="{'disabled': on_first_page}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 17.5 20.15"
                             height="20px">
                            <path d="M.23,9.71,16.8.06a.47.47,0,0,1,.7.4V19.68a.47.47,0,0,1-.7.4L.23,10.52A.47.47,0,0,1,.23,9.71Z"/>
                        </svg>
                    </div>
                    <div class="flex-auto mh2 mh4-ns">
                        <div v-for="(chunk, index) in chunked_interests"
                             :key="index"
                             v-show="page === index">
                        <span v-for="interest in chunk"
                              :key="interest.id"
                              class="interest col-gr-bg ttl f6 br2 pa1 ma1 ma2-ns dib f7 f6-m f5-l"
                              :class="{'selected': interestIsSelected(interest.id)}"
                              @click="toggleInterestSelection(interest.id)"
                        >{{ interest.name }}</span>
                        </div>
                    </div>

                    <div @click="nextPage"
                         class="flex items-center page-arrow w3-ns justify-center"
                         :class="{'disabled': on_last_page}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 17.5 20.15"
                             height="20px">
                            <path d="M17.26,10.44.7,20.09a.47.47,0,0,1-.7-.4V.47A.47.47,0,0,1,.7.06L17.26,9.63A.47.47,0,0,1,17.26,10.44Z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-ns flex-wrap justify-around mw8 mh2 mh4-ns mv5 center-ns">

            <div v-for="product in matching_products"
                 :key="product.id"
                 class="w-25-l w-40-m flex flex-column items-center pa3 col-p ba b--black-30 ma3 col-w-bg">
                <a :href="product.link"
                   target="_blank"
                   rel="noopener"
                   class="link">
                    <p class="col-d strong-font tc">{{ product.suggestions[0].what }}</p>
                    <div class="w4 h4 flex justify-center items-center center">
                        <img :src="product.image"
                             :alt="product.title"
                             class="mw-100 product-image"
                        >
                    </div>
                    <p class="price-label"><span class="vendor-name">amazon</span><span class="inner-price">{{ product.price }}</span>

                    </p>
                </a>
            </div>
        </div>

    </div>
</template>

<script type="text/babel">

    import {shuffle} from "lodash";

    export default {

        data() {
            return {
                interests: [],
                selected_interests: [],
                products: [],
                budget: null,
                page: 0,
                page_length: 15
            };
        },

        computed: {
            matching_products() {
                const matches = this.products
                                    .filter(product => this.productIsInBudget(product))
                                    .filter(product => this.productHasSelectedTag(product));

                return shuffle(matches);
            },

            chunked_interests() {
                const partitionArray = (array, size) => array.map((e, i) => (i % size === 0) ? array.slice(i, i + size) : null).filter((e) => e);
                const sorted_interests = this.interests.sort((a, b) => b.product_count - a.product_count);

                return partitionArray(sorted_interests, this.page_length);
            },

            on_first_page() {
                return this.onFirstPage();
            },

            on_last_page() {
                return this.onLastPage();
            }
        },

        mounted() {
            this.getInterests();
            this.getProducts();
        },

        methods: {

            getProducts() {
                this.$http.get('/services/products')
                    .then(({data}) => this.products = data)
                    .catch(err => console.log(err));
            },

            productHasSelectedTag(product) {
                return product.tags.filter(tag => this.selected_interests.includes(tag)).length > 0;
            },

            productIsInBudget(product) {
                if (!this.budget) {
                    return true;
                }

                return product.price_cents < this.budget;
            },

            getInterests() {
                this.$http.get('/tags')
                    .then(({data}) => this.interests = data)
                    .catch(err => console.log(err));
            },

            toggleInterestSelection(id) {
                if (this.interestIsSelected(id)) {
                    return this.selected_interests.splice(this.selected_interests.indexOf(this.interests.find(i => i.id === id).name), 1);
                }

                this.selected_interests.push(this.interests.find(i => i.id === id).name);

            },

            interestIsSelected(id) {
                return this.selected_interests.indexOf(this.interests.find(i => i.id === id).name) !== -1;
            },

            nextPage() {
                const total_pages = Math.ceil(this.interests.length / this.page_length);

                if ((this.page + 1) < total_pages) {
                    this.page++;
                }
            },

            prevPage() {
                if (this.page > 0) {
                    this.page--;
                }
            },

            onLastPage() {
                const total_pages = Math.ceil(this.interests.length / this.page_length);
                return (this.page + 1) === total_pages;
            },

            onFirstPage() {
                return this.page === 0;
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">
    @import "~@/_variables.scss";
    @import "~@/mixins/_media.scss";

    .check-label {
        &:before {
            content: '';
            width: 1rem;
            height: 1rem;
            border: 1px solid $brand_dark;
            display: inline-block;
            vertical-align: top;
            margin-right: 15px;
        }

    }

    input[type=radio]:checked + label:before {
        background-color: $brand_dark;
    }

    .interest {
        cursor: default;
        transition: .3s;
    }

    .interest.selected {
        transform: scale(1.1);
        background-color: $brand_primary;
    }

    .interest:not(.selected):hover {
        background-color: lighten($brand_primary, 20);
    }

    .product-image {
        max-height: 100%;
    }

    .price-label {
        display: block;
        width: 100%;
        //background: $brand_dark;
        //color: $brand_primary;
        margin: 0;
        padding: 4px;
        text-align: center;
        text-transform: uppercase;
        font-size: 80%;
        margin-top: 5px;

        span {
            position: relative;
            display: inline-block;
            height: 1.15rem;
            line-height: 1.15rem;
            vertical-align: top;
        }

        .vendor-name {
            background: $brand_dark;
            color: $brand_primary;
            padding-left: 8px;

            &::after {
                content: '';
                height: 0;
                font-size: 0px;
                line-height: 0;
                border-right: 1.15rem solid $brand_primary;
                border-bottom: 1.15rem solid $brand_dark;
                width: 0;
                display: inline-block;
                line-height: 0;
                vertical-align: bottom;
            }
        }

        .inner-price {
            background: $brand_primary;
            color: $brand_dark;
            padding-right: 8px;
        }

    }

    .page-arrow:not(.disabled):hover svg {
        fill: $brand_primary;
    }

    .page-arrow.disabled {
        opacity: .1;
    }
</style>