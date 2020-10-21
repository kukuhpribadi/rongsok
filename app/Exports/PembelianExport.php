<?php

namespace App\Exports;

use App\TransaksiBeli;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PembelianExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $index = 1;
    private $grandTotal = [];

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        $getTanggal = explode('-', $this->tanggal);

        $tanggalStart = explode('/', $getTanggal[0]);
        $tanggalStart = $tanggalStart[2] . '-' . $tanggalStart[1] . '-' . $tanggalStart[0];
        $tanggalEnd = explode('/', $getTanggal[1]);
        $tanggalEnd = $tanggalEnd[2] . '-' . $tanggalEnd[1] . '-' . $tanggalEnd[0];

        return TransaksiBeli::whereBetween('created_at', [$tanggalStart, $tanggalEnd . " 23:59:59"])->get();
    }

    public function styles(Worksheet $sheet)
    {
        // last column as letter value (e.g., D)
        $last_column = Coordinate::stringFromColumnIndex(count($this->collection()->toArray()[0]));

        $last_row = count($this->collection()->toArray()) + 2;

        $panjang1 = 'a1:' . $last_column . '1';
        $panjang2 = 'a1:' . $last_column . $last_row;

        $sheet->getStyle($panjang1)->getFont()->setBold(true);
        $sheet->getStyle($last_row)->getFont()->setBold(true);
        $sheet->getStyle($panjang2)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
    }

    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            AfterSheet::class => function (AfterSheet $event) {

                // last column as letter value (e.g., D)
                $last_column = Coordinate::stringFromColumnIndex(count($this->collection()->toArray()[0]));

                $total_column = Coordinate::stringFromColumnIndex(count($this->collection()->toArray()[0]) - 1);

                // calculate last row + 1 (total results + header rows + column headings row + new row)
                $last_row = count($this->collection()->toArray()) + 2 + 3;

                // set up a style array for cell formatting
                $style_text_center = [
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER
                    ]
                ];

                // at row 1, insert 2 rows
                $event->sheet->insertNewRowBefore(1, 3);

                // merge cells for full-width
                $event->sheet->mergeCells(sprintf('A1:%s1', $last_column));
                $event->sheet->mergeCells(sprintf('A2:%s2', $last_column));
                $event->sheet->mergeCells(sprintf('A%d:%s%d', $last_row, $total_column, $last_row));

                // assign cell values
                $event->sheet->setCellValue('A1', 'LAPORAN PEMBELIAN');
                $event->sheet->setCellValue('A2', $this->tanggal);
                $event->sheet->setCellValue(sprintf('A%d', $last_row), 'Total');
                $event->sheet->setCellValue($last_column . $last_row, "Rp " . number_format(array_sum($this->grandTotal), 0, ',', '.'));

                // assign cell styles
                $event->sheet->getStyle('A1:A2')->applyFromArray($style_text_center);
                $event->sheet->getStyle('A1:A2')->getFont()->setBold(true);
                $event->sheet->getStyle(sprintf('A%d', $last_row))->applyFromArray($style_text_center);
            },
        ];
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
        $this->grandTotal[] = $data->total();
        return [
            $this->index++,
            $data->transaksi_beli_id,
            $data->formatTanggal(),
            $data->barang->nama,
            $data->keterangan,
            "Rp " . number_format($data->harga, 0, ',', '.'),
            $data->qty,
            "Rp " . number_format($data->total(), 0, ',', '.'),
        ];
    }
}
