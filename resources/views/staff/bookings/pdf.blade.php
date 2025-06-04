<!DOCTYPE html>
<html>
<head>
    <title>Customers List</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 4px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Customers List</h2>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Parking Space</th>
                <th>License Plate</th>
                <th>Booked At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->customer->name }}</td>
                <td>Floor {{ $booking->space->bldg_floor_no }} - Lot {{ $booking->space->lot_no }}</td>
                <td>{{ $booking->license_plate }}</td>
                <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
