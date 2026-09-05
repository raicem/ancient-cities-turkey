@if (! empty($initialRuins))
    {{-- Boot data for the React SPA: the full ruins list in the request locale,
        so markers render without a blocking API round-trip. @json hex-escapes,
        so this is safe to embed in a script tag. --}}
    <script>
        window.__INITIAL_RUINS__ = {
            locale: '{{ app()->getLocale() }}',
            data: @json($initialRuins),
        };
    </script>
@endif
