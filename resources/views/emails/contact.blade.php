<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Enquiry</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; color: #333; line-height: 1.5;">
    <h2 style="margin-bottom: 4px;">New Contact Enquiry</h2>
    <p style="color: #777; margin-top: 0;">Submitted on {{ $contact->created_at->format('d M Y, h:i A') }}</p>

    <table cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;">
        <tr style="background: #f5f5f5;">
            <td style="font-weight: bold; width: 180px;">Full Name</td>
            <td>{{ $contact->full_name }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Company Name</td>
            <td>{{ $contact->company_name }}</td>
        </tr>
        <tr style="background: #f5f5f5;">
            <td style="font-weight: bold;">Category</td>
            <td>{{ $contact->category }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Email</td>
            <td>{{ $contact->email ?: '—' }}</td>
        </tr>
        <tr style="background: #f5f5f5;">
            <td style="font-weight: bold;">Phone Number</td>
            <td>{{ $contact->phone_number ?: '—' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; vertical-align: top;">Details</td>
            <td>{!! nl2br(e($contact->description)) !!}</td>
        </tr>
    </table>
</body>
</html>
