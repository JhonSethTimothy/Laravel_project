<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }} - FerbencomINVsystem</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; }
        .header h2 { margin: 0; font-size: 16px; font-weight: normal; }
        .header .date { margin-top: 5px; font-size: 12px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
        .footer { position: fixed; left: 0; bottom: -30px; right: 0; height: 30px; text-align: right; font-size: 12px; color: #888; }
        @page { margin: 60px 30px 60px 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FerbencomINVsystem</h1>
        <h2>{{ $title }}</h2>
        <div class="date">Date: {{ date('Y-m-d H:i') }}</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Date</th>
                <th>Serial Number</th>
                <th>Model</th>
                <th>Brand</th>
                <th>Item Description</th>
                <th>Quantity</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->date }}</td>
                <td>{{ $item->serial_number }}</td>
                <td>{{ $item->model }}</td>
                <td>{{ $item->brand }}</td>
                <td>{{ $item->item_description }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->remarks }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Page <span class="pagenum"></span>
    </div>
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('if ($PAGE_COUNT > 1) { $font = $fontMetrics->get_font("DejaVu Sans", "normal"); $size = 10; $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT; $pdf->text(500, 820, $pageText, $font, $size); }');
        }
    </script>
</body>
</html>
