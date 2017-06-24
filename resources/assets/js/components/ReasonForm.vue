<style></style>

<template>
    <div class="product-reason-form-component">
        <div class="form-inputs" :class="{'editable': editable}">
            <div><strong>What: </strong><input type="text" v-model="what"></div>
            <div><strong>Why: </strong><input type="text" v-model="why"></div>
        </div>
        <div class="button-box">
            <button @click="toggleOrSave" class="btn" :disabled="syncing">{{ button_text }}</button>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['article-id', 'product-id', 'reason-what', 'reason-why'],

        data() {
            return {
                what: '',
                why: '',
                editable: false,
                syncing: false
            };
        },

        computed: {
          button_text() {
              return this.editable ? 'Save' : 'Edit';
          }
        },

        mounted() {
            this.what = this.reasonWhat;
            this.why = this.reasonWhy;
        },

        methods: {

            toggleOrSave() {
                if(this.editable) {
                    this.save();
                    return this.editable = false;
                }

                return this.editable = true;
            },

            save() {
                this.syncing = true;
                this.$http.post(`/admin/articles/${this.articleId}/products/${this.productId}/reasons`, {
                    what: this.what,
                    why: this.why
                })
                    .then(({data}) => this.onSuccess(data))
                    .catch(err => this.onFail(err));
            },

            onSuccess() {
                this.syncing = false;
            },

            onFailure() {
                this.syncing = false;
            }
        }
    }
</script>