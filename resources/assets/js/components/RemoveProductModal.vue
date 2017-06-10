<style></style>

<template>
    <span class="product-swap-component">
        <modal :show="showModal" :wider="true">
            <div slot="header">
                <h5>Select a product card to remove</h5>
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
            </div>
            <div slot="footer">
                <button class="btn btn-red"
                        v-on:click="resetSelection">
                    Reset
                </button>
                <button class="btn btn-grey"
                        v-on:click="showModal = false">
                    Cancel
                </button>
                <button class="btn"
                        v-on:click="removeProductCard"
                        :disabled="!old_product"
                >
                    Remove
                </button>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {

        data() {
            return {
                mentioned_products: [],
                old_product: null,
                showModal: false
            };
        },

        created() {
            this.$on('req-remove-product-card', (products) => {
                this.mentioned_products = products;
                this.showModal = true
            });
        },

        methods: {

            setOldProduct(product) {
                this.old_product = product;
            },


            resetSelection() {
                this.old_product = null;
            },

            removeProductCard() {
                this.$emit('remove-product', this.old_product);
                this.showModal = false;
                this.resetSelection();
            }

        }
    }
</script>