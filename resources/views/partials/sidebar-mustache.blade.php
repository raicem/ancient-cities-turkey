<script id="ruin-bar" type="text/x-handlebars-template">
    <div>
        <button class="close-button">Close</button>
    </div>
    <div class="ruin-info">
        <div class="info-bar-image" style="background-image: url(@{{ image }})"></div>
        <h3 class="info-bar-title">@{{ name }}</h3>
        <p class="info-bar-description">@{{ information }}</p>
        <a data-bypass href="http://maps.apple.com/?q=@{{ slug }}&sll=@{{ latitude }},@{{ longitude }}" class="info-bar-map-link">Open in default Maps App</a>
        <ul class="info-bar-link-list">
            @{{#each links}}
            <li class="info-bar-link"><a href="@{{this.url}}">@{{this.description}}</a></li>
            @{{/each }}
        </ul>
    </div>
</script>