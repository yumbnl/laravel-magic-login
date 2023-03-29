@component('mail::layout')
@slot ('header')
@component('mail::header', ['url' => 'app.' . config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

  {{ __('magic-login::mail.body_1', ['appname' => config('app.name')]) }}
  
  @component('mail::button', ['url' => $login_link])
    {{ __('magic-login::mail.button_label')}}
  @endcomponent

  {{ __('magic-login::mail.body_2') }}
  @component('mail::panel')
    {{$token}}
  @endcomponent

  {{ __('magic-login::mail.body_3') }}
  
  {{ config('mail.from.name') }}

@slot('subcopy')
@component('mail::subcopy')
  {{ __('magic-login::mail.subcopy') }}
@endcomponent
@endslot

@slot ('footer')
@component('mail::footer')
  &copy;{{ Carbon\Carbon::now()->format('Y') }} {{ config('app.name') }}
@endcomponent
@endslot
@endcomponent 