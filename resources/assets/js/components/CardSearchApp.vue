<style></style>

<template>
    <div class="card-search-component similar-search-component">
        <div class="search-section">
            <form action=""
                  @submit.prevent.stop="searchCards"
                  class="form-horizontal"
            >
                <div class="form-group">
                    <label>Keywords: </label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Birthday, coffee, whatever..."
                               v-model="keywords">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-info" type="submit">Go</button>
                            </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="product-listing">
            <div v-for="product in products" class="similar-product-card" :class="{'saved': product.saved}">
                <p class="product-title">{{ product.title }}</p>
                <div class="img-box">
                    <img :src="product.image" alt="">
                </div>
                <p>{{ product.price }}</p>
                <a :href="product.link" class="btn" v-show="!product.saved">See on Amazon</a>
                <button v-show="!product.saved" class="btn" @click="saveCard(product)">Bag and Tag</button>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        data() {
            return {
                keywords: '',
                products: []
            };
        },

        methods: {

            searchCards() {
                const query = encodeURI(this.keywords);
                this.$http.get(`/admin/services/cards/search?q=${query}`)
                        .then(({data}) => this.products = data)
                        .catch(err => console.log(err.response));
            },

            saveCard(product) {
                this.$http.post('/admin/cards', {itemid: product.itemid})
                        .then(res => product.saved = true)
                        .catch(err => console.log(err.response));
            }
        }
    }
</script>

