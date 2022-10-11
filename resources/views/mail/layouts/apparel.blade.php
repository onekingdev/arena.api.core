@extends('mail.layouts.common')

<center class="wrapper apparel">
    <div class="webkit">
        <table class="outer" align="center">
            <tr>
                <td>
                    <table width="100%" style="border-spacing: 0;  color: #4a4a4a;">
                        <tr>
                            <td style="background: #fafafa;padding: 10px;text-align: center; ">
                                <div style="display: flex;align-items: center;">
                                    <img src="https://static1.squarespace.com/static/5e8917fb89409916f6ed849a/t/5e892567d84e09477ee816c0/1587512634219/?format=1500w" width="70" alt="Logo" title="Logo">
                                    <x-subject subject="Tour Mask"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td style="padding: 10px 0 30px 0;background-color: #ffffff;border: solid 1px #dfe0e2;border-radius: 3px;">
                    <table width="100%" style="border-spacing: 0;">
                        <tr>
                            <td style="padding: 20px;">
                                @yield('content')
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px;text-align: center;">
                                @section('button')
                                @show
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="background-color: #fafafa;">
                    <table width="100%" style="border-spacing: 0; text-align: center;">
                        <tr>
                            <td style="padding: 20px 15px;">
                                <p style="font-size: 13px;color: #b6b6b6;font-weight: bold;">Arena Merchandising LLC<br/>21430 North 2nd Ave, STE 2<br/>Phoenix, AZ 85027, USA</p>
                                <p><a class="apparel" href="tel:6024669636"><font color="#518DC9"><span style='text-decoration:none;text-underline:none'>602-466-9636</span></font></a><br/>
                                    <a class="apparel" href="mailto:contact@arenamerch.com"><font color="#518DC9"><span style='text-decoration:none;text-underline:none'>contact@arenamerch.com</span></font></a>
                                </p>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</center>
