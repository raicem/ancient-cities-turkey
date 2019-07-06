<header class="site-header">
    <a href="/" class="site-header__title">Ancient Cities Of Turkey</a>
    <div class="site-header__links">
        <a href="/" class="site-header__link">@lang('messages.header.homePage')</a>
        <a href="/{{ app()->getLocale() }}/{{  app()->getLocale() === 'tr' ? 'hakkinda' : 'about' }}"
           class="site-header__link">
            @lang('messages.header.about')
        </a>
    </div>
</header>