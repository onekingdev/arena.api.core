@extends("mail.layouts.soundblock")

@section("content")
    <x-head-line class="soundblock-email-headline" title="Support Ticket Reply"/>
    <p style="word-break: break-word;">Thank you for contacting us at {{ucfirst($app->app_name)}}! You have a new reply to your support ticket titled {{$ticket->ticket_title}}.</p>

    @if ($sound_url)
        <x-p text="Please follow the link below to view message."/>
        <p style="text-align: center;">
            <x-button class="soundblock-email-button" text="Support" :link="$sound_url"/>
        </p>
        <p>
            <small><a style="color:dodgerblue;" href="{{ $sound_url }}">{{ $sound_url }}</a></small>
        </p>
    @else
        <p style="word-break: break-word;">Please <a href="{{$url}}">sign into your account</a> and click the support link at the top of any page to view this message.</p>
    @endif
@endsection
