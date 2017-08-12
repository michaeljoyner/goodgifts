<style></style>

<template>
    <div class="product-selecter-component">
        <p class="lead">Step 1: Find some products to add to the list</p>
        <div class="two-part-split">
            <div class="tabs-container">
                <div class="tabs-nav">
                    <p :class="{'current': tab === 'default'}" @click="tab = 'default'">Request Matches</p>
                    <p :class="{'current': tab === 'tags'}" @click="tab = 'tags'">Search By Tag</p>
                    <p :class="{'current': tab === 'name'}" @click="tab = 'name'">Search By Name</p>
                </div>
                <div class="tabs">
                    <div class="list-tab" v-show="tab === 'default'">
                        <gift-suggestion v-for="suggestion in defaultSuggestions"
                                         :key="`default_${suggestion.id}`"
                                         :suggestion="suggestion"
                        ></gift-suggestion>
                    </div>
                    <div class="list-tab" v-show="tab === 'tags'">
                        <form action="" @submit.stop.prevent="getTagSuggestions">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter tags, can separate with coma"
                                       v-model="tag_query">
                                <span class="input-group-btn">
                                <button class="btn btn-default btn-info" type="submit">Go</button>
                            </span>
                            </div>
                        </form>
                        <gift-suggestion v-for="suggestion in tag_matches"
                                         :key="`tagged_${suggestion.id}`"
                                         :suggestion="suggestion"
                        ></gift-suggestion>
                    </div>
                    <div class="list-tab" v-show="tab === 'name'">
                        <form action="" @submit.stop.prevent="getNameSuggestions">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by amazon product name"
                                       v-model="name_query">
                                <span class="input-group-btn">
                                <button class="btn btn-default btn-info" type="submit">Go</button>
                            </span>
                            </div>
                        </form>
                        <gift-suggestion v-for="suggestion in name_matches"
                                         :key="`name_${suggestion.id}`"
                                         :suggestion="suggestion"
                        ></gift-suggestion>
                    </div>
                </div>

            </div>
            <div class="current-list-container">
                <p>Current list ({{ current_gift_list.length }})</p>
                <div class="current-list"
                     @dragover="dragOverBox($event)"
                     @dragenter="dragEnterBox($event)"
                     @drop="itemDropped($event)"
                >
                    <gift-suggestion v-for="suggestion in current_gift_list"
                                     :key="`current_${suggestion.id}`"
                                     :suggestion="suggestion"
                                     :removable="true"
                                     @remove-suggestion="removeSuggestionFromList(suggestion)"
                    ></gift-suggestion>
                </div>
            </div>
        </div>

    </div>

</template>

<script type="text/babel">
    export default {

        props: ['default-suggestions', 'current-list', 'list-id'],

        data() {
            return {
                current_gift_list: [],
                tag_matches: [],
                name_matches: [],
                tag_query: '',
                name_query: '',
                tab: 'default'
            };
        },

        mounted() {
            this.current_gift_list = this.currentList || [];
            eventHub.$on('suggestion-added', () => this.fetchCurrentList);
            eventHub.$on('suggestion-removed', () => this.fetchCurrentList);
        },

        methods: {

            fetchCurrentList() {
                this.$http.get(`/admin/services/giftlists/${this.listId}/suggestions`)
                    .then(({data}) => this.current_gift_list = data)
                    .catch(err => console.log(err));
            },

            getTagSuggestions() {
                if (this.tag_query === '') {
                    return;
                }

                this.$http.post('/admin/services/suggestions/search/tags', {
                    tags: this.tag_query.split(',').map(t => t.trim())
                })
                    .then(({data}) => this.tag_matches = data)
                    .catch(err => console.log(err));
            },

            getNameSuggestions() {
                if (this.name_query === '') {
                    return;
                }

                this.$http.post('/admin/services/suggestions/search/name', {
                    name: this.name_query
                })
                    .then(({data}) => this.name_matches = data)
                    .catch(err => console.log(err));
            },

            addSuggestionToList(suggestion_id) {
                let suggestion = this.defaultSuggestions.find(item => item.id === suggestion_id);
                if (!suggestion) {
                    suggestion = this.tag_matches.find(item => item.id === suggestion_id);
                }
                if (!suggestion) {
                    suggestion = this.name_matches.find(item => item.id === suggestion_id);
                }

                this.current_gift_list.push(suggestion);
                this.$http.post(`/admin/giftlists/${this.listId}/suggestions/${suggestion_id}`)
                    .then(() => eventHub.$emit('suggestion-added'))
                    .catch(err => console.log(err));
            },

            removeSuggestionFromList(suggestion) {
                this.current_gift_list.splice(this.current_gift_list.indexOf(suggestion), 1);
                this.$http.delete(`/admin/giftlists/${this.listId}/suggestions/${suggestion.id}`)
                    .then(() => eventHub.$emit('suggestion-removed'))
                    .catch(err => console.log(err));
            },

            dragEnterBox(event) {
                if ([...event.dataTransfer.types].includes('it_is_a_suggestion')) {
                    event.stopPropagation();
                    event.preventDefault();
                }
            },

            dragOverBox(event) {
                if ([...event.dataTransfer.types].includes('it_is_a_suggestion')) {
                    event.stopPropagation();
                    event.preventDefault();
                }
            },

            itemDropped(event) {
                const item_id = parseInt(event.dataTransfer.getData('text/plain'));
                this.addSuggestionToList(item_id);
            }
        }
    }
</script>