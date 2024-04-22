<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Expermint Bill</title>
    <style>
        @font-face {
            font-family: 'Sahel';
            src: url({{ storage_path('fonts\Sahel.ttf') }}) format("truetype");
            font-weight: 300; // use the matching font-weight here ( 100, 200, 300, 400, etc).
            font-style: normal; // use the matching font-style here
        }
        body {
            font-family: 'Sahel', Calibri, sans-serif;
            font-size: 12;
            margin-top: 200px;
            margin-bottom: 50px
        }

        table{
            width: 100%
        }

        td, th {
            vertical-align: top;
            text-align: left;
            border: 1px solid;
        }

    </style>
</head>
<body>
    <table>
        <tr>
            <td> {{__('lab.lab_expRecord_no')}} : {{$experiment->record_no}} </td>
            <td> {{__('reception.pat_name')}} : ({{$experiment->patient->record_no}}) {{$experiment->patient->name}} </td>
            <td> {{__('reception.pat_age')}} : {{$experiment->patient->age}} </td>
        </tr>
        <tr>
            <td> {{__('reception.vis_doctors')}} : {{$experiment->doctor->name}} </td>
            <td> {{__('reception.sex')}} : {{$experiment->patient->sex}} </td>
            <td> {{__('global.date')}} : {{$experiment->created_at->format('Y-m-d g:s A')}}</td>
        </tr>
    </table>

    <table cellspacing="0" cellpadding="3">
        <tr>
            <th width="30%">Description</th>
            <th width="40%">Reference Range</th>
            <th width="30%">Patient Value</th>
        </tr>
        @foreach($experiment->tests as $key => $test)
            <tr>
                <td> {{$test->name}} </td>
                <td colspan="2"> {!! $test->pivot->results !!} </td>
                {{-- <td>' .nl2br(substr($test->pivot->description, 1)). '</td> --}}
            </tr>
        @endforeach
    </table>
</body>
</html>