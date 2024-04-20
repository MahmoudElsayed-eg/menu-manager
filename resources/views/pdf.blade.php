<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<style>
    body {
        text-align: center;
    }

    h1 {
        display: block;
        font-size: 5mm;
        margin-top: 0;
        margin-bottom: 5mm;
        margin-left: 0;
        margin-right: 0;
        font-weight: bold;
    }

    p {
        display: block;
        font-size: 4mm;
        margin-top: 0;
        margin-bottom: 0;
        margin-left: 0;
        margin-right: 0;
    }
</style>

<body>
    <h1>{{ $group }}</h1>
    <p style="margin-bottom: 2mm">الطاولة : {{ $tableName }}</p>
    @foreach ($data as $tableData)
        <p>
            <span>{{ $tableData->name }}</span>
            <span style="font-size: xx-small">x</span>
            <span style="font-weight: bold">{{ $tableData->amount }}</span>
        </p>
    @endforeach

    <p style="font-size: 3mm; margin-left: 3mm; text-align: end">{{ $date }}</p>

</body>

</html>
