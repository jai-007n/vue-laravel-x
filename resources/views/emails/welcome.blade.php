<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome Email</title>
</head>

<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6;padding:40px 0;">
    <tr>
        <td align="center">

            <!-- Main Container -->
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:10px;overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td style="background:#4f46e5;padding:30px;text-align:center;color:#ffffff;">
                        <h1 style="margin:0;font-size:24px;">
                            Welcome, {{ $user->name }} 🎉
                        </h1>
                        <p style="margin:8px 0 0;font-size:14px;">
                            We're excited to have you on board
                        </p>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px;color:#111827;">

                        <h2 style="font-size:18px;margin-bottom:10px;">
                            You're all set!
                        </h2>

                        <p style="font-size:14px;line-height:1.6;color:#4b5563;">
                            Hi <strong>{{ $user->name }}</strong>,<br><br>
                            Thanks for joining our platform. Your account has been successfully created and you can now explore everything we offer.
                        </p>

                        <!-- Button -->
                        <table cellspacing="0" cellpadding="0" style="margin:25px auto;">
                            <tr>
                                <td align="center" bgcolor="#4f46e5" style="border-radius:6px;">
                                    <a href="{{ url('/dashboard') }}"
                                       style="display:inline-block;padding:12px 20px;color:#ffffff;text-decoration:none;font-weight:bold;font-size:14px;">
                                        Go to Dashboard
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <!-- Tip Box -->
                        <table width="100%" style="background:#f9fafb;padding:15px;border-radius:6px;">
                            <tr>
                                <td style="font-size:13px;color:#6b7280;">
                                    🚀 Tip: Complete your profile to get the best experience.
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="text-align:center;padding:20px;font-size:12px;color:#9ca3af;background:#f9fafb;">
                        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>