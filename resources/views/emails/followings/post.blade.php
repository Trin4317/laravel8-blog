@component('mail::message')
# New post from your favorite author {{ $author }}!

## {{ $title }}
> {{ $excerpt }}

@component('mail::button', ['url' => $url])
View Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
