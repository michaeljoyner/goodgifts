module.exports = {
    selector: '#post-body',
    plugins: ['link', 'image', 'paste', 'fullscreen', 'code'],
    menubar: false,
    toolbar: 'undo redo code | styleselect h4_button | bold italic | bullist numlist | link insert-image-btn | fullscreen save_button | product_link_make_button swap_button rem_prod_button',
    paste_data_images: true,
    height: 700,
    body_class: 'article-body-content',
    content_style: "body {font-size: 16px; max-width: 800px; margin: 0 auto;} * {font-size: 16px;} img {opacity: .6; max-width: 100%; height: auto;} img[data-mce-src] {opacity: 1;} figcaption {width: 100%; display: block; text-align:center;}",
    content_css: '/tinymce_article3.css'
}