<!DOCTYPE html>
<html>
<head>
    <title>Bookings Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #333;
            padding: 4px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Bookings Report</h2>
    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Car Brand</th>
                <th>Car Model</th>
                <th>License Plate</th>
                <th>Booked At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->customer->name }}</td>
                <td>{{ $booking->car_brand }}</td>
                <td>{{ $booking->car_model }}</td>
                <td>{{ $booking->license_plate }}</td>
                <td>{{ $booking->booked_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
