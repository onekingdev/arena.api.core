<html lang="en">
    <head>
        <title>TourMask Order</title>
    </head>
    <body>
        New order from TourMask has been handled!
        @foreach($order as $orderKey => $orderValue)
            <p>{{$orderKey}}: {{$orderValue}}</p>
        @endforeach
    </body>
</html>