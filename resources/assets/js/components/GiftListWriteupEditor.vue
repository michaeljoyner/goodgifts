<style></style>

<template>
    <div class="gift-list-writeup-editor">
        <p class="lead">Step 2: What would you like to say to {{ sender }}?</p>
        <form action="" @submit.stop.prevent="saveText">
            <textarea class="form-control" v-model="writeup" :disabled="saving"></textarea>
            <button class="gg-btn btn" :disabled="saving" type="submit">Save</button>
        </form>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['initial-text', 'list-id', 'sender'],

        data() {
            return {
                saving: false,
                writeup: ''
            };
        },

        mounted() {
            this.writeup = this.initialText;
        },

        methods: {
            saveText() {
                this.$http.post(`/admin/giftlists/${this.listId}`, {writeup: this.writeup})
                    .then(({data}) => this.writeup = data.writeup)
                    .catch(err => {console.log(err), this.saving = false});
            },

            onSaved(saved_text) {
                this.writeup = saved_text;
                this.saving = false;
            }
        }
    }
</script>