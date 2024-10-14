<?php

namespace App\Exports;

use App\Models\Rolling;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class CvTtExport implements FromCollection, WithHeadings, WithStyles
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
        // Truy vấn dữ liệu từ bảng rubber_warehouses và liên kết với các bảng khác
        $query = Rolling::select(
            'rubber_warehouses.date',                 // Thời gian bắt đầu gia công
            'curing_areas.code as curing_area_code',  // Khu ngăn
            'farms.code as farm_code',                // Nguồn gốc
            'rubber_warehouses.impurity_removing',    // Tạp chất loại bỏ
            'rubber_warehouses.code',                 // Thời gian tiếp nhận
            'rubber_warehouses.date_curing',          // Thời gian tồn trữ (ngày)
            'rubber_warehouses.time',                 // Số lần cán
            'rubber_warehouses.weight_to_roll',       // Trọng lượng quy khô
            'curing_houses.code as curing_house_code' // Nơi lưu trữ
        )
            ->join('curing_areas', 'rubber_warehouses.curing_area_id', '=', 'curing_areas.id')
            ->join('farms', 'curing_areas.farm_id', '=', 'farms.id')
            ->join('curing_houses', 'rubber_warehouses.curing_house_id', '=', 'curing_houses.id');

        // Nếu có lọc theo ngày
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('rubber_warehouses.date', [$this->startDate, $this->endDate]);
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
            $query = Rolling::select(
                'rubber_warehouses.date',                 // Thời gian bắt đầu gia công
                'curing_areas.code as curing_area_code',  // Khu ngăn
                'farms.code as farm_code',                // Nguồn gốc
                'rubber_warehouses.impurity_removing',    // Tạp chất loại bỏ
                'rubber_warehouses.code',                 // Thời gian tiếp nhận
                'rubber_warehouses.date_curing',          // Thời gian tồn trữ (ngày)
                'rubber_warehouses.time',                 // Số lần cán
                'rubber_warehouses.weight_to_roll',       // Trọng lượng quy khô
                'curing_houses.code as curing_house_code' // Nơi lưu trữ
            )
                ->join('curing_areas', 'rubber_warehouses.curing_area_id', '=', 'curing_areas.id')
                ->join('farms', 'curing_areas.farm_id', '=', 'farms.id')
                ->join('curing_houses', 'rubber_warehouses.curing_house_id', '=', 'curing_houses.id');
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
            ['CAOUTCHOUC CO.,LTD'],
            ['NHÀ MÁY CHẾ BIẾN STOUNG'],
            [],
            ['THEO DÕI XỬ LÝ CÁN TẠO TỜ VÀ TỒN TRỮ SẢN PHẨM CSR10,20'],
            [],
            [
                'Thời gian bắt đầu gia công',  // Tương ứng với 'rubber_warehouses.date'
                'Khu ngăn',                    // Tương ứng với 'curing_areas.code'
                'Nguồn gốc',                   // Tương ứng với 'farms.code'
                'Tạp chất loại bỏ',             // Tương ứng với 'rubber_warehouses.impurity_removing'
                'Thời gian tiếp nhận (ngày)',   // Tương ứng với 'rubber_warehouses.date'
                'Thời gian tồn trữ (ngày)',     // Tương ứng với 'rubber_warehouses.date_curing'
                'Số lần cán',                   // Tương ứng với 'rubber_warehouses.time'
                'Trọng lượng quy khô',          // Tương ứng với 'rubber_warehouses.weight_to_roll'
                'Nơi lưu trữ',                  // Tương ứng với 'curing_houses.code'
                'Bề dày tờ mủ sau cán',         // Cột chưa có trong truy vấn (có thể thêm vào nếu có dữ liệu)
                'Ước tính ngày chế biến',       // Cột chưa có trong truy vấn (có thể thêm vào nếu có dữ liệu)
                'Ký xác nhận'                   // Cột chưa có trong truy vấn (có thể thêm vào nếu có dữ liệu)
            ]
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
        $sheet->mergeCells('A5:L5');
        $sheet->getStyle('A5:L5')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A5:L5')->getAlignment()->setHorizontal('center');

        // Định dạng tiêu đề
        $sheet->getStyle('A7:L8')->getFont()->setBold(true);
        $sheet->getStyle('A7:L8')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A7:L8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Căn giữa và tạo viền cho toàn bộ dữ liệu
        $sheet->getStyle('A9:L' . ($this->rowCount + 7))->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A9:L' . ($this->rowCount + 7))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

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
        $sheet->getColumnDimension('K')->setWidth(25);  // Ước tính ngày chế biến (cột bổ sung nếu có)
        $sheet->getColumnDimension('L')->setWidth(25);  // Ước tính ngày chế biến (cột bổ sung nếu có)

        $sheet->freezePane('A6');

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
