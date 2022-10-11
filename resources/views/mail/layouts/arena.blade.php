@extends('mail.layouts.common')

@section('body')
<center class="wrapper arena">
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
                                @yield('content')
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px;text-align: center;">
                                @section("button")
                                @show
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
                                                        <p><a class="arena" href="tel:6024669636"><font color="#ffffff"><span style='text-decoration:none;text-underline:none'>602-466-9636</span></font></a><br/>
                                                            <a class="arena" href="mailto:contact@arena.com"><font color="#ffffff"><span style='text-decoration:none;text-underline:none'>contact@arena.com</span></font></a>
                                                        </p>
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
@endsection
