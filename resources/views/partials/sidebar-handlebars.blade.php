<script id="ruin-bar" type="text/x-handlebars-template">
    <div>
        <button class="button button-red close-button" id="close">Close</button>
    </div>
    <div class="ruin-info">
        <div class="info-bar-image" style="background-image: url('/img/ruins/@{{ image }}')"></div>
        <div class="level info-bar-title">
            <h3 class="link-list-title">@{{ name }}</h3>
            @{{#if official_site}}
                <img class="ministry-logo" src="/img/official.png" alt="Official Site" id="officialLogo">
                <a data-bypass href="@{{ official_site_link }}" id="visitingInfo">Visiting Info</a>
            @{{/if}}
        </div>
        <p class="info-bar-description">@{{ information }}</p>
        <ul class="image-list flex">
            <li class="image-list-item">
                <a data-bypass href="http://maps.apple.com/?ll=@{{ latitude }},@{{ longitude }}">
                    <img src="/img/map.png" alt="Open in default maps app">
                </a>    
            </li>
            @{{#if tripadvisor}}
                <li class="image-list-item">
                    <a data-bypass href="@{{ tripadvisor }}">
                        <img src="/img/tripadvisor.png" alt="Tripadvisor">
                    </a>
                </li>
            @{{/if}}
            @{{#if foursquare}}
                <li class="image-list-item">
                    <a data-bypass href="@{{ foursquare }}">
                        <img src="/img/foursquare.png" alt="Foursquare">
                    </a>
                </li>
            @{{/if}}
        </ul>
        <ul class="link-list">
            <h4 class="link-list-title" id="englishResources">Resources in English</h4>
            @{{#each english_links}}
                <li class="link-list-item"><a data-bypass href="@{{this.url}}">@{{this.description}}</a></li>
            @{{/each }}
            <h4 class="link-list-title" id="turkishResources">Türkçe Kaynaklar</h4>
            @{{#each turkish_links}}
                <li class="link-list-item"><a data-bypass href="@{{this.url}}">@{{this.description}}</a></li>
            @{{/each }}
        </ul>
        <div class="feedback">
            <button id="reportIssue" class="button button-blue feedback-button">Report Issue</button>
        </div>
        <div class="lang-buttons">
            <a href="/tr/@{{ this.slug }}">
                Türkçe
            </a>
            <a href="/en/@{{ this.slug }}">
                English
            </a>
        </div>
        <div class="about">
            <a data-bypass href="https://raicem.github.io/2017/08/28/ancient-cities-of-turkey/" id="aboutLink">About this project</a>
        </div>
    </div>
</script>