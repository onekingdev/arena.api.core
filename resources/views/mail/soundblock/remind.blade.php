@extends("mail.layouts.soundblock")

@section("content")

<x-head-line class="soundblock-email-headline" title="You are invited to project"/>
<p>
    We remind you that you were sent to the <b>{{ $name }}</b> project.
</p>
@if (!empty($params))
    <h3>Invite details:</h3>
    @foreach ($params as $name => $value)
        <span>
            <b>{{ $name }} - </b> {{ $value }}<br>
        </span>
    @endforeach
@endif
<h3>Project details:</h3>
@foreach ($project as $projectKey => $projectValue)
    <span>
        <b>{{ $projectKey }} - </b> {{ $projectValue }}<br>
    </span>
@endforeach
<h3>Account details:</h3>
@foreach ($account as $serviceKey => $serviceValue)
    <span>
        <b>{{ $serviceKey }} - </b> {{ $serviceValue }}<br>
    </span>
@endforeach
<p style="text-align: center;">
    <x-button class="soundblock-email-button" text="Accept Invitation" :link="$frontendUrl"/>
</p>
<small>
    Accept by link: <a href="$frontendUrl" style="color: dodgerblue;">{{ $frontendUrl }}</a>
</small>
@endsection
