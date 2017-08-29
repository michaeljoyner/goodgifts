<style></style>

<template>
    <div class="tag-manager-component">
        <div class="tag-actions">
            <button class="btn gg-btn" @click="selectUnused">Select Unused Tags</button>
            <button class="btn gg-btn" @click="uncheckAll">Uncheck All</button>
            <button class="btn gg-btn" @click="showModal = true" :disabled="! hasSelected">Delete Selected Tags</button>
        </div>
        <div class="sort-options">
            <p>Sort:</p>
            <span @click="order = 'alphabet'">Alphabetically</span>
            <span @click="order = 'usage'">By Usage</span>
        </div>
        <div class="tags-list">
            <div v-for="tag in ordered_tags" class="tag-checkbox">
                <label :for="`tag_${tag.id}`">
                    <input type="checkbox" :id="`tag_${tag.id}`" :value="tag.id" v-model="selected_tags">
                    <span>{{ tag.name.toLowerCase() }} ({{ tag.product_count }})</span>
                </label>
            </div>
        </div>
        <modal :show="showModal">
            <div slot="header">
                <h2>Are you sure, hombre?</h2>
            </div>
            <div slot="body">
                <p class="lead">You are about to go ahead a delete {{ selected_tags.length }} tags. So ask yourself, is today your lucky day?</p>
            </div>
            <div slot="footer">
                <button @click.stop.prevent="showModal = false" class="btn btn-grey">Close</button>
                <button @click="deleteSelectedTags" class="btn btn-red">Do it, punk!</button>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">

    export default {

        data() {
            return {
                tags: [],
                selected_tags: [],
                showModal: false,
                order: 'alphabet'
            };
        },

        computed: {
            ordered_tags() {
                if(this.order === 'usage') {
                    console.log('sorting');
                    return this.tags.sort((a,b) => b.product_count - a.product_count);
                }
                console.log('sorting abc');
                return this.tags.sort((a, b) => {
                    const nameA = a.name.toUpperCase();
                    const nameB = b.name.toUpperCase();
                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameB < nameA) {
                        return 1;
                    }
                    return 0;
                });
            },

            hasSelected() {
                return this.selected_tags.length > 0;
            }
        },

        mounted() {
            this.fetchTags();
        },

        methods: {
            fetchTags() {
                this.$http.get('/admin/tags')
                    .then(({data}) => this.tags = data)
                    .catch(err => console.log(err));
            },

            selectUnused() {
                this.tags
                    .filter(tag => tag.product_count === 0 && this.selected_tags.indexOf(tag.id) === -1)
                    .forEach(tag => this.selected_tags.push(tag.id));
            },

            uncheckAll() {
                this.selected_tags = [];
            },

            deleteSelectedTags() {
                this.$http.post('/admin/services/tags/deleted', {tags: this.selected_tags})
                    .then(() => {
                        this.fetchTags();
                        this.showModal = false;
                    }).catch(err => console.log(err));
            }
        }
    }

</script>