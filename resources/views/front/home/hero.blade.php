<section class="db flex-ns justify-between-ns pv4">
    <div class="w-40-m w-50-l flex db-ns justify-center items-center">
        <img src="/images/logos/ggfg_logo_seethrough.png"
             alt="Goodgiftsforguys logo" class="db w-50-l w-80 w6-ns mb3 mb5-ns">
    </div>
    <div class="mw6 w-60-m w-50-l mh3 center-ns overflow-hidden">
        <p class="strong-font tc tl-ns f4 f3-m f2-l an-slide-in">Give more than a f<span class="col-p">
                    @include('svgicons.hero.gift', ['classNames' => 'h1 h2-l'])
                </span>ck.</p>
        <p class="lh-copy measure strong-font f5 f4-ns col-gr ph2 ph0-ns tc tl-ns mr3-ns">Get a list of great gift ideas, based on his interests and your budget, right now or when you need it most.</p>
        <div class="flex flex-column items-center flex-row-ns pt4 pt0-ns">
            <a class="flex items-center ba bw2 pa2 strong-font ttu mr3-ns link col-d hov-p mb4 mb0-ns" href="/gifts">
                @include('svgicons.hero.gift-card', ['classNames' => 'mr2'])
                Find a gift
            </a>
            <a class="flex items-center ba bw2 pa2 strong-font mh2 ml0-ns mb3 mb0-ns ttu mr3-ns link col-d hov-p" href="/recommendations/signup">
                @include('svgicons.mail', ['classNames' => 'mr2'])
                Get a list
            </a>
        </div>
    </div>
</section>