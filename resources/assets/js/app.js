
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('editor', require('./components/Editor.vue'));
Vue.component('toggle-switch', require('./components/Toggleswitch.vue'));
Vue.component('article-publisher', require('./components/ArticlePublisher.vue'));
Vue.component('single-upload', require('./components/Singleupload.vue'));
Vue.component('article-products', require('./components/ArticleProducts.vue'));
Vue.component('article-products-app', require('./components/ArticleProductApp.vue'));
Vue.component('product-link-maker', require('./components/ProductLinkGenerator.vue'));
Vue.component('similar-search', require('./components/SimilaritySearch.vue'));
Vue.component('card-search', require('./components/CardSearchApp.vue'));
Vue.component('card-collection', require('./components/CardCollection.vue'));
Vue.component('line-chart', require('./components/LineChart.vue'));
Vue.component('item-tagger', require('./components/ItemTagger.vue'));
Vue.component('type-ahead', require('./components/Typeahead.vue'));
Vue.component('product-swapper', require('./components/ProductSwapSelector.vue'));
Vue.component('product-remover', require('./components/RemoveProductModal.vue'));
Vue.component('product-reason', require('./components/ReasonForm.vue'));
Vue.component('tag-repository', require('./components/TagSuggestionRepository.vue'));
Vue.component('list-maker', require('./components/ListMaker.vue'));
Vue.component('gift-suggestion', require('./components/Suggestion.vue'));
Vue.component('list-writeup', require('./components/GiftListWriteupEditor.vue'));
Vue.component('giftlist-articles', require('./components/GiftListArticles.vue'));
Vue.component('tag-manager', require('./components/TagManager.vue'));

window.eventHub = new Vue();

const app = new Vue({
    el: '#app',

    created() {
        eventHub.$on('user-alert', this.showAlert)
    },

    methods: {
        showAlert(message) {
            swal({
                type: message.type,
                title: message.title,
                text: message.text,
                showConfirmButton: message.confirm
            });
        }
    }
});
