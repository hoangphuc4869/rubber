<?php

namespace App\Exports;

use App\Models\Rubber;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TnTlExport implements FromCollection, WithHeadings, WithStyles
{
    protected $rowCount;
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        // Start building the base query
        $query = Rubber::select(
            'rubber.time_di',
            'rubber.time',
            'rubber.truck_name',
            'farms.name',
            'rubber.latex_type',
            'rubber.material_age',
            'rubber.fresh_weight',
            'rubber.drc_percentage',
            'rubber.dry_weight',
            'rubber.material_condition',
            'rubber.impurity_type',
            'curing_areas.code',
            'rubber.grade',
        )->join('farms', 'rubber.farm_id', '=', 'farms.id')
            ->join('curing_areas', 'rubber.farm_id', '=', 'curing_areas.id');

        if ($this->startDate && $this->endDate) {

            $startDate = $this->startDate;
            $endDate = $this->endDate;
            // dd($startDate, $endDate);

            $query->whereBetween(DB::raw("DATE(STR_TO_DATE(time_di, '%d-%m-%Y %H:%i'))"), [$startDate, $endDate])
                ->orderBy(DB::raw("DATE(STR_TO_DATE(time_di, '%d-%m-%Y %H:%i'))"), 'asc');
            $data = $query->get();
            $this->rowCount = $data->count();
            return $data;
        } else {
            $query = Rubber::select(
                'rubber.time_di',
                'rubber.time',
                'rubber.truck_name',
                'farms.name',
                'rubber.latex_type',
                'rubber.material_age',
                'rubber.fresh_weight',
                'rubber.drc_percentage',
                'rubber.dry_weight',
                'rubber.material_condition',
                'rubber.impurity_type',
                'curing_areas.code',
                'rubber.grade',
            )->join('farms', 'rubber.farm_id', '=', 'farms.id')
                ->join('curing_areas', 'rubber.farm_id', '=', 'curing_areas.id')
                ->orderBy(DB::raw("DATE(STR_TO_DATE(time_di, '%d-%m-%Y %H:%i'))"), 'asc');

            $data = $query->get();
            $this->rowCount = $data->count();

            return $data;
        }
    }

    public function headings(): array
    {
        if ($this->startDate && $this->endDate) {
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $this->startDate);
            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $this->endDate);

            // If start and end date are in the same month and year
            if ($startDate->format('m-Y') === $endDate->format('m-Y')) {
                $formattedDateRange = 'THÁNG ' . $startDate->format('m/Y');
            } else {
                // If they span different months or years
                $formattedDateRange = 'TỪ ' . $startDate->format('m/Y') . ' ĐẾN ' . $endDate->format('m/Y');
            }
        } else {
            // Default value if dates are not provided
            $formattedDateRange = 'TẤT CẢ THÁNG';
        }
        return [
            ['C.R.C.K.2 APHIVATH'],
            ['CAOUTCHOUC CO., LTD'],
            ['NHÀ MÁY CHẾ BIẾN STOUNG'],
            ['THEO DÕI TIẾP NHẬN NGUYÊN LIỆU  CÔNG TY C.R.C.K.2 ' . $formattedDateRange . ' SẢN PHẨM CSR10,20'],
            [],
            [
                'Ngày/Tháng/Năm',
                'Thời gian tiếp nhận',
                'Số xe',
                'Nguồn nguyên liệu',
                'Chủng loại mủ',
                'Tuổi nguyên liệu(ngày)',
                'Khối lượng mủ tươi (kg)',
                'DRC (%)',
                'Quy khô (kg)',
                'Tình trạng nguyên liệu (1/2/3/4)',
                'Loại tạp chất bị lẫn',
                'Nơi tiếp nhận',
                'Phân hạng nguyên liệu',
                'Ký xác nhận',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Hợp nhất các ô cho tiêu đề lớn
        $sheet->mergeCells('A1:C1'); // CAOUTCHOUC CO., LTD
        $sheet->mergeCells('A2:C2'); // NHÀ MÁY CHẾ BIẾN STOUNG
        $sheet->mergeCells('A3:C3'); // THEO DÕI CÂN TRỌNG LƯỢNG MỦ NGUYÊN LIỆU
        $sheet->mergeCells('A4:N4'); // THEO DÕI CÂN TRỌNG LƯỢNG MỦ NGUYÊN LIỆU

        // Style cho tiêu đề lớn
        $sheet->getStyle('A1:A4')->applyFromArray([
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
        $sheet->getStyle('A1:N' . ($this->rowCount + 6))->getAlignment()->setWrapText(true);

        // Đặt độ rộng tự động cho tất cả các cột
        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Căn giữa và in đậm tiêu đề bảng
        $sheet->getStyle('A6:N6')->applyFromArray([
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
        $sheet->getStyle('A6:N' . ($this->rowCount + 6))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6:N' . ($this->rowCount + 6))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Định dạng border cho đúng số lượng hàng thực tế
        $sheet->getStyle('A6:N' . ($this->rowCount + 6))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Cố định hàng tiêu đề khi in hoặc cuộn
        $sheet->freezePane('A7');

        $Row = $this->rowCount + 9;
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
