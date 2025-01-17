<!DOCTYPE html>
<html>
<head>
    <title>Approved Part Data</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
            word-wrap: break-word;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .export-date {
            text-align: right;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Data exported from the system</p>
    <div class="export-date">Export Date: {{ $exportDate }}</div>
    <table>
        <thead>
            <tr>
                <th>Tgl Sortir</th>
                <th>Part Number</th>
                <th>Lot Number</th>
                <th>Jenis Problem</th>
                <th>Metode Sortir/Rework</th>
                <th>Line</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Total Waktu (Detik)</th>
                <th>Total Waktu (Hari, Jam, Menit, Detik)</th>
                <th>PIC</th>
                <th>Total Check</th>
                <th>Total OK</th>
                <th>Total NG</th>
                <th>Tgl Ambil</th>
                <th>Target Selesai</th>
                <th>Remark</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row['tanggal_sortir'] }}</td>
                    <td>{{ $row['part_number'] }}</td>
                    <td>{{ $row['lot_number'] }}</td>
                    <td>{{ $row['jenis_problem'] }}</td>
                    <td>{{ $row['metode_sortir_rework'] }}</td>
                    <td>{{ $row['line'] }}</td>
                    <td>{{ $row['waktu_mulai'] }}</td>
                    <td>{{ $row['waktu_selesai'] }}</td>
                    <td>{{ $row['total_waktu'] }}</td>
                    <td>
                        @php
                            $totalWaktu = $row['total_waktu'] ?? 0;
                            $days = floor($totalWaktu / 86400);
                            $hours = floor(($totalWaktu % 86400) / 3600);
                            $minutes = floor(($totalWaktu % 3600) / 60);
                            $seconds = $totalWaktu % 60;
                            echo "{$days}h {$hours}j {$minutes}m {$seconds}d";
                        @endphp
                    </td>
                    <td>{{ $row['pic_sortir_rework'] }}</td>
                    <td>{{ $row['total_check'] }}</td>
                    <td>{{ $row['total_ok'] }}</td>
                    <td>{{ $row['total_ng'] }}</td>
                    <td>{{ $row['tanggal_ambil'] }}</td>
                    <td>{{ $row['target_selesai'] }}</td>
                    <td>{{ $row['remark'] }}</td>
                    <td>{{ $row['status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
