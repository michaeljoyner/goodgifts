<style></style>

<template>
    <div class="interests-chooser-component">
        <div class="selected-interests">
            <p v-show="!selected_interests.length">Click or type. Tell us what he likes.</p>
            <label v-show="selected_interests.length">His interests are: </label><br>
            <span v-for="selected in selected_interests"
                  class="chosen-interest"
            >
                <span>{{ selected }}</span>
                <span @click="removeFromSelected(selected)">&times;</span>
            </span>
        </div>
        <div class="interest-options">
            <span v-for="interest in interests_paginator"
                  @click="addInterest(interest)"
                  class="potential-interest"
                  :class="{'used': selected_interests.indexOf(interest) !== -1}"
            >{{ interest }}</span>
            <div class="paginator-buttons" v-show="interestList.length > page_length">
                <button class="prev" @click.prevent="prevPage">&larr;</button>
                <button class="next" @click.prevent="nextPage">&rarr;</button>
            </div>
        </div>
        <div class="add-interests">
            <small class="instruction-line">Add any other interest.</small>
            <div class="buttoned-input">
                <input type="text" name="add_interest" v-model="custom" @keyup.enter="addCustomInterests">
                <button @click.prevent="addCustomInterests">Add</button>
            </div>
        </div>
        <input type="hidden" name="interests" :value="interests_string">
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['interest-list'],

        data() {
            return {
                selected_interests: [],
                page: 1,
                page_length: 8,
                custom: ''
            };
        },

        computed: {

            interests_paginator() {
                if (this.interestList.length < this.page_length) {
                    return this.interestList;
                }

                const start = (this.page - 1) * this.page_length;

                return this.interestList.slice(start, start + this.page_length);
            },

            interests_string() {
                return this.selected_interests.join(',');
            }
        },

        methods: {
            addInterest(interest) {
                interest.split(',')
                        .map(interest => interest.trim())
                        .filter(interest => this.selected_interests.indexOf(interest) === -1)
                        .forEach(interest => this.selected_interests.push(interest));
            },

            addCustomInterests() {
                if (this.custom === '') {
                    return;
                }
                this.addInterest(this.custom);
                this.custom = '';
            },

            nextPage() {
                if ((this.page * this.page_length) < this.interestList.length) {
                    return this.page++;
                }

                this.page = 1;
            },

            prevPage() {
              if(this.page === 1) {
                  return this.page = Math.ceil(this.interestList.length / this.page_length);
              }

              this.page--;
            },

            removeFromSelected(interest) {
                this.selected_interests.splice(this.selected_interests.indexOf(interest), 1);
            }
        }
    }
</script>