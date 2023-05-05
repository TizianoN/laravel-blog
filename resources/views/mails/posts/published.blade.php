<x-mail::message>
# {{ $published_text }}
## {{ $post->title }}

{{ $post->getAbstract(100) }}

@if ($post->is_published)
<x-mail::button :url="$button_url">
  View Post
</x-mail::button>
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
