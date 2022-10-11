@extends("mail.layouts.soundblock")

@section("content")
    <x-head-line class="soundblock-email-headline" title="Welcome {{ $userName }}"/>
    <x-p text="Welcome to Soundblock!"/>

    @if ($is_verified)
        <x-p text="Follow the link below to create new project."/>
        <p style="text-align: center;">
            <x-button class="soundblock-email-button" text="Go to Projects" :link="$frontendUrl"/>
        </p>
    @else
        <x-p text="Please follow the link below to confirm your email address."/>
        <p style="text-align: center;">
            <x-button class="soundblock-email-button" text="Verify" :link="$frontendUrl"/>
        </p>
    @endif
    <p>
        <small><a style="color:dodgerblue;" href="{{ $frontendUrl }}">{{ $frontendUrl }}</a></small>
    </p>
@endsection
