<style></style>

<template>
    <div class="interest-tagger-component">
        <h4 class="component-title">Article Interests</h4>
        <p class="lead" v-show="!interests.length">This article currently has no interests</p>
        <div class="current-interests">
            <div v-for="interest in interests">
                <span>{{ interest }}</span>
                <span class="delete-btn close-icon" @click="removeInterest(interest)">&times;</span>
            </div>
        </div>
        <div class="form-froup">
            <label>Type in interests </label>
            <small>You can add multiple interests at once by separating with commas</small>
            <!--<input type="text" v-model="interest_input" @keyup.enter="addInterests">-->
            <type-ahead :suggestions="suggestion_list"
                        :clear-on-hit="true"
                        v-on:typeahead-selected="setFromInput"
            ></type-ahead>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['article-id'],

        data() {
            return {
                interests: [],
                interest_input: '',
                suggestion_list: [],
            };
        },

        mounted() {
            this.fetchInterests();
            this.fetchSuggestionList();
        },

        methods: {

            fetchInterests() {
                this.$http.get(`/admin/articles/${this.articleId}/interests`)
                        .then(({data}) => this.interests = data)
                        .catch(err => console.log(err.response));
            },

            fetchSuggestionList() {
                this.$http.get('/admin/interests')
                        .then(({data}) => this.suggestion_list = data)
                        .catch(err => console.log(err.response));
            },

            addInterests() {
                this.addNewInterest(this.interest_input);
                this.interest_input = '';
            },

            addNewInterest(interest_string) {
                this.interests = this.interests.concat(interest_string.split(',').map(interest => interest.trim()));
                this.syncInterests();
            },

            setFromInput(data) {
                this.addNewInterest(data.name);
            },

            syncInterests() {
                this.$http.put(`/admin/articles/${this.articleId}/interests`, {interests: this.interests.join(',')})
                        .then(({data}) => this.interests = data)
                        .catch(err => console.log(err.response));
            },

            removeInterest(interest) {
                this.interests.splice(this.interests.indexOf(this.interests.find(i => i === interest)), 1);
                this.syncInterests();
            }
        }
    }
</script>