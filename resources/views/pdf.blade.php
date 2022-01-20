<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            font-size: 14px;
        }
        table th {
            text-align: left;
            background: #cccccc;
        }
        table th,
        table td, {
            border: 1px solid #000000;
            padding: 4px;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td style="border: none" colspan="2">
                    <div style="font-size: 12px; text-align: right">Date of report: {{ date("d M Y") }}</div>
                </td>
            </tr>
        </thead>
        <thead>
            <tr>
                <th>Head 1</th>
                <th>Head 2</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < 50; $i++)
                <tr>
                    <td>Body {{ $i }}</td>
                    <td>Body {{ $i }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>