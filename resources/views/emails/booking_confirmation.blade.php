<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
    <h2>Thank you for your booking, {{ $booking->first_name }}!</h2>
    <p>Your tennis consultation has been successfully booked.</p>
    <p><strong>Booking Details:</strong></p>
    <ul>
        <li><strong>Name:</strong> {{ $booking->first_name }} {{ $booking->last_name }}</li>
        <li><strong>Phone:</strong> {{ $booking->phone }}</li>
        <li><strong>Email:</strong> {{ $booking->email }}</li>
        <li><strong>Time Slot:</strong> {{ $booking->slot->time }}</li>
        <li><strong>Payment Method:</strong> {{ ucfirst($booking->payment_method) }}</li>
        <li><strong>Status:</strong> {{ ucfirst($booking->status) }}</li>
        <li><strong>Booking ID:</strong> {{ ucfirst($booking->id) }}</li>
    </ul>
    <p>We look forward to seeing you! </p>
</body>
</html>
