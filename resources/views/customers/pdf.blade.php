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
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->age }}</td>
                <td>{{ $customer->gender }}</td>
                <td>{{ $customer->phone }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
