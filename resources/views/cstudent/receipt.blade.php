  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees Receipt - {{ $cstudent->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        body {
            font-family: 'Times New Roman', serif;
            max-width: 190mm;
            margin: 0 auto;
            padding: 15mm;
            color: #000;
            line-height: 1.4;
            font-size: 12pt;
            background: white;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .school-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .receipt-title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 5px;
            color: #333;
        }
        .student-info {
            margin-bottom: 25px;
            background: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .student-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .student-info td {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .student-info td:first-child {
            font-weight: bold;
            width: 40%;
        }
        .subjects-section {
            margin-bottom: 25px;
        }
        .subjects-section h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            text-decoration: underline;
            color: #333;
        }
        .fees-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .fees-table th, .fees-table td {
            border: 1px solid #000;
            padding: 10px 8px;
            vertical-align: middle;
        }
        .fees-table th {
            text-align: center;
        }
        .fees-table td:first-child {
            font-weight: 500;
        }
        .fees-table td:nth-child(2) {
            text-align: center;
        }
        .fees-table td:nth-child(n+3) {
            text-align: right;
        }
        .fees-table th {
            background-color: #e8e8e8;
            font-weight: bold;
            text-align: center;
            font-size: 11pt;
        }
        .fees-table td {
            font-size: 11pt;
        }
        .fees-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .fees-table .totals {
            background-color: #fff3cd !important;
            font-weight: bold;
            font-size: 12pt;
        }
        .fees-table .totals td {
            border: 2px solid #000;
            padding: 12px 8px;
        }
        .fees-table .totals td:first-child {
            text-align: right;
            padding-right: 20px;
        }
        .print-btn {
            display: block;
            margin: 30px auto;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: background-color 0.3s;
        }
        .print-btn:hover {
            background-color: #0056b3;
        }
        @media print {
            body {
                margin: 0;
                padding: 10mm;
                max-width: none;
            }
            .print-btn {
                display: none;
            }
            .fees-table {
                box-shadow: none;
            }
            .student-info {
                background: white;
                box-shadow: none;
            }
            .signature-section {
                border-top: 1px solid #000;
            }
            .signature-section p {
                margin-bottom: 8px;
            }
        }
        @media screen and (max-width: 768px) {
            body {
                padding: 10mm 5mm;
            }
            .fees-table th, .fees-table td {
                padding: 6px 4px;
                font-size: 10pt;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">Competition Management System</div>
        <div class="receipt-title">Fees Receipt</div>
    </div>

    <div class="student-info">
        <table>
            <tr>
                <td><strong>Student Name:</strong> {{ $cstudent->name }}</td>
                <td><strong>Competition Level:</strong> {{ ucfirst($cstudent->competition_level) }}</td>
            </tr>
            <tr>
                <td><strong>Father's Name:</strong> {{ $cstudent->father_name ?? 'N/A' }}</td>
                <td><strong>Mobile:</strong> {{ $cstudent->mobile ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong> {{ $cstudent->email ?? 'N/A' }}</td>
                <td><strong>Receipt Date:</strong> {{ date('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <div class="subjects-section">
        <h3>Fees Payment History</h3>
        <table class="fees-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Fees Submitted</th>
                    <th>Extra Discount</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($allPayments as $payment)
                    <tr>
                        <td>{{ $payment['subject'] }}</td>
                        <td>{{ $payment['date'] ? \Carbon\Carbon::parse($payment['date'])->format('d/m/Y') : 'N/A' }}</td>
                        <td style="text-align: right;">₹{{ number_format($payment['fees_submitted'], 2) }}</td>
                        <td style="text-align: right;">{{ $payment['extra_discount'] ? '₹' . number_format($payment['extra_discount'], 2) : '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No payments recorded</td>
                    </tr>
                @endforelse
                <tr class="totals">
                    <td colspan="3"><strong>Total Fees (All Subjects):</strong></td>
                    <td style="text-align: right;"><strong>₹{{ number_format($totalFees, 2) }}</strong></td>
                </tr>
                <tr class="totals">
                    <td colspan="3"><strong>Total Paid:</strong></td>
                    <td style="text-align: right;"><strong>₹{{ number_format($totalPaid, 2) }}</strong></td>
                </tr>
                <tr class="totals">
                    <td colspan="3"><strong>Remaining Balance:</strong></td>
                    <td style="text-align: right;"><strong>₹{{ number_format($remaining, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="signature-section" style="margin-top: 50px; text-align: right; border-top: 1px solid #ddd; padding-top: 20px;">
        <p style="margin-bottom: 10px; font-weight: bold;">Authorized Signature</p>
        <p style="margin-bottom: 5px; font-size: 14pt;">________________________</p>
        <p style="margin-top: 5px; font-weight: bold;">{{ $user->name ?? 'Administrator' }}</p>
    </div>

    <button class="print-btn" onclick="window.print()">Print Receipt</button>

    <script>
        // Auto print on load if desired, but for now manual
        // window.onload = function() { window.print(); };
    </script>
</body>
</html>
