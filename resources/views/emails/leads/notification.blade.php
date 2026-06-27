<x-mail::message>
# New {{ $type }} Lead

A new lead was submitted on the website.

@foreach ($data as $key => $value)
@if (! is_array($value) && ! is_object($value) && filled($value))
**{{ str($key)->replace('_', ' ')->title() }}:** {{ $value }}<br>
@endif
@endforeach
<x-mail::button :url="url('/admin')">
Open Admin
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
