@extends("mail.layouts.soundblock")

@section("content")

    @if (isset($flagContract))
        <x-head-line class="soundblock-email-headline font-bold" title="You are invited to {{ $project['Name'] }} project contract"/>
    @else
        @if(isset($flagAccept))
            <x-head-line class="soundblock-email-headline font-bold" title="You are invited to {{ $project['Name'] }} project"/>
        @else
            <x-head-line class="soundblock-email-headline font-bold" title="You have been added to {{ $project['Name'] }} project"/>
        @endif
    @endif

    <x-p class="font-book" text="Soundblock delivers your music to the world's most relevant streaming services and can manage your physical merchandise sales and reporting. Soundblock is the most transparent, secure, and cost effective music distribution platform on earth."/>
    <x-p class="font-book" text="Soundblock smartly distributes your music and merchandise to the most relevant platforms and storefronts while every stream, download, and t-shirt sale is documented forever on the blockchain."/>

    <h3>Project details:</h3>
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

    @if (!empty($params))
        @if (isset($flagContract))
            <h3 class="font-medium">INVITATION to CONTRACT DETAILS:</h3>
        @else
            <h3 class="font-medium">INVITATION DETAILS:</h3>
        @endif
        @foreach ($params as $name => $value)
            <span class="font-book">
                <b>{{ $name }} - </b> {{ $value }}<br>
            </span>
        @endforeach
    @endif

    <p style="text-align: center;">
        @if (isset($flagContract))
            <x-button class="soundblock-email-button" text="Project Contract" :link="$frontendUrl"/>
        @else
            <x-button class="soundblock-email-button" text="Project" :link="$frontendUrl"/>
        @endif
    </p>
    <small class="font-book">
        @if ($flagAccept)
            Accept by link: <a href="{{$frontendUrl}}" style="color: dodgerblue;">{{ $frontendUrl }}</a>
        @else
            Go by link: <a href="{{$frontendUrl}}" style="color: dodgerblue;">{{ $frontendUrl }}</a>
        @endif

    </small>
@endsection
