<template>
    <span>
        <div class="btn" @click="showModal = true">Add Product</div>
        <modal :show="showModal" :wider="true">
            <div slot="header">
                <p>Find a product to add</p>
            </div>
            <div slot="body">
                <form action="" @submit.stop.prevent="searchProducts">
                    <div class="form-group">
                    <label>Search by product name:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="product name..."
                               v-model="query">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-info" type="submit">Go</button>
                            </span>
                    </div>
                </div>
                </form>
                <div class="product-list-box">
                    <div v-for="product in products" :key="product.id" class="product-match" @click="selectProduct(product)" :class="{'selected': selected && product.id === selected.id}">
                        <img :src="product.image"
                             alt="" height="80px">
                        <p>{{ product.title }}</p>
                    </div>
                </div>
            </div>
            <div slot="footer">
                <div class="modal-actions">
                    <button class="btn btn-red" @click="showModal = false">Cancel</button>
                    <button :disabled="!selected" class="btn" @click="sendSelection">Add</button>
                </div>
            </div>
        </modal>
    </span>

</template>

<script type="text/babel">
    export default {

        data() {
            return {
                showModal: false,
                products: [],
                selected: null,
                query: ''
            }
        },

        methods: {

            searchProducts() {
                if(this.query.length < 3) {
                    return;
                }
                this.$http.post('/admin/services/suggestions/search/name', {
                    name: this.query
                })
                    .then(({data}) => this.products = data.map(result => result.product))
                    .catch(err => console.log(err));
            },

            selectProduct(product) {
              this.selected = product;
            },

            sendSelection() {
                this.$emit('product-selected', this.selected);
                this.showModal = false;
                this.products = [];
                this.selected = null;
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

    .product-match.selected {
        border: 2px solid dodgerblue;
    }

    .product-match {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        border-bottom: 1px solid silver;
        margin-bottom: 10px;
        padding-bottom: 10px;

        img {
            margin-right: 15px;
        }
    }

    .product-list-box {
        height: 500px;
        overflow-y: auto;
    }
</style>