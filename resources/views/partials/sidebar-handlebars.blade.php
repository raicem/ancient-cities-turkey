<script id="ruin-bar" type="text/x-handlebars-template">
    <div>
        <button class="button button-red close-button">Close</button>
    </div>
    <div class="ruin-info">
        <div class="info-bar-image" style="background-image: url('/img/ruins/@{{ image }}')"></div>
        <h3 class="link-list-title">@{{ name }}</h3>
        <p class="info-bar-description">@{{ information }}</p>
        <ul class="image-list flex">
            <li class="image-list-item">
                <a data-bypass href="http://maps.apple.com/?ll=@{{ latitude }},@{{ longitude }}">
                    <img src="/img/map.png" alt="">
                </a>    
            </li>
            @{{#if tripadvisor}}
                <li class="image-list-item">
                    <a data-bypass href="@{{ tripadvisor }}">
                        <img src="/img/tripadvisor.png" alt="">
                    </a>
                </li>
            @{{/if}}
            @{{#if foursquare}}
                <li class="image-list-item">
                    <a data-bypass href="@{{ foursquare }}">
                        <img src="/img/foursquare.png" alt="">
                    </a>
                </li>
            @{{/if}}
        </ul>
        <ul class="link-list">
            <h4 class="link-list-title">Resources in English</h4>
            @{{#each english_links}}
                <li class="link-list-item"><a data-bypass href="@{{this.url}}">@{{this.description}}</a></li>
            @{{/each }}
            <h4 class="link-list-title">Türkçe Kaynaklar</h4>
            @{{#each turkish_links}}
                <li class="link-list-item"><a data-bypass href="@{{this.url}}">@{{this.description}}</a></li>
            @{{/each }}
        </ul>
        <div class="feedback">
            <button class="button button-blue feedback-button">Report Issue / Hata Bildirin</button>
        </div>
    </div>
</script>