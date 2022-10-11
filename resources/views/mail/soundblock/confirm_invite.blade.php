@extends("mail.layouts.soundblock")

@section("content")

    @if ($flagConfirm == true)
        <x-p class="font-book" text="{{ $userName }} accepted the invitation to your account."/>
    @else
        <x-p class="font-book" text="{{ $userName }} declined the invitation to your account."/>
    @endif

    <h3 class="font-medium">ACCOUNT PLAN:</h3>
    @foreach ($account as $serviceKey => $serviceValue)
        <span class="font-book">
            <b>{{ $serviceKey }} - </b> {{ $serviceValue }}<br>
        </span>
    @endforeach

    <p style="text-align: center;">
        <x-button class="soundblock-email-button" text="Go to Soundblock" :link="$frontendUrl"/>
    </p>

    <small class="font-book">
        Go by link: <a href="$frontendUrl" style="color: dodgerblue;">{{ $frontendUrl }}</a>
    </small>

@endsection
