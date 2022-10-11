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
        table {
            border-spacing: 0;
        }
        td {
            padding: 0;
        }
        img {
            border: 0;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f6f9fc;
            padding-bottom: 40px;
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
        a {
            font-size: 14px;
            text-decoration: none;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
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
        .padding {
            padding: 0 15px;
        }
        .footer .content {
            width: 100%;
        }
        p {
            line-height: 1.8;
        }
        button {
            background: #2e9887;
            padding: 10px 20px;
            outline: none;
            border-width: 0;
        }
        button a {
            font-size: 16px;
        }
    </style>
</head>

<body>
    <center class="wrapper">
        <div class="webkit">
            <table class="outer" align="center">
                <tr>
                    <td>
                        <table width="100%" style="border-spacing: 0;">
                            <tr>
                                <td style="background: black;padding: 10px;text-align: center;">
                                    <a href="https://soundblock.com"><img src="{{asset('storage/logo/apparel-logo.png')}}" width="180" alt="Logo" title="Logo"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 20px 0;background-color: #ffffff;">
                        <table width="100%" style="border-spacing: 0;">
                            <tr>
                                <td style="padding: 10px 20px;">
                                    <h2 style="color: black;text-align: center;">Welcome to Arena Apparel</h2>
                                    <p>We seek out the best factories in each product specialty and may interview up to fifty factories before selecting one to make our products.</p>
                                    <p>A factory visit is mandatory, during which expectations of our Code of Conduct are discussed including our requirement to cascade this through their supply chain. We do not at this early stage in the relationship expect the company to name all of their suppliers, but through raising the subject, we aim to gauge their level of future cooperation.</p>
                                    <p>Available capacity is also key to this conversation. It is important that we gain insight into their production planning for us to understand how they can accommodate any new business without the need for overtime and subcontracting.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px;text-align: center;">
                                    <button><a>Sign In</a></button>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: black;">
                        <table width="100%" style="border-spacing: 0;">
                            <tr>
                                <td class="footer">
                                    <table class="column">
                                        <tr>
                                            <td class="padding">
                                                <table class="content">
                                                    <tr>
                                                        <td>
                                                            <p style="font-size: 14px;color: white;font-weight: bold;">
                                                                Arena Merchandising LLC<br/>
                                                                21430 North 2nd Ave, STE 2<br/>
                                                                Phoenix, AZ 85027, USA
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="column">
                                        <tr>
                                            <td class="padding">
                                                <table class="content">
                                                    <tr>
                                                        <td>
                                                            <p><a href="tel:6024669636">602-466-9636</a><br/><a href="mailto:contact@soundblock.com">contact@arenamerch.com</a></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>


                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>
</body>

</html>
