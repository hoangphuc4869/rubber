<?php

namespace App\Exports;

use App\Models\Drum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class GchTtExport implements FromCollection, WithHeadings, WithStyles
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
        $query = Drum::select(
            'drums.date',                 // Thời gian bắt đầu
            'curing_areas.code as curing_area_code',  // Khu ngăn
            'farms.code as farm_code',                // Nguồn gốc
            'rubber_warehouses.date as rubber_warehouses_date',
            'drums.state',                 // Tinh trang nguyen lieu
            'drums.impurity_removing',        //Tap chat loai bo
            'drums.thickness',                 // Be day to mu
            'drums.trang_thai_com',       // Trạng thái cốm
            'drums.name' // Thung so
        )->join('rubber_warehouses', 'drums.rolling_code', '=', 'rubber_warehouses.id')
            ->join('curing_areas', 'rubber_warehouses.curing_area_id', '=', 'curing_areas.id')
            ->join('farms', 'curing_areas.farm_id', '=', 'farms.id');

        // Nếu có lọc theo ngày
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('drums.date', [$this->startDate, $this->endDate]);
            $data = $query->get();
            $data->transform(function ($item) {
                if ($item->date) {
                    $item->date = \Carbon\Carbon::createFromFormat('Y-m-d', $item->date)->format('d-m-Y');
                }
                if ($item->date_curing) {
                    $item->date_curing = \Carbon\Carbon::createFromFormat('Y-m-d', $item->date_curing)->format('d-m-Y');
                }
                return $item;
            });
            $this->rowCount = $data->count();

            return $data;
        } else {
            $query = Drum::select(
                'drums.date',                 // Thời gian bắt đầu
                'curing_areas.code as curing_area_code',  // Khu ngăn
                'farms.code as farm_code',                // Nguồn gốc
                'rubber_warehouses.date as rubber_warehouses_date',
                'drums.state',                 // Tinh trang nguyen lieu
                'drums.impurity_removing',        //Tap chat loai bo
                'drums.thickness',                 // Be day to mu
                'drums.trang_thai_com',       // Trạng thái cốm
                'drums.name' // Thùng số
            )->join('rubber_warehouses', 'drums.rolling_code', '=', 'rubber_warehouses.id')  // Nối bảng rubber_warehouses
                ->join('curing_areas', 'rubber_warehouses.curing_area_id', '=', 'curing_areas.id') // Nối bảng curing_areas để lấy code
                ->join('farms', 'curing_areas.farm_id', '=', 'farms.id');

            $data = $query->get();
            $data->transform(function ($item) {
                if ($item->date) {
                    $item->date = \Carbon\Carbon::createFromFormat('Y-m-d', $item->date)->format('d-m-Y');
                }
                if ($item->date_curing) {
                    $item->date_curing = \Carbon\Carbon::createFromFormat('Y-m-d', $item->date_curing)->format('d-m-Y');
                }
                return $item;
            });
            $this->rowCount = $data->count();

            return $data;
        }
    }
    public function headings(): array
    {
        return [
            ['C.R.C.K.2 APHIVATH'],
            ['CAOUTCHOUC CO., LTD'],
            ['NHÀ MÁY CHẾ BIẾN STOUNG'],
            [],
            ['THEO DÕI GIA CÔNG TẠO HẠT SẢN PHẨM CSR10,20'], // Dòng tiêu đề phụ
            [], // Dòng trống
            [
                'Thời gian bắt đầu',
                'Khu ngăn',
                'Nguồn gốc',
                'Ngày cán vắt',
                'Tình trạng nguyên liệu',
                'Tạp chất loại bỏ',
                'Bề dày tờ mủ',
                'Trạng thái cốm',
                'Thùng số',
                'Ký xác nhận'
            ], // Các tiêu đề cột
            ['(1)', '(2)', '(3)', '(4)', '(5)', '(6)', '(7)', '(8)', '(9)', '(10)'] // Đánh số thứ tự
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Định dạng cho các dòng tên công ty và nhà máy
        $sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(14);
        $sheet->mergeCells('A1:C1')->getStyle('A1:C1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:C2')->getStyle('A2:C2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A3:C3')->getStyle('A3:C3')->getAlignment()->setHorizontal('center');

        // Gộp ô cho tiêu đề chính
        $sheet->mergeCells('A5:J5');
        $sheet->getStyle('A5:J5')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A5:J5')->getAlignment()->setHorizontal('center');

        // Định dạng tiêu đề
        $sheet->getStyle('A7:J8')->getFont()->setBold(true);
        $sheet->getStyle('A7:J8')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A7:J8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Căn giữa và tạo viền cho toàn bộ dữ liệu
        $sheet->getStyle('A9:J' . ($this->rowCount + 8))->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A9:J' . ($this->rowCount + 8))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Điều chỉnh độ rộng của cột để bảng rộng ra
        $sheet->getColumnDimension('A')->setWidth(25);  // Thời gian bắt đầu gia công
        $sheet->getColumnDimension('B')->setWidth(15);  // Khu ngăn
        $sheet->getColumnDimension('C')->setWidth(20);  // Nguồn gốc
        $sheet->getColumnDimension('D')->setWidth(25);  // Tạp chất loại bỏ
        $sheet->getColumnDimension('E')->setWidth(25);  // Thời gian tiếp nhận
        $sheet->getColumnDimension('F')->setWidth(20);  // Thời gian tồn trữ
        $sheet->getColumnDimension('G')->setWidth(15);  // Số lần cán
        $sheet->getColumnDimension('H')->setWidth(20);  // Trọng lượng quy khô
        $sheet->getColumnDimension('I')->setWidth(25);  // Nơi lưu trữ
        $sheet->getColumnDimension('J')->setWidth(25);  // Bề dày tờ mủ sau cán (cột bổ sung nếu có)

        $sheet->freezePane('A8');

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
