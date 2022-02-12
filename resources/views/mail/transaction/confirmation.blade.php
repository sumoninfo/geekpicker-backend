@component('mail::message')
# Transaction Confirmation notify

Transaction Confirmation notify description

Date: {{ $transaction->date }}<br>
Account holder: {{ $transaction->toUser->name }}

# FROM
Currency: {{ $transaction->from_currency }}<br>
Amount: {{ $transaction->from_amount }}

# TO
Currency: {{ $transaction->to_currency }}<br>
Converted Amount: {{ $transaction->to_amount }}
{{--@component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
