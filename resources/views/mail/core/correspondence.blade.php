@extends('mail.layouts.merch', ['app' => $app])

@section('content')
    <p>
        @if (isset($arrJsonData))
            @if (!empty($arrJsonData))
                @foreach($arrJsonData as $jsonKey => $jsonValue)
                    <span>
                        <b>{{ ucfirst(str_replace("_", " ", $jsonKey)) }} - </b> {{ $jsonValue }}<br>
                    </span>
                @endforeach
            @endif
        @endif
        <span>
            <b>Email - </b> {{ $correspondence->email }}<br>
        </span>
        <span>
            <b>Subject - </b> {{ $correspondence->email_subject }}<br>
        </span>
    </p>
    @if (!empty($attachments))
        <p>
            <h4>Attachments:</h4>
            @foreach ($attachments as $attachment)
                <span>
                    {{ $attachment["name"] }} - <b><a href="{{ $attachment["url"] }}" style="color: dodgerblue;">Show</a></b><br>
                </span>
            @endforeach
        </p>
    @endif
@endsection
