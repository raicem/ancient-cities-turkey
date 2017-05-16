<script id="ruin-bar" type="text/x-handlebars-template">
    <div>
        <button class="close-button">Close</button>
    </div>
    <div class="ruin-info">
        <div class="info-bar-image" style="background-image: url(@{{ image }})"></div>
        <h3 class="info-bar-title">@{{ name }}</h3>
        <p class="info-bar-description">@{{ information }}</p>
        <ul class="info-bar-link-list">
            <li>
                <a data-bypass href="http://maps.apple.com/?q=@{{ slug }}&sll=@{{ latitude }},@{{ longitude }}"
                   class="info-bar-map-link">Open in default Maps App</a>
            </li>
            @{{#if tripadvisor}}
                <li><a data-bypass href="@{{ tripadvisor }}">TripAdvisor</a></li>
            @{{/if}}
            @{{#if foursquare}}
                <li><a data-bypass href="@{{ foursquare }}">Foursquare</a></li>
            @{{/if}}
        </ul>
        <ul class="info-bar-link-list">
            <h4 class="info-bar-title">English Resources</h4>
            @{{#each english_links}}
                <li class="info-bar-link"><a data-bypass href="@{{this.url}}">@{{this.description}}</a></li>
            @{{/each }}
            <h4 class="info-bar-title">Türkçe Kaynaklar</h4>
            @{{#each turkish_links}}
                <li class="info-bar-link"><a data-bypass href="@{{this.url}}">@{{this.description}}</a></li>
            @{{/each }}
        </ul>
    </div>
</script>