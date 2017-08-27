<script id="feedback-form" type="text/x-handlebars-template">
    <div class="alert alert-error"></div>
    <div class="alert alert-success"></div>
    <form action="#">
        <div class="form-group">
            <input type="hidden" name="ruin" id="ruin" value="@{{ slug }}">
            <input type="hidden" name="ruin_id" id="ruin_id" value="@{{ id }}">
        </div>
        <div class="form-group">
            <textarea name="body" id="body" rows="5" placeholder="Please enter info about @{{ name }}"></textarea>
        </div>
        <div class="form-group">
            <button class="button button-blue" type="submit" id="send">Send</button>
        </div>
    </form>
</script>