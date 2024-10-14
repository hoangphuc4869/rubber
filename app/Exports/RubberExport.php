<?php

namespace App\Exports;

use App\Models\Rubber;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RubberExport implements FromCollection, WithHeadings, WithStyles
{
    protected $rowCount; // Biến lưu số lượng dòng thực tế
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        if ($this->startDate && $this->endDate) {
            $startDate = $this->startDate;
            $endDate = $this->endDate;
            // dd($startDate, $endDate);

            $data = Rubber::select(
                'time_di as date_go',
                'truck_name',
                'farm_name',
                'time_di as can_lan_1',
                'time_ve',
                'trong_luong_vao',
                'trong_luong_ra',
                'fresh_weight',
                'latex_type'
            )->whereBetween(DB::raw("DATE(STR_TO_DATE(time_di, '%d-%m-%Y %H:%i'))"), [$startDate, $endDate])
                ->orderBy(DB::raw("DATE(STR_TO_DATE(time_di, '%d-%m-%Y %H:%i'))"), 'asc')->get();
            if ($data->isEmpty()) {
                session()->flash('message', 'Không có dữ liệu trong khoảng thời gian đã chọn.');
                return collect([]);
            }
        } else {
            $data = Rubber::select(
                'time_di as date_go',
                'truck_name',
                'farm_name',
                'time_di as can_lan_1',
                'time_ve',
                'trong_luong_vao',
                'trong_luong_ra',
                'fresh_weight',
                'latex_type'
            )->get();
        }
        $data->transform(function ($item) {
            if ($item->time_ve) {
                $item->time_ve = \Carbon\Carbon::createFromFormat('d-m-Y H:i', $item->time_ve)->format('d-m-Y H:i');
            } else {
                $item->time_ve = 'Không có thời gian';
            }

            return $item;
        });
        $this->rowCount = $data->count();

        return $data;
    }

    public function headings(): array
    {
        return [
            ['CAOUTCHOUC CO., LTD'], // Dòng 1
            ['NHÀ MÁY CHẾ BIẾN STOUNG'], // Dòng 2
            ['THEO DÕI CÂN TRỌNG LƯỢNG MỦ NGUYÊN LIỆU'], // Dòng 3
            [],
            [
                'Ngày/Tháng/Năm',
                'Số xe',
                'Nguồn gốc',
                'Thời gian cân lần 1',
                'Thời gian cân lần 2',
                'Trọng lượng cân lần 1(Kg)',
                'Trọng lượng cân lần 2(Kg)',
                'Trọng lượng nguyên liệu tiếp nhận(Kg)',
                'Chủng loại nguyên liệu',
                'Ký xác nhận',
                'Ghi chú'
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Hợp nhất các ô cho tiêu đề lớn
        $sheet->mergeCells('A1:C1'); // CAOUTCHOUC CO., LTD
        $sheet->mergeCells('A2:C2'); // NHÀ MÁY CHẾ BIẾN STOUNG
        $sheet->mergeCells('A3:K3'); // THEO DÕI CÂN TRỌNG LƯỢNG MỦ NGUYÊN LIỆU

        // Style cho tiêu đề lớn
        $sheet->getStyle('A1:A3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Đặt độ cao tự động cho các hàng có dữ liệu
        $sheet->getStyle('A1:K' . ($this->rowCount + 5))->getAlignment()->setWrapText(true);

        // Đặt độ rộng tự động cho tất cả các cột
        foreach (range('A', 'K') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Căn giữa và in đậm tiêu đề bảng
        $sheet->getStyle('A5:K5')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Áp dụng style cho đúng số lượng hàng thực tế
        $sheet->getStyle('A6:K' . ($this->rowCount + 5))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6:K' . ($this->rowCount + 5))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Định dạng border cho đúng số lượng hàng thực tế
        $sheet->getStyle('A6:K' . ($this->rowCount + 5))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Cố định hàng tiêu đề khi in hoặc cuộn
        $sheet->freezePane('A6');

        $Row = $this->rowCount + 8;
        $sheet->setCellValue('A' . $Row, 'Người lập biểu');
        $sheet->setCellValue('H' . $Row, 'Người phụ trách');

        $sheet->mergeCells('A' . $Row . ':C' . $Row); // Merge ô từ A tới C cho "Người lập biểu"
        $sheet->mergeCells('H' . $Row . ':H' . $Row); // Merge ô I cho "Người phụ trách"

        $sheet->setCellValue('A' . ($Row + 1), '(ký tên, ghi rõ họ tên)');
        $sheet->mergeCells('A' . ($Row + 1) . ':C' . ($Row + 1));
        $sheet->setCellValue('H' . ($Row + 1), '(ký tên, ghi rõ họ tên)');
        $sheet->mergeCells('H' . ($Row + 1) . ':H' . ($Row + 1));

        // Căn giữa nội dung của hai ô văn bản
        $sheet->getStyle('A' . $Row . ':H' . ($Row + 1))->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
            ]
        ]);

        return [];
    }
}
