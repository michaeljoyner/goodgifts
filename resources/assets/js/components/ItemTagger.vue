<style></style>

<template>
    <div class="interest-tagger-component">
        <h4 class="component-title">{{ this.tagType === 'article' ? 'Article Interests' : 'Product Tags' }}</h4>
        <p class="lead" v-show="!interests.length">This item currently has no interests</p>
        <div class="current-interests">
            <div v-for="interest in interests">
                <span>{{ interest }}</span>
                <span class="delete-btn close-icon" @click="removeInterest(interest)">&times;</span>
            </div>
        </div>
        <div class="form-froup">
            <label>Type in tags </label>
            <small>You can add multiple tags at once by separating with commas</small>
            <type-ahead :suggestions="suggestion_list"
                        :clear-on-hit="true"
                        v-on:typeahead-selected="setFromInput"
            ></type-ahead>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['sync-url', 'initial-tags', 'article-id', 'tag-type'],

        data() {
            return {
                interests: [],
                interest_input: '',
                suggestion_list: [],
            };
        },

        mounted() {
            this.interests = this.initialTags;
            eventHub.$on(this.suggestionEvent(), (tags) => this.suggestion_list = tags);
        },

        methods: {

            fetchSuggestionList() {
                this.$http.get('/admin/interests')
                        .then(({data}) => this.suggestion_list = data)
                        .catch(err => console.log(err.response));
            },

            suggestionEvent() {
              return this.tagType === 'article' ? 'article-tags-available' : 'product-tags-available';
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
                this.$http.put(this.syncUrl, {tags: this.interests})
                        .then(({data}) => this.onSyncSuccess(data))
                        .catch(err => console.log(err.response));
            },

            onSyncSuccess(data) {
                this.interests = data;
                if(this.tagType === 'product') {
                    eventHub.$emit('product-tags-updated');
                }
            },

            removeInterest(interest) {
                this.interests.splice(this.interests.indexOf(this.interests.find(i => i === interest)), 1);
                this.syncInterests();
            }
        }
    }
</script>