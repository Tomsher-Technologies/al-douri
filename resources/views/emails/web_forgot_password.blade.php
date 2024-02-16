<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    <meta http-equiv="Content-Type" content="text/html;" />
    <meta charset="UTF-8">
    <style media="all">
    @font-face {
        font-family: 'Roboto';
        src: url("{{ static_asset('fonts/Roboto-Regular.ttf') }}") format("truetype");
        font-weight: normal;
        font-style: normal;
    }

    * {
        margin: 0;
        padding: 0;
        line-height: 1.3;
        font-family: 'Roboto';
        color: #333542;
    }

    body {
        font-size: .875rem;
    }

    .gry-color *,
    .gry-color {
        color: #878f9c;
    }

    table {
        width: 100%;
    }

    table th {
        font-weight: normal;
    }

    table.padding th {
        padding: .5rem .7rem;
    }

    table.padding td {
        padding: .7rem;
    }

    table.sm-padding td {
        padding: .2rem .7rem;
    }

    .border-bottom td,
    .border-bottom th {
        border-bottom: 1px solid #eceff4;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .small {
        font-size: .85rem;
    }

    .currency {}
    </style>
</head>

<body>
    <div style="width: 60%;">
        <table border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff"
            style="border: 1px solid #d28a47;">
            <tbody>
                <tr>
                    <td width="650" align="center" valign="middle">
                        <table border="0" align="center" cellpadding="0" cellspacing="0" style="background:#fff;">
                            <tbody>
                                <tr>
                                    <td width="658" align="center" valign="middle">
                                        <div align="center" style="display: inline; margin: 0; width: 208px">
                                            <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="208" align="center" valign="middle">
                                                            <a href="{{ env('APP_URL') }}" target="_blank">
                                                                <img src="{{ asset('assets/img/logo.png') }}"
                                                                    alt="{{ env('APP_NAME') }}"
                                                                    title="{{ env('APP_NAME') }}" style="display: block;margin-top: 5px;margin-bottom: 5px;" width="222" ></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div align="left" style="float: left; display: inline; margin: 0; width: 217px">
                                            <table border="0" align="left" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="217" align="center" valign="middle">
                                                            
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                       
                        <table border="0" align="center" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td width="20" bgcolor="#FFFFFF">&nbsp;</td>
                                    <td colspan="7" bgcolor="#FFFFFF"
                                        style="font-family: Arial, Helvetica, sans-serif; font-size: 14px"><br>
                                        
                                        You have submitted a password change request.
                                        <br><br>
                                        If it wasn't you please ignore this email and make sure you can still login
                                        to your account, If it was you, then change your password by using the
                                        verification code bellow.
                                        <br><br>
                                        <div align="center" bgcolor="#06b2f4f2" style="border-radius: 28px; font-size: 25px;font-weight: bold;" height="51">
                                            <span style="border: 2px solid black;border-radius: 30px;padding: 0% 4% 0%;">
                                                {{ $user->verification_code }}
                                            </span>
                                        </div>
                                                <br>
                                        <p><b>
                                            Warm regards,
                                            <br />
                                            {{ env('APP_NAME') }} Customer Support Team</b>
                                        </p>
                                    </td>
                                    <td width="20" bgcolor="#FFFFFF">&nbsp;</td>
                                </tr>
                                <tr align="center">
                                    <td width="33" rowspan="3" bgcolor="#FFFFFF">&nbsp;</td>
                                    <td>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table border="0" align="center" cellpadding="0" cellspacing="0"
                            style="background-color: #d28a47">
                            <tbody>
                                <tr>
                                    <td width="648" align="center" valign="middle" style="text-align: center">
                                        <span style="font-family: Arial, sans-serif; font-size: 12px; color: white;">©
                                            2023 {{ env('APP_NAME') }}. All Rights Reserved.</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="648" height="5" align="center" valign="middle"
                                        style="text-align: center">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>