@extends("mail.layouts.soundblock")

@section("content")
    <x-head-line class="soundblock-email-headline" title="Confirm Your Email"/>
    <x-p text="Welcome to Soundblock! Please follow the link below to confirm your email address."/>
    <small><a style="color:dodgerblue;" href="{{ $link }}">{{ $link }}</a></small>
    <p style="text-align: center;">
        <x-button class="soundblock-email-button" text="Confirm" :link="$link"/>
    </p>
@endsection
