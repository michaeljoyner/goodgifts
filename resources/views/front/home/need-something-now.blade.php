<section class="pv5">
    <div class="flex-ns justify-between">
        <div class="w-50-ns mh3 ml0-ns mr3-ns order-0 order-1-ns">
            <p class="f2 mw6 center mt0 strong-font tc tl-ns">Need something now?</p>
            <p class="mw6 center lh-copy">We’ve got hundreds of fun, original and affordable gifts for you to check out.</p>
            <p class="mw6 center lh-copy">Just choose your budget and click a few interests to find the best gifts for him right now.</p>
            <div class="mw6 tc tl-ns center">
                <a class="inline-flex mt4 items-center ba bw2 pa2 strong-font ttu mr3 link col-d hov-p db center"
                   href="/gifts">
                    @include('svgicons.hero.gift-card', ['classNames' => 'mr2'])
                    Find a Gift
                </a>
            </div>
        </div>
        <div class="w-50-ns mh3 mh0-ns mt4 mt0-ns order-1 order-0-ns">
            <div data-flickity='{"cellAlign": "left", "contain": true, "prevNextButtons": false, "pageDots": false, "wrapAround": true, "autoPlay": 2500, "pauseAutoPlayOnHover": false, "draggable": false}'
                 class="h4 w4 h5-ns w5-ns center overflow-hidden">
                @foreach($featured_images as $image)
                    <div class="h4 w4 h5-ns w5-ns flex justify-center items-center">
                        <img src="{{ $image }}"
                             alt="featured product image"
                             class="mw-100 mh-100"
                             >
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>