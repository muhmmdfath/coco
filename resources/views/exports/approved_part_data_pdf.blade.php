<!DOCTYPE html>
<html>
<head>
    <title>Approved Part Data</title>
    <style>
      body{
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
    <h1>Approved Part Data</h1>
    <p>Data exported from the system</p>
    <div class="export-date">Export Date: {{ $exportDate }}</div>
    <table>
        <thead>
            <tr>
                <th>Tanggal Sortir</th>
                <th>Part Number</th>
                <th>Lot Number</th>
                <th>Jenis Problem</th>
                <th>Metode Sortir/Rework</th>
                <th>Line</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Total Jam</th>
                <th>PIC Sortir/Rework</th>
                <th>Total Check</th>
                <th>Total OK</th>
                <th>Total NG</th>
                <th>Tanggal Ambil</th>
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
                    <td>{{ $row['jam_mulai'] }}</td>
                    <td>{{ $row['jam_selesai'] }}</td>
                    <td>{{ $row['total_jam'] }}</td>
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
