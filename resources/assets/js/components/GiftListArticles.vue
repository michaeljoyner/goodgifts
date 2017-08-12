<style></style>

<template>
    <div class="gift-list-articles-component">
        <p class="lead">Step 3: Think of some appropriate articles</p>
        <p class="label-text">Current List Articles</p>
        <p v-show="!list_articles.length">No article have been attached yet.</p>
        <div class="listed-article" v-for="article in list_articles"
             :key="`list_articles_${article.id}`"
        >
            <p>{{ article.title }}</p>
            <div @click="removeArticle(article)" class="remove-link">Remove</div>
        </div>
        <type-ahead :suggestions="articles"
                    :clear-on-hit="true"
                    @typeahead-selected="saveArticle"
        ></type-ahead>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['list-id', 'articles', 'initial-articles'],

        data() {
            return {
                list_articles: []
            };
        },

        mounted() {
          this.list_articles = this.initialArticles || [];
        },

        methods: {

            fetchAttachedArticles() {
                this.$http.get(`/admin/giftlists/${this.listId}/articles`)
                    .then(({data}) => this.list_articles = data)
                    .catch(err => console.log(err));
            },

            saveArticle(article) {
                if(! article.id) {
                    return;
                }

                this.$http.post(`/admin/giftlists/${this.listId}/articles/${article.id}`)
                    .then(() => this.fetchAttachedArticles())
                    .catch(err => console.log(err));
            },

            removeArticle(article) {
                this.list_articles.splice(this.list_articles.indexOf(article), 1);
                this.$http.delete(`/admin/giftlists/${this.listId}/articles/${article.id}`)
                    .then(() => this.fetchAttachedArticles())
                    .catch(err => console.log(err));
            }
        }
    }
</script>