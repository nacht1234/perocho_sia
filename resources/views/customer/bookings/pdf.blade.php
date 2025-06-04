<!DOCTYPE html>
<html>
<head>
    <title>Available Parking Spaces</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 4px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>My Bookings</h2>
    <table>
        <thead>
            <tr>
                <th>Floor</th>
                <th>Lot</th>
                <th>Car</th>
                <th>Plate</th>
                <th>Booking Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->space->bldg_floor_no }}</td>
                <td>{{ $booking->space->lot_no }}</td>
                <td>{{ $booking->car_brand }} {{ $booking->car_model }}</td>
                <td>{{ $booking->license_plate }}</td>
                <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
