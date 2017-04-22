<style></style>

<template>
    <div class="card-collection-component similar-search-component">
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