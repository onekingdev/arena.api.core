<html lang="en">
    <head>
        <title>{{$action}}</title>
    </head>
    <body>
        <p>Title: {{$ticket->ticket_title}}</p>
        <p>User: {{$ticket->user->name}}</p>
        <p>Message: {!! $objMsg->message_text !!}</p>
        <a href="{{$link}}">View</a>
    </body>
</html>
