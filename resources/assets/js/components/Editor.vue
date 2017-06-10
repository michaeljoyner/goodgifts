<style></style>

<template>
    <div class="editor-container">
        <transition name="slide">
            <span class="last-save-indicator"
                  :class="{'success': save_success, 'failed': ! save_success}"
                  v-show="show_save_indicator"
            >{{ save_status }}</span>
        </transition>
        <textarea name="post_body" id="post-body" v-on:change="markDirty">{{ postContent }}</textarea>
        <input type="file" id="post-file-input" style="display: none;" v-on:change="insertImage($event)">
        <modal :show="modalOpen" :wider="true">
            <div slot="header">
                <h5>Insert an Image</h5>
            </div>
            <div slot="body">
                <div class="editor-image-insert-panel"
                     v-on:drop.prevent="handleFiles($event)"
                     v-on:dragenter.prevent="hover=true"
                     v-on:dragover.prevent="hover=true"
                     v-on:dragleave="hover=false"
                     v-bind:class="{'hovering': hover}"
                >
                    <label for="editor-file-picker">
                        <input type="file"
                               id="editor-file-picker"
                               v-on:change="handleFiles($event)"
                               accept=".jpg,.jpeg,.png,.svg"
                        >
                        <img :src="insert_image_src" alt="" v-show="insert_image_src">
                        <p class="prompt-message" v-show="!insert_image_src">Click to insert an image.</p>
                    </label>
                </div>
                <input type="text"
                       class="image-caption-input"
                       v-model="insert_image_caption"
                       placeholder="Add a caption for the image"
                >
            </div>
            <div slot="footer">
                <button class="btn dd-btn btn-grey"
                        v-on:click="closeModal">
                    Cancel
                </button>
                <button class="btn dd-btn btn-light"
                        v-on:click="insertImage"
                        :disabled="!canInsertImage"
                >
                    Insert
                </button>
            </div>
        </modal>
        <product-link-maker
                ref="link_maker"
                :article-id="postId"
                v-on:product-link-made="insertLinkHtml"
        ></product-link-maker>
        <product-swapper :article-id="postId" ref="swapper" v-on:product-swap="swapProducts"></product-swapper>
        <product-remover ref="remover" v-on:remove-product="removeProductCard"></product-remover>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        props: ['post-id', 'post-content'],

        data() {
            return {
                editor: null,
                uploads: [],
                modalOpen: false,
                hover: false,
                insert_image_src: null,
                insert_image_caption: '',
                save_status: '',
                save_success: false,
                show_save_indicator: false,
                is_dirty: false,
            }
        },

        computed: {
            canInsertImage() {
                return this.insert_image_src !== null;
            }
        },

        mounted() {
            let config = require('./editorinit.js');
            config.images_upload_handler = this.imageUploadHandler;
            config.init_instance_callback = (editor) => {
                editor.on('KeyUp', (e) => this.markDirty());
                editor.on('Change', (e) => this.markDirty());
            };
            config.setup = (ed) => {
                ed.addButton('insert-image-btn', this.makeButton('/images/assets/insert_photo_black.png', this.openUploadModal, ''));
                ed.addButton('save_button', this.makeButton('/images/assets/save_button_icon.png', () => this.saveContent(false), 'Save'));
                ed.addButton('product_link_make_button', this.makeButton('/images/assets/gift_icon.png', () => this.showProductLinkModal()));
                ed.addButton('h4_button', this.makeButton('/images/assets/h4_button.png', () => this.insertHeadingFour(), ''));
                ed.addButton('swap_button', this.makeButton('/images/assets/swap_button.png', () => this.showSwapModal(), ''));
                ed.addButton('rem_prod_button', this.makeButton('/images/assets/delete_icon.png', () => this.requestRemoveProductCard(), ''));
            }
            this.$nextTick(() => tinymce.init(config)
                    .then((editors) => this.editor = editors[0])
                    .catch(() => this.declareFailureToLaunch()));

            window.setInterval(() => this.saveContent(true), 10000);
        },

        methods: {
            insertImage(ev) {
                const imgTag = `<img src="${this.insert_image_src}" alt="${this.insert_image_caption}">`;
                const figureTag = `<figure>
                                ${imgTag}
                                <figcaption>${this.insert_image_caption}</figcaption>
                            </figure><p></p>`;
                let html = this.insert_image_caption == '' ? imgTag : figureTag;
                this.editor.insertContent(html);
                this.resetImageInsert();
                this.modalOpen = false;
            },

            resetImageInsert() {
                this.insert_image_src = null;
                this.insert_image_caption = '';
            },

            handleFiles(ev) {
                var files = ev.target.files || ev.dataTransfer.files;
                if (files[0].type.indexOf('image') === -1) {
                    return this.rejectFile();
                }
                this.processImage(files[0]);

            },

            rejectFile() {
                this.hover = false;
                eventHub.$emit('user-alert', {
                    type: 'error',
                    title: 'That is not a valid file type',
                    text: 'Please only use image files that are jpg, png or svg. Thanks.',
                    confirm: true
                });
            },

            processImage(image) {
                const fileReader = new FileReader();
                fileReader.onload = (event) => this.insert_image_src = event.target.result;
                fileReader.readAsDataURL(image);
            },

            getNextUploadTag() {
                const tag = 'tag_' + this.uploads.length;
                this.uploads.push(tag);
                return tag;
            },

            removeUploadTag(tag) {
                this.uploads.splice(this.uploads.indexOf(tag), 1);
            },

            imageUploadHandler(blobInfo, success, failure) {
                let formData = new FormData;
                const uploadTag = this.getNextUploadTag();
                formData.append('image', blobInfo.blob(), blobInfo.filename());
                this.$http.post('/admin/articles/' + this.postId + '/images', formData)
                        .then((res) => this.uploadSuccess(res.data, success, uploadTag))
                        .catch((err) => this.uploadFailure(err, failure, uploadTag));
            },


            uploadSuccess(res, callback, tag) {
                this.removeUploadTag(tag);
                callback(res.location);
            },

            uploadFailure(res, callback, tag) {
                this.removeUploadTag(tag);
                eventHub.$emit('user-alert', {
                    type: 'error',
                    title: 'Image Failed to Upload',
                    text: 'There was a problem uploading the image to the server. Please remove the image and try again. Thanks.',
                    confirm: true
                });
                callback('HTTP Error: ' + res.status);
            },

            makeButton(icon, click_fn, button_text) {
                return {
                    text: button_text,
                    icon: true,
                    image: icon,
                    onclick: click_fn
                }
            },

            declareFailureToLaunch() {
                eventHub.$emit('user-alert', {
                    type: 'error',
                    title: 'Unable to load editor',
                    text: 'There is a problem starting up the editor, possibly a network error. Please try again later.',
                    confirm: true
                });
            },

            closeModal() {
                this.modalOpen = false;
            },

            openUploadModal() {
                this.modalOpen = true;
            },

            markDirty() {
                this.is_dirty = true;
            },

            saveContent(auto) {
                if (auto && !this.needsToSave()) {
                    return;
                }
                const content = this.editor.getContent();

                this.$http.patch('/admin/articles/' + this.postId + '/body', {body: content})
                        .then((res) => this.saved(true))
                        .catch((er) => this.saved(false));
            },

            needsToSave() {
                return this.uploads.length === 0 && this.is_dirty;
            },

            saved(success) {
                this.save_status = success ? 'Saved' : 'Failed to save';
                this.save_success = success;
                if (success) {
                    this.is_dirty = false;
                }
                this.flashSaveStatus();
            },

            flashSaveStatus() {
                this.show_save_indicator = true;
                window.setTimeout(() => this.show_save_indicator = false, 2000);
            },

            showProductLinkModal() {
                const selection = this.editor.selection.getContent();
                this.$refs.link_maker.$emit('req-product-link-maker', {selection});
            },

            insertLinkHtml({html}) {
                this.editor.selection.setContent(html);
            },

            insertHeadingFour() {
                const text = this.editor.selection.getContent();
                if(text) {
                    this.editor.dom.setOuterHTML(this.editor.selection.getNode(), `<h4>${text}</h4>`);
                } else {
                    this.editor.insertContent(`<h4></h4>`);
                }
            },

            showSwapModal() {
                this.$refs.swapper.$emit('req-product-swap');
            },

            swapProducts(swap) {
                const anchors = this.editor.$('.amzn-text-link');
                anchors.each((i, link) => {
                    if(link.href.indexOf(swap.old_product.itemid) !== -1) {
                        if(swap.link_text === '') {
                            this.editor.dom.setOuterHTML(link, `<a class="amzn-text-link" href="${swap.new_product.link}">${link.innerHTML}</a>`);
                        } else {
                            this.editor.dom.setOuterHTML(link, swap.text_link_html);
                        }
                    }
                });
                const product_cards = this.editor.$(`.amazon-product-card[data-amzn-id=${swap.old_product.itemid}]`);
                product_cards.each((i, card) => {
                    this.editor.dom.setOuterHTML(card, swap.product_card_html);
                });
            },

            requestRemoveProductCard() {
                this.$refs.remover.$emit('req-remove-product-card', this.getArticleMentionProducts());
            },

            removeProductCard({itemid}) {
                const card = this.editor.$(`.amazon-product-card[data-amzn-id=${itemid}]`)[0];
                const container = card.parentNode;

                if(container.classList.contains('count-1')) {
                    return container.parentNode.removeChild(container);
                }

                if(container.classList.contains('count-2')) {
                    container.classList.remove('count-2');
                    container.classList.add('count-1');
                }

                if(container.classList.contains('count-3')) {
                    container.classList.remove('count-3');
                    container.classList.add('count-2');
                }

                container.removeChild(card);
//                console.log(container);
            },

            getArticleMentionProducts() {
                let prods = [];
                this.editor.$('.amazon-product-card').each((i, card) => prods.push(card));

                return prods.map(p => {
                    return {
                        title: p.querySelector('.amazon-product-title').innerHTML,
                        itemid: p.getAttribute('data-amzn-id'),
                        image: p.querySelector('img').src,
                    }
                });
            }
        }
    }
</script>