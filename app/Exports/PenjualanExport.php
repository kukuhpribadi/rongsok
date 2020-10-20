<?php

namespace App\Exports;

use App\TransaksiJual;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PenjualanExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $index = 1;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        // return TransaksiJual::find($this->id);
        $getTanggal = explode('-', $this->tanggal);

        $tanggalStart = explode('/', $getTanggal[0]);
        $tanggalStart = $tanggalStart[2] . '-' . $tanggalStart[1] . '-' . $tanggalStart[0];
        $tanggalEnd = explode('/', $getTanggal[1]);
        $tanggalEnd = $tanggalEnd[2] . '-' . $tanggalEnd[1] . '-' . $tanggalEnd[0];

        return TransaksiJual::whereBetween('created_at', [$tanggalStart, $tanggalEnd])->get();
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('a1:h1')->getFont()->setBold(true);
        $sheet->getStyle('a1:h1')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'No.',
            'Transaksi ID',
            'Tanggal',
            'Jenis barang',
            'Keterangan',
            'Harga',
            'Qty',
            'Total',
        ];
    }

    public function map($data): array
    {
        return [
            $this->index++,
            $data->transaksi_jual_id,
            $data->formatTanggal(),
            $data->barang->nama,
            $data->keterangan,
            "Rp " . number_format($data->harga, 0, ',', '.'),
            $data->qty,
            "Rp " . number_format($data->total(), 0, ',', '.'),
        ];
    }
}
