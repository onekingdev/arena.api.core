@extends("mail.layouts.common")

@section("body")
<center class="wrapper soundblock">
    <div class="webkit soundblock" style="word-break: break-all;">
        <table class="outer" align="center" width="100%" style="border-spacing: 0;">
            <thead>
                <tr>
                    <td style="align-items: end; padding: 5px 5px;">
                        <img style="float: left;max-width: 50%; width: 25%" src="https://soundblock.com/wp-content/uploads/2019/04/soundblock-logo.png" width="80" alt="Soundblock Logo">
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 30px 20px;">
                        @yield("content")
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr align="center">
                    <td colspan="2">
                        <p style="font-size: 13px;color: black;">
                            SOUNDBLOCK, LLC &bull;
                            2375 East Camelback Road &bull; 6th Floor &bull;
                            Phoenix &bull; AZ &bull; 85016<br/>
                            <a href="tel:6024669636"><font color="#ffffff"><span style='text-decoration:none;text-underline:none'>602-466-9636</span></font></a>,
                            <a href="mailto:contact@soundblock.com"><font color="#ffffff"><span style='text-decoration:none;text-underline:none'>contact@soundblock.com</span></font></a>
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</center>
@endsection
