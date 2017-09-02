<style></style>

<template>
    <div class="gift-list-pick-component suggestion-component" :class="{'pending': pick.id === null}">
        <div class="image-box">
            <img :src="pick.product_image" draggable="false" height="80px" alt="">
        </div>
        <div class="text-box">
            <p>WHAT: {{ pick.what }}</p>
            <p>WHY: {{ pick.why }}</p>
            <p>PRICE: US${{ pick.price }}</p>
            <p class="remove-link" @click="removePick">Remove</p>
            <div class="top-pick-check"
                 v-if="pick.id !== null"
                 :class="{'waiting': waiting}"
                 @click="toggleTopPick"
            >
                <svg v-show="is_top" fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"/>
                    <path fill="#5bea66" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['pick'],

        data() {
            return {
                waiting: false,
                is_top: this.pick.top_pick
            };
        },

        methods: {
            removePick() {
                this.$emit('remove-pick', this.pick);
            },

            toggleTopPick() {
                if(this.waiting === true) {
                    return;
                }

                if(this.is_top) {
                    return this.removeTopPick();
                }

                this.setTopPick();
            },

            setTopPick() {
                this.waiting = true;
                this.$http.post('/admin/top-picks', {pick_id: this.pick.id})
                    .then(({data}) => { this.is_top = data.top_pick; this.waiting = false; })
                    .catch(err => { console.log(err); this.waiting = false; })
            },

            removeTopPick() {
                this.waiting = true;
                this.$http.delete(`/admin/top-picks/${this.pick.id}`)
                    .then(() => { this.is_top = false; this.waiting = false; })
                    .catch(err => { console.log(err); this.waiting = false; })
            }
        }


    }
</script>