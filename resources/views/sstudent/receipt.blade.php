<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees Receipt - {{ $sstudent->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .school-name {
            font-size: 24px;
            font-weight: bold;
        }
        .receipt-title {
            font-size: 18px;
            margin-top: 10px;
        }
        .student-info {
            margin-bottom: 20px;
        }
        .student-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .student-info td {
            padding: 5px;
        }
        .fees-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .fees-table th, .fees-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .fees-table th {
            background-color: #f0f0f0;
        }
        .totals {
            text-align: right;
            margin-bottom: 20px;
        }
        .print-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .print-btn:hover {
            background-color: #0056b3;
        }
        @media print {
            .print-btn {
                display: none;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">School Management System</div>
        <div class="receipt-title">Fees Receipt</div>
    </div>

    <div class="student-info">
        <table>
            <tr>
                <td><strong>Student Name:</strong> {{ $sstudent->name }}</td>
                <td><strong>Class:</strong> {{ $sstudent->class->c_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Father's Name:</strong> {{ $sstudent->father_name ?? 'N/A' }}</td>
                <td><strong>Mobile:</strong> {{ $sstudent->mobile ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong> {{ $sstudent->email ?? 'N/A' }}</td>
                <td><strong>Receipt Date:</strong> {{ date('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="fees-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Fees Submitted</th>
                <th>Extra Discount</th>
                <th>Remaining</th>
            </tr>
        </thead>
        <tbody>
            @php $remainingLoop = $totalClassFee; @endphp
            @foreach ($sstudent->fees->sortBy('date_of_submitted') as $fee)
                @php
                    $remainingLoop -= ($fee->fees_submitted + ($fee->extra_discount ?? 0));
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($fee->date_of_submitted)->format('d/m/Y') }}</td>
                    <td>₹{{ number_format($fee->fees_submitted, 2) }}</td>
                    <td>{{ $fee->extra_discount ? '₹' . number_format($fee->extra_discount, 2) : '—' }}</td>
                    <td>₹{{ number_format(max($remainingLoop, 0), 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p><strong>Total Class Fee:</strong> ₹{{ number_format($totalClassFee, 2) }}</p>
        <p><strong>Total Paid:</strong> ₹{{ number_format($totalPaid, 2) }}</p>
        <p><strong>Remaining:</strong> ₹{{ number_format($remaining, 2) }}</p>
        <p><strong>Status:</strong> {{ $remaining > 0 ? 'Pending' : 'Paid' }}</p>
    </div>

    <button class="print-btn" onclick="window.print()">Print Receipt</button>

    <script>
        // Auto print on load if desired, but for now manual
        // window.onload = function() { window.print(); };
    </script>
</body>
</html>
