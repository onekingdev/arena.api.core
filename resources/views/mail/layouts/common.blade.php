<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>HTML Email</title>
        <style type="text/css">
            body {
                margin: 0;
                padding:0;
                background-color: #f6f9fc;
            }
            p {
                line-height: 1.8;
            }
            a {
                font-size: 14px;
                text-decoration: none;
                cursor: pointer;
                color: white;
            }
            a.span.link {
                font-size: 14px;
                text-decoration: none;
                cursor: pointer;
                color: white;
            }
            a.arena {
                transition: all 0.3s ease;
                -webkit-transition: all 0.3s ease;
                -moz-transition: all 0.3s ease;
                -o-transition: all 0.3s ease;
            }
            a.apparel {
                font-size: 13px;
                color: #518DC9;
                transition: all 0.3s ease;
                -webkit-transition: all 0.3s ease;
                -moz-transition: all 0.3s ease;
                -o-transition: all 0.3s ease;
            }
            span.apparel-email-subject {
                font-size: 20px;
                font-weight: bold;
                margin-left: 20px;
            }
            img {
                border: 0;
            }
            table {
                border-spacing: 0;
            }
            td {
                padding: 0;
            }
            .wrapper {
                width: 100%;
                table-layout: fixed;
                padding-bottom: 40px;
            }
            .wrapper.soundblock {
                background-color: #f6f9fc;
                padding-bottom: 40px;
            }
            .wrapper.arena {
                background-color: #fafafa;
            }
            .wrapper.apparel {
                background-color: #fafafa;
            }
            .webkit {
                max-width: 600px;
                background-color: #ffffff;
            }
            .outer {
                Margin: 0 auto;
                width: 100%;
                max-width: 600px;
                border-spacing: 0;
                font-family: sans-serif;
                color: #4a4a4a;
            }
            .font-book {
                font-family: itc-avant-garde-gothic-pro, sans-serif;
                font-weight: 300;
                font-style: normal;
            }
            .font-bold {
                font-family: itc-avant-garde-gothic-pro, sans-serif;
                font-weight: 700;
                font-style: normal;
            }
            .font-medium {
                font-family: itc-avant-garde-gothic-pro, sans-serif;
                font-weight: 500;
                font-style: normal;
            }
            h2.headline {
                text-align: center;
            }
            .black {
                color: black;
            }
            .soundblock-email-headline {
                color: #518dc9;
            }
            .apparel-email-headline {
                color: black;
            }
            button {
                padding: 10px 20px;
                outline: none;
                border-width: 0;
            }
            button.soundblock-email-button {
                background: linear-gradient(90deg, #518dc9 0%, #782c7f 100%);
                border-radius: 7px;
            }
            a.soundblock-email-button {
                padding: 10px 20px;
                outline: none;
                border-width: 0;
                background: linear-gradient(90deg, #518dc9 0%, #782c7f 100%);
                border-radius: 7px;
            }
            button.apparel-email-button {
                background: red;
            }
            button.arena-email-button {
                background: #2e9887;
            }
            button a {
                font-size: 16px;
            }
            .soundblock-logo-side {
                background-color: black;
                padding: 10px;
                vertical-align: top;
            }

            .footer {
                padding: 20px 0;
            }
            .footer .column {
                width: 100%;
                max-width: 290px;
                display: inline-block;
                vertical-align: top;
                border-spacing: 0;
            }
            .footer .content {
                width: 100%;
            }
            /* apparel */
            .padding {
                padding: 0 15px;
            }
        </style>
    </head>
        <body>
            @yield("body")
        </body>
</html>
