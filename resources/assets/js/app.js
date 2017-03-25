
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
