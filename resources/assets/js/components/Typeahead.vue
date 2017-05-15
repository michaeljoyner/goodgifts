<style></style>

<template>
    <div class="type-ahead-component">
        <input type="text"
               class="type-ahead-input form-control"
               v-model="query"
               v-on:keydown.down="down"
               v-on:keydown.up="up"
               v-on:keydown.enter="hit"
               v-on:keydown="letterPress($event)"
               v-on:keyup="requestSuggestions"
        >
        <ul class="type-ahead-suggestions">
            <li v-for="match in matches"
                class="list-group-item"
                :class="{'highlight': isCurrent(match)}"
                v-on:mouseenter="setCurrent(match)"
                v-on:mousedown="hit"
            >
                {{ match.name }}
                <span class="type-ahead-sub-field" v-if="subField">{{ match[this.subField] }}</span>
            </li>
        </ul>
    </div>
</template>

<script type="text/babel">
    export default {

        props: {
            suggestions: {
                type: Array,
                required: false,
                default: function () {
                    return [];
                }
            },
            'sub-field': {
                type: String,
                required: false,
                default: null
            },
            'live-search-url': {
                type: String,
                required: false,
                default: null
            },
            'clear-on-hit': {
                type: Boolean,
                required: false,
                default: false
            },
            'search-fields': {
                type: Array,
                required: false,
                default: function() {
                    return [];
                }
            }
        },

        data() {
            return {
                query: '',
                current: null,
                current_index: null,
                selection: null,
                previous_live_search: null
            }
        },

        computed: {

            matches() {
                if (this.query === '') {
                    return;
                }
                return this.suggestions
                        .filter((suggestion) => {
                            return (this.suggestionMatchesQuery(suggestion)) && (!this.isSelected(suggestion));
                        });
            }
        },

        methods: {

            getSearchFields() {
                return ['name'].concat(this.searchFields);
            },

            suggestionMatchesQuery(suggestion) {
                return this.getSearchFields().some((field) => {
                    return suggestion.hasOwnProperty(field) &&
                            suggestion[field] &&
                            this.wordMatchesQuery(suggestion[field]);
                });
            },

            wordMatchesQuery(word) {
              return word.toLowerCase().indexOf(this.query.toLowerCase()) !== -1;
            },

            isCurrent(suggestion) {
                return this.current && (this.current.id === suggestion.id);
            },

            isSelected(match) {
                if (this.selection === null) {
                    return false;
                }
                return match.id === this.selection.id;
            },

            down() {
                this.incCurrentIndex();
                this.current = this.matches[this.current_index];
            },

            up() {
                this.decCurrentIndex();
                this.current = this.matches[this.current_index];
            },

            incCurrentIndex() {
                if (!this.hasMatches()) {
                    return;
                }

                if (this.current_index === null) {
                    return this.current_index = 0;
                }

                if (this.current_index >= (this.matches.length - 1)) {
                    return;
                }

                return this.current_index += 1;
            },

            decCurrentIndex() {
                if (!this.hasMatches() || (this.current_index <= 0) || this.current_index === null) {
                    return;
                }

                if (this.current_index >= this.matches.length - 1) {
                    return this.current_index = this.matches.length - 2;
                }

                return this.current_index -= 1;
            },

            letterPress(ev) {
                if (ev.keyCode === 40 || ev.keyCode === 38) {
                    return;
                }
                this.resetCurrent();
            },

            hit() {
                let payload = this.current === null ? {id: null, name: this.query} : this.current;


                this.$emit('typeahead-selected', payload);
                if (this.clearOnHit) {
                    this.query = '';
                }
            },

            setCurrent(match) {
                this.current_index = this.matches.indexOf(match);
                this.current = match;
            },

            resetCurrent() {
                this.current = null;
                this.current_index = null;
                if (this.selection && this.query !== this.selection.name) {
                    this.selection = null;
                }
            },

            hasMatches() {
                return this.matches.length > 0;
            },

            requestSuggestions(ev) {
                if (this.query.length < 4 || !this.liveSearchUrl) {
                    return;
                }
                if (this.previous_live_search === this.query) {
                    return;
                }
                this.$http.post(this.liveSearchUrl, {searchterm: this.query})
                        .then(res => this.addFetchedSuggestions(res))
                        .catch(err => console.log(err));
                this.previous_live_search = this.query;
            },

            addFetchedSuggestions(res) {
                const results = res.data.slice(0, 10);
                this.suggestions = results;//.map(item => ({id: item.id, name: item.name}));
            }
        }
    }
</script>