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
    <h2>Available Parking Spaces</h2>
    <table>
        <thead>
            <tr>
                <th>Bldg. Floor No.</th>
                <th>Lot. No</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($spaces as $space)
            <tr>
                <td>{{ $space->bldg_floor_no }}</td>
                <td>{{ $space->lot_no }}</td>
                <td>{{ $space->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
