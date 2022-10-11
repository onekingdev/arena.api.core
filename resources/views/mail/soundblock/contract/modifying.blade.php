@extends("mail.layouts.soundblock")

@section("content")

{{--    <x-head-line class="soundblock-email-headline font-bold" title="Soundblock"/>--}}
    <x-p class="font-book" text="{{ $userName }} has proposed the following modifications to the project {{ $project['Name'] }}."/>

    <h3 class="font-medium">PROJECT DETAILS:</h3>
    <table style="width: 100%;">
        <tbody>
        <tr>
            <td style="width: 60%;">
                @foreach ($project as $projectKey => $projectValue)
                    <span class="font-book">
                            <b>{{ $projectKey }} - </b> {{ $projectValue }}<br>
                        </span>
                @endforeach
            </td>
            <td style="width: 40%;">
                <img style="" src="{{ $artwork }}" width="80" alt="Project artwork">
            </td>
        </tr>
        </tbody>
    </table>
    <h3 class="font-medium">ACCOUNT PLAN:</h3>
    @foreach ($account as $serviceKey => $serviceValue)
        <span class="font-book">
            <b>{{ $serviceKey }} - </b> {{ $serviceValue }}<br>
        </span>
    @endforeach
    <h3 class="font-medium">CONTRACT PARTICIPANTS:</h3>
    @foreach($contractUsers as $userName)
        <span class="font-book">
            <b> - </b>{{ $userName }}<br>
        </span>
    @endforeach

    <p style="text-align: center;">
        <x-button class="soundblock-email-button" text="Check modifications" :link="$frontendUrl"/>
    </p>
    <small class="font-book">
        Go by link: <a href="{{$frontendUrl}}" style="color: dodgerblue;">{{ $frontendUrl }}</a>
    </small>

@endsection
