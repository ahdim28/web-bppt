<html>
<body>

    <table border="1">
        <thead>
            <tr>
                <th colspan="{{ $inquiry->inquiryField->count()+3 }}" style="text-align: center; height:20px;">
                    <h1>{{ strtoupper($inquiry->fieldLang('name')) }}</h1>
                </th>
            </tr>
            <tr>
                <th style="width: 5px;">NO</th>
                <th style="width: 25px;">IP Address</th>
                @foreach ($inquiry->inquiryField()->get() as $item)
                <th style="width: 35px;">{{ $item->fieldLang('label') }}</th>
                @endforeach
                <th style="width: 30px;">Submit Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($form as $key => $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->ip_address }}</td>
                @foreach ($inquiry->inquiryField()->get() as $field)
                <td>
                    {!! preg_replace("/[^a-zA-Z0-9]/", " ", $item->fields[$field->name]) !!}
                </td>
                @endforeach
                <td>{!! $item->submit_time->format('d F Y (H:i)') !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>