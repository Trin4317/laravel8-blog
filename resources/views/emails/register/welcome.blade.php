@component('mail::message')
# Welcome to {{ config('app.name') }}, {{ $name }}!

## <div align="center">We have so many things to share with you.</div>

@component('mail::button', ['url' => config('app.url')])
Visit Page
@endcomponent

## <div align="center">You can start editing your profile now by clicking <a href="{{ config('app.url') . '/profile' }}"><strong>here</strong></a>.</div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
