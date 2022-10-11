@extends("mail.layouts.common")
@section("body")
<center class="wrapper soundblock">
    <div class="webkit soundblock">
        <table class="outer" align="center">
            <tr>
                <td>
                    <table width="100%" style="border-spacing: 0;">
                        <tr>
                            <td style="padding: 30px 20px;">
                                <x-head-line class="soundblock-email-headline" title="Please reset your password"/>
                                <x-p text="We heard that you lost your Arena Account password. Sorry about that!"/>
                                <x-p text="But don't worry! You can click the following button to reset your password:"/>
                                <x-p text="If you don't use this link within 15 mins, it will expire."/>
                                <p style="text-align: center;">
                                    <x-button class="soundblock-email-button" text="Reset Password" :link="$frontendUrl"/>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="background-color: black;text-align: center;border-top: solid 1px white;">
                    <table width="100%" style="border-spacing: 0;">
                        <tr>
                            <td>
                                <p style="font-size: 13px;color: white;">
                                    ARENA ACCOUNT
                                    2375 East Camelback Road, 6th Floor
                                    Phoenix, AZ  85016<br/>
                                    <a href="tel:6024669636"><font color="#ffffff"><span style='text-decoration:none;text-underline:none'>602-466-9636</span></font></a>,
                                    <a href="mailto:contact@soundblock.com"><font color="#ffffff"><span style='text-decoration:none;text-underline:none'>contact@soundblock.com</span></font></a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</center>
@endsection
