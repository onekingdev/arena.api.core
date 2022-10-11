@extends("welcome")

@section("pusher")
    <h1>Pusher Test</h1>
    <p>
        Try publishing an event to channel <code>my-channel</code>
        with event name <code>my-event</code>.
    </p>
    <a href="http://localhost:8000/storage/soundblock/service/A52C1FC5-394D-4AE1-AB96-0210F638EA0E/projects/B7ACFF30-3684-439B-AEBE-F08CE1F4CABA/zip/project.zip" download>
        <img src="../storage/default/avatar.png" width="100", height="100"/>
    </a>
    <script>
        // Enable pusher logging - don"t include this in production
        Pusher.logToConsole =true;

        Pusher.log = function(msg) {
           console.log(msg);
        };

        let uri = 'http://test.api.arena.com/broadcasting/auth';
        var token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiNWZhMzVmYmM0OTgwY2Q2MzIzMGUyODAzMjVkMjM0ODhiMjgyYmY1NThkMTQwYTBmZTI2YjdlMzljY2IxYTUyZGMyMmVhNzIyZjE5YWM2MjAiLCJpYXQiOjE1ODgyNzcyODIsIm5iZiI6MTU4ODI3NzI4MiwiZXhwIjoxNTg4MzYzNjgyLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.mG9hs2XNlbS4Dr8w6rOh5pRvzyLR3ZScjd1gpgXHQscFwtCHhD9zjDB8DGdc9l_8zF8_youcJGrgU2T9zRuTyoVWkRulLSfanBxkqNZFdyncBlGwnBRNhk2Z2d5NK-PlYCQVLUOXJti71HUiOroZlM2PG-bRkfF6_0g6YdtJrNSN1PcgtdRg2G8xl6W8g7NDKhuOLgcrZALfjowP6Yowju6xjw9s0oYVuD1rAn-ZB00n0OPC9vl4wWD6inYSdxidO7RlnlNrrtKGze4lRJpRfm1iUrPUi1u-4_7JD264W9NRffGZ3xhfZC5sbHIklep3ju8bRRmdjkSvTqxNdSbX3i_TMKiGYN5K-IZhzjQqWoxRRKQedwRqMf21FuZU9qnYeM7WQQRJIf-3k5rL09fhD_rh9CMF3h2VLULX1oZDwau18ajMendSol_0BgTOqtceBGvUbA9weH-i1UCLmP7pnp-DU9h4efz17v04MZyuwQYyjw6maFxEzUkAsJ9B3_JJbXiliZNpPngGX3iSC_C1Adb4h3s5uPtehFE7vuzeXIqZCx-nN1tGLPiej5Y2C-sYtRM4G32FqgkxHrgJ6sv7KQebuuGkq_pDxoso_f1B25-JKOxXpCGDM3oL7SHN7dD68Lcwl-iQaCRElLbQ1l7PvATVkHP5SOU5u6MqNHly6Eo";
        let user_uuid = "599CB2F2-3B1B-4F8D-A03B-2AE5510E63EB";
        var pusher = new Pusher("f88dc86a3f701150b191", {
            authEndpoint: uri,
            cluster: "us2",
            forceTLS: true,
            encrypted: true,
            auth: {
                headers: {
                    Authorization: "Bearer " + token
                }
            },
        });
        var channel = pusher.subscribe("private-channel.app.office.user." + user_uuid);

        channel.bind("Notify.User." + user_uuid, function(data) {
            alert(JSON.stringify(data));
        });
    </script>
@endsection
