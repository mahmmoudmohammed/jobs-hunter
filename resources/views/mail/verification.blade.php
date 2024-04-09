<x-mail::message>
    # Welcome <b>{{ $name }}</b>

Your Verification Code Is : {{ $code }}

Thanks,<br>
{{ config('app.name') }} Team
</x-mail::message>
