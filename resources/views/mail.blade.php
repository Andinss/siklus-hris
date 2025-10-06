<html>

<head>
    <meta charset="text/html">
</head>

<body>
    {{-- {{ $body }} --}}
    <table style="border-collapse: collapse; width: 100%; text-align: center">
        <thead>
            <tr>
                <th>Username</th>
                <th>First Name</th>
                <th>Lastname</th>
                <th>Access</th>
                <th>Acitivy</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($body))
                @foreach ($body as $key => $value)
                    <tr>
                        <td>{{ $value->username }}</td>
                        <td>{{ $value->first_name }}</td>
                        <td>{{ $value->last_name }}</td>
                        <td>{{ $value->role }}</td>
                        <td>{{ $value->desc }}</td>
                        <td>{{ date('d M Y H:i:s', strtotime($value->date)) }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>

</html>
