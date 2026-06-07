<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Job Application</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f5f7; font-family: Arial, Helvetica, sans-serif; color: #1a1f36; line-height: 1.5;">

    <!-- Outer wrapper -->
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f5f7; padding: 32px 12px;">
        <tr>
            <td align="center">

                <!-- Card -->
                <table role="presentation" cellpadding="0" cellspacing="0" width="600" style="width: 600px; max-width: 100%; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 4px rgba(26,31,54,0.08);">

                    <!-- Brand header -->
                    <tr>
                        <td style="background-color: #B11E2E; padding: 24px 32px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="font-size: 20px; font-weight: bold; letter-spacing: 0.5px; color: #ffffff;">
                                        INFOTECH<span style="color: #f5c1c6;">.WORKS</span>
                                    </td>
                                    <td align="right" style="font-size: 12px; color: #f7d4d8; text-transform: uppercase; letter-spacing: 1px;">
                                        New Application
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td style="padding: 32px 32px 8px 32px;">
                            <h1 style="margin: 0; font-size: 22px; color: #1a1f36;">New Job Application</h1>
                            <p style="margin: 6px 0 0 0; color: #6b7280; font-size: 13px;">
                                Submitted on {{ $jobResponse->created_at->format('d M Y, h:i A') }}
                            </p>
                        </td>
                    </tr>

                    @if ($jobTitle)
                    <!-- Applied position highlight -->
                    <tr>
                        <td style="padding: 8px 32px 0 32px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background: #fdf2f3; border: 1px solid #f3d3d6; border-radius: 8px;">
                                <tr>
                                    <td style="padding: 14px 16px;">
                                        <span style="display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #B11E2E; font-weight: bold;">Applied Position</span>
                                        <span style="display: block; margin-top: 4px; font-size: 16px; color: #1a1f36; font-weight: bold;">{{ $jobTitle }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @endif

                    <!-- Details -->
                    <tr>
                        <td style="padding: 16px 32px 8px 32px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: separate; border-spacing: 0; border: 1px solid #eceef1; border-radius: 8px; overflow: hidden;">
                                <tr style="background: #fafbfc;">
                                    <td style="padding: 12px 16px; font-weight: bold; width: 170px; color: #6b7280; font-size: 13px; border-bottom: 1px solid #eceef1;">Full Name</td>
                                    <td style="padding: 12px 16px; color: #1a1f36; font-size: 14px; border-bottom: 1px solid #eceef1;">{{ $jobResponse->full_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; font-weight: bold; color: #6b7280; font-size: 13px; border-bottom: 1px solid #eceef1;">Email</td>
                                    <td style="padding: 12px 16px; font-size: 14px; border-bottom: 1px solid #eceef1;">
                                        <a href="mailto:{{ $jobResponse->email }}" style="color: #B11E2E; text-decoration: none;">{{ $jobResponse->email ?: '—' }}</a>
                                    </td>
                                </tr>
                                <tr style="background: #fafbfc;">
                                    <td style="padding: 12px 16px; font-weight: bold; color: #6b7280; font-size: 13px;">Phone Number</td>
                                    <td style="padding: 12px 16px; color: #1a1f36; font-size: 14px;">{{ $jobResponse->phone_number ?: '—' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CTA -->
                    <tr>
                        <td style="padding: 16px 32px 28px 32px;">
                            <a href="mailto:{{ $jobResponse->email }}"
                               style="display: inline-block; background-color: #B11E2E; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: bold; padding: 12px 24px; border-radius: 8px;">
                                Reply to {{ $jobResponse->full_name }} &rarr;
                            </a>
                            <p style="margin: 14px 0 0 0; color: #6b7280; font-size: 12px;">
                                The applicant's CV is attached to this email.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1a1f36; padding: 20px 32px; text-align: center;">
                            <p style="margin: 0; color: #9aa0b4; font-size: 12px;">
                                &copy; {{ $jobResponse->created_at->format('Y') }} Infotech.Works. Transforming Ideas into Digital Reality.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- /Card -->

            </td>
        </tr>
    </table>

</body>
</html>
