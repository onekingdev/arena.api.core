@extends("mail.layouts.soundblock")

@section("content")
    <x-head-line class="soundblock-email-headline" title="Project {{ $project }}"/>
    <x-p text="This is a notification that the status of your project's deployments has changed."/>

    @foreach ($deployments as $deployment)
        <span class="font-book">
            <b>{{ $deployment["platform"] }} - </b> {{ $deployment["status"] }}<br>
        </span>
    @endforeach

    <x-p text="If you have any questions about this deployment, please reach out to us from your support desk at Soundblock. Thank you!"/>

    <p style="text-align: center;">
        <x-button class="soundblock-email-button" text="Go to Soundblock" :link="$link"/>
    </p>
    <p>
        <small><a style="color:dodgerblue;" href="{{ $link }}">{{ $link }}</a></small>
    </p>
@endsection
