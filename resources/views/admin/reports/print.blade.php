<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan KWT Ariyad Jaya</title>
    <style>
        body { font-family: 'Times New Roman', serif; margin: 30px; font-size: 12pt; color: #000; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 12px; margin-bottom: 20px; }
        .kop h2 { margin: 0; font-size: 16pt; text-transform: uppercase; }
        .kop h3 { margin: 4px 0; font-size: 13pt; }
        .kop p { margin: 0; font-size: 10pt; font-style: italic; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px 8px; font-size: 10.5pt; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .ttd { margin-top: 40px; float: right; width: 220px; text-align: center; font-size: 11pt; }
    </style>
</head>
<body onload="window.print()">
    <div class="kop">
        <h2>KELOMPOK WANITA TANI (KWT) ARIYAD JAYA</h2>
        <h3>DESA PURWODADI, KECAMATAN TRIMURJO, KABUPATEN LAMPUNG TENGAH</h3>
        <p>Sekretariat: Dusun 1 Desa Purwodadi, Trimurjo &bull; Telp/WA: 0812-3456-7890</p>
    </div>

    <div style="text-align: center; font-weight: bold; margin-bottom: 15px;">
        LAPORAN REKAPITULASI PENJUALAN PRODUK SAYURAN<br>
        <span style="font-weight: normal; font-size: 10.5pt;">Periode: {{ $start }} s/d {{ $end }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Tanggal</th>
                <th>No. Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Rincian Sayur</th>
                <th style="text-align: right;">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $idx => $ord)
            <tr>
                <td style="text-align: center;">{{ $idx + 1 }}</td>
                <td>{{ $ord->created_at->format('d/m/Y') }}</td>
                <td>{{ $ord->order_code }}</td>
                <td>{{ $ord->user->name }}</td>
                <td>
                    @foreach($ord->orderItems as $item)
                        {{ $item->product->name }} ({{ $item->quantity }} {{ $item->product->unit }}){{ !$loop->last ? '; ' : '' }}
                    @endforeach
                </td>
                <td style="text-align: right;">{{ $ord->formatted_total }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align: center;">Tidak ada transaksi pada periode ini.</td></tr>
            @endforelse
            <tr style="font-weight: bold; background: #fafafa;">
                <td colspan="5" style="text-align: right;">TOTAL OMZET PENJUALAN:</td>
                <td style="text-align: right;">Rp {{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="ttd">
        Purwodadi, {{ date('d F Y') }}<br>
        Ketua KWT Ariyad Jaya,<br><br><br><br>
        <strong>( Ibu Sumini )</strong>
    </div>
</body>
</html>
