<style></style>

<template>
    <div class="suggestion-component" draggable @dragstart="startDrag($event)">
        <div class="image-box">
            <img :src="suggestion.product.image" draggable="false" height="80px" alt="">
        </div>
        <div class="text-box">
            <p>WHAT: {{ suggestion.what }}</p>
            <p>WHY: {{ suggestion.why }}</p>
            <p>PRICE: US${{ suggestion.product.price }}</p>
            <p v-show="removable" class="remove-link" @click="removeSuggestion">Remove</p>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['suggestion', 'removable'],

        methods: {
            startDrag(event) {
                event.dataTransfer.setData('text/plain', this.suggestion.id);
                event.dataTransfer.setData('it_is_a_suggestion', 'true');
            },

            removeSuggestion() {
                if(this.removable) {
                    this.$emit('remove-suggestion')
                }
            }
        }
    }
</script>