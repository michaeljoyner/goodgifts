<style></style>

<template>
    <div class="card-collection-component similar-search-component">
        <form action=""
              @submit.prevent.stop="addCardFromUrl"
              class="form-horizontal"
        >
            <div class="form-group">
                <label>Amazon url: </label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Amazon url or id..."
                           v-model="amazon_url">
                            <span class="input-group-btn">
                                <button :disabled="!amazon_url" class="btn btn-default btn-info" type="submit">Add</button>
                            </span>
                </div>
            </div>
        </form>
        <div class="product-listing">
            <div v-for="card in cards" class="similar-product-card">
                <div class="img-box">
                    <img :src="card.image" alt="">
                </div>
                <p>{{ card.price }}</p>
                <a :href="card.link" class="btn">See on Amazon</a>
                <button class="btn" @click="deleteCard(card)">Delete</button>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        data() {
            return {
                cards: [],
                amazon_url: ''
            };
        },

        mounted() {
          this.fetchCards();
        },

        methods: {

            fetchCards() {
                this.$http.get('/admin/services/cards/index')
                        .then(({data}) => this.cards = data)
                        .catch(err => console.log(err.response));
            },

            addCardFromUrl() {
                this.$http.post('/admin/cards', {itemid: this.amazon_url})
                        .then(({data}) => this.onSuccess(data))
                        .catch(err => this.onFail());
            },

            onSuccess(card) {
                this.cards.push(card);
                this.amazon_url = '';
            },

            onFail() {
                eventHub.$emit('user-alert', {
                    type: 'error',
                    title: 'Kak bru',
                    text: 'For some reason or another, that did not work. Refresh, take another stab at it, then call someone.',
                    confirm: true
                });
            },

            deleteCard(card) {
                this.$http.delete(`/admin/cards/${card.id}`)
                        .then(res => this.removeCard(card))
                        .catch(err => console.log(err));
            },

            removeCard(card) {
                this.cards.splice(this.cards.indexOf(this.cards.find(c => c.id === card.id)), 1);
            }

        }
    }
</script>