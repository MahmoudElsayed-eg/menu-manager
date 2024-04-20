<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<style>
    body {
        text-align: center;
        width: 72mm;
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

    p,
    td {
        display: block;
        font-size: 4mm;
        margin-top: 0;
        margin-bottom: 0;
        margin-left: 0;
        margin-right: 0;
    }

    #xd th {
        padding: 2mm;
        border: 0.5mm solid black;
        font-weight: 500
    }

    #xd td {
        font-size: 2.5mm;
        border: 0.5mm solid black;
        padding: 1mm;
    }

    #xf td {
        font-size: 3.2mm;

    }
</style>

<body dir="rtl">
    <img src="D:\menu_manager\storage\app\public\images\1.jpg"
        style="width: 65mm; margin-left: auto; margin-right: auto;">
    <p style="margin-top: 2mm;">{{ $branch }}</p>
    <table style="width: 65mm; margin-left: auto; margin-right: auto;">
        <tbody>
            <tr>
                <td style="width: 45%">
                    الطاولة : {{ $tableName }}
                </td>
                <td style="width: 55%">
                    التاريخ : {{ $date }}
                </td>
            </tr>
            <tr>
                <td style="width: 45%">
                    الفاتورة : {{ $receiptId }}
                </td>
                <td style="width: 55%">
                    الوقت : {{ $time }}
                </td>
            </tr>
        </tbody>
    </table>
    <p style="width:63mm; margin-left: auto; margin-right: auto; text-align: start; margin-bottom: 2mm">الكاشير :
        {{ $cashier }}</p>
    <table id="xd" style="width: 65mm; margin-left: auto; margin-right: auto; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #c5c5c5; text-align: center;">
                <th>
                    الصنف
                </th>
                <th>
                    عدد
                </th>
                <th>
                    السعر
                </th>
                <th>
                    إجمالي
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $tableData)
                <tr>
                    <td>{{ $tableData->name }}</td>
                    <td>{{ $tableData->amount }}</td>
                    <td>{{ number_format($tableData->price, 2) }}</td>
                    <td>{{ number_format($tableData->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table id="xf"
        style="width: 50%; margin-top: 2mm;  border-collapse: collapse;margin-right: auto;margin-left: auto">
        <tbody>
            <tr>
                <td style="text-align: left;width: 50%;">
                    إجمالي :
                </td>
                <td style="width: 50%;">
                    {{ number_format($totalPrice, 2) }}
                </td>
            </tr>
            <tr>
                <td style="text-align: left;width: 50%;">
                    خدمة % :
                </td>
                <td style="width: 50%;">
                    {{ number_format($serviceRate, 2) }}
                </td>
            </tr>
            <tr>
                <td style="text-align: left;width: 50%;">
                    توصيل :
                </td>
                <td style="width: 50%;">
                    {{ number_format($delivery, 2) }}
                </td>
            </tr>
            <tr style="padding-bottom: 1mm;">
                <td style="text-align: left;width: 50%;">
                    ضريبة % :
                </td>
                <td style="width: 50%;">
                    {{ number_format($taxRate, 2) }}
                </td>
            </tr>
            <tr>
                <td style="text-align: left;width: 50%; border-bottom: 0.2mm solid black">
                </td>
                <td style="width: 50%;border-bottom: 0.2mm solid black">
                </td>
            </tr>
            <tr>
                <td style="text-align: left;width: 50%; border-bottom: 0.2mm solid black">
                </td>
                <td style="width: 50%;border-bottom: 0.2mm solid black">
                </td>
            </tr>

        </tbody>
    </table>
    <table style="width: 65mm;margin-top: 2mm; margin-right:auto; margin-left: auto;  border-collapse: collapse; font-weight: bold;">
        <tbody>
            <tr>
                <td style="text-align: left;width: 50%;  font-size: 4.1mm; ">
                    المبلغ المطلوب :
                </td>
                <td style="width: 50%;">
                    {{ number_format($sumPay, 2) }}
                </td>
            </tr>
        </tbody>
    </table>
    <p style="height: 5mm"></p>
    <p>.</p>
</body>

</html>
