<?php

namespace App\Exports;

use App\Models\Drum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DrumExport implements FromCollection, WithEvents, WithMapping, WithStartRow
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function startRow(): int
    {
        return 8;
    }

    /**
     * Lấy toàn bộ collection của Drum để export
     */
    public function collection()
    {
        return Drum::all();
    }

    /**
     * Cấu trúc mỗi hàng dữ liệu
     */
    public function map($drum): array
    {
        return [
            $drum->heated_end,
            $drum->name,
            // Các thuộc tính khác nếu cần
        ];
    }

    /**
     * Sử dụng template có sẵn và ghi dữ liệu vào file
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $path = public_path('labelFiles/epkien_donggoi.xlsx');
                
                // Tải file template
                $spreadsheet = IOFactory::load($path);
                $sheet = $spreadsheet->getActiveSheet();
                
                // Ghi dữ liệu từ startRow = 8
                foreach ($this->collection() as $index => $drum) {
                    $row = $this->startRow() + $index;
                    $sheet->setCellValue("A{$row}", $drum->heated_end);
                    $sheet->setCellValue("B{$row}", $drum->name);
                }

                // Ghi lại nội dung vào file Excel xuất ra
                $event->getDelegate()->setSpreadsheet($spreadsheet);
            },
        ];
    }
}