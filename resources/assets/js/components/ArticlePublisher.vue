<style></style>

<template>
    <div class="article-publisher-component">
        <p>Should this be published?</p>
        <toggle-switch :initial-status="initialState" v-on:switch-toggled="setPublishStatus"></toggle-switch>
        <label for="publish-date-input">Publish Date: </label>
        <input type="date" v-model="publish_date">
        <button class="btn" @click="update">
            <span v-show="!saving">Save</span>
            <div class="spinner" v-show="saving">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </button>
        <p class="alert" v-show="isLive">It's Live!</p>
    </div>
</template>

<script type="text/babel">
    const moment = require('moment');

    export default {

        props: {
            'initial-state': {
                type: Boolean,
                required: true
            },

            'article-id': {
                type: Number,
                required: true,
            },

            'published-on': {
                type: String,
                required: true
            }
        },

        data() {
            return {
                publish: null,
                publish_date: null,
                saving: false
            };
        },

        computed: {
            isLive() {
               return moment(this.publish_date).isBefore();
            }
        },

        mounted() {
            this.publish = this.initialState;
            this.publish_date = this.publishedOn;
        },

        methods: {

            update() {
                this.saving = true;
                this.$http.post(`/admin/articles/${this.articleId}/publish`, this.publishData())
                        .then(({data}) => this.onSuccess(data))
                        .catch(err => this.onFail(err));
            },

            onSuccess(data) {
                this.saving = false;
                this.publish = data.published;
                this.publish_date = data.published_on;
            },

            onFail(err) {
                console.log(err);
                this.saving = false;
            },

            publishData() {
                if (this.publish_date) {
                    return {
                        publish: this.publish,
                        published_on: this.publish_date
                    };
                }

                return {
                    publish: this.publish
                };
            },

            setPublishStatus({state}) {
                this.publish = state;
            }
        }
    }
</script>