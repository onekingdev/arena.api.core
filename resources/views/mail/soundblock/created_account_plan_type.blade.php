@extends("mail.layouts.soundblock")

@section("content")
    <x-head-line class="soundblock-email-headline" title="Account Plan Type Update"/>
    <x-p text="Hello {{ $userName }}, we would like to inform you about account plan type change."/>
    <x-p text="New accountplan type: {{ $accountPlanType }}"/>

    <p style="word-break: break-word;">If you have any questions about this, please reach out to us from your support desk at Soundblock. Thank you!</p>

    <p style="text-align: center;">
        <x-button class="soundblock-email-button" text="Setting Page" :link="$frontendUrl"/>
    </p>
    <p>
        <small><a style="color:dodgerblue;" href="{{ $frontendUrl }}">{{ $frontendUrl }}</a></small>
    </p>
@endsection
