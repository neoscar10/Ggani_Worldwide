<!DOCTYPE html>
<html>
<head>
    <title>Appointment Reminder</title>
</head>
<body>
    <p>Dear {{ $booking->first_name }},</p>
    <p>This is a reminder for your upcoming appointment scheduled for {{ $booking->slot->slot_datetime }}.</p>
    <p>If you have any questions, feel free to reach out.</p>
    <p>Best regards,<br>Ggani-Worldwide Team</p>
</body>
</html>
