<?php

namespace App\Exports;

use App\Models\Drum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RlExport implements FromCollection, WithHeadings, WithStyles
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
            'drums.date',
            'drums.heated_end',
            'drums.name',
            'bales.press_temperature as bale_press_temperature',
            'bales.weight as bale_weight',
            'bales.number_of_bales as bale_number_of_bales', //5
            'bales.sample_cut_number as bale_sample_cut_number',
            'bales.evaluation as bale_evaluation',
            'batches.expected_grade as batch_expected_grade',
            'batches.batch_number as batch_batch_number',
            'batches.sample_cut_number as batch_sample_cut_number', //10
            'batches.packaging_type as batch_packaging_type',
            'warehouses.name as warehouse_name'  // Select warehouse data if needed
        )->join('bales', 'drums.bale_id', '=', 'bales.id')
            ->join('batches', 'drums.batch_id', '=', 'batches.id')
            ->join('warehouses', 'batches.warehouse_id', '=', 'warehouses.id');

        // Nếu có lọc theo ngày
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('drums.date', [$this->startDate, $this->endDate]);
            $data = $query->get();
            $data->transform(function ($item) {
                if ($item->date) {
                    $item->date = \Carbon\Carbon::createFromFormat('Y-m-d', $item->date)->format('d-m-Y');
                }
                if ($item->heated_end) {
                    $item->heated_end = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->heated_start)->format('H:i');
                }
                return $item;
            });
            $this->rowCount = $data->count();

            return $data;
        } else {
            $query = Drum::select(
                'drums.date',
                'drums.heated_end',
                'drums.name',
                'bales.press_temperature as bale_press_temperature',
                'bales.weight as bale_weight',
                'bales.number_of_bales as bale_number_of_bales', //5
                'bales.sample_cut_number as bale_sample_cut_number',
                'bales.evaluation as bale_evaluation',
                'batches.expected_grade as batch_expected_grade',
                'batches.batch_number as batch_batch_number',
                'batches.sample_cut_number as batch_sample_cut_number', //10
                'batches.packaging_type as batch_packaging_type',
                'warehouses.name as warehouse_name'  // Select warehouse data if needed
            )->join('bales', 'drums.bale_id', '=', 'bales.id')
                ->join('batches', 'drums.batch_id', '=', 'batches.id')
                ->join('warehouses', 'batches.warehouse_id', '=', 'warehouses.id');
            $data = $query->get();
            // dd($data);
            $data->transform(function ($item) {
                if ($item->date) {
                    $item->date = \Carbon\Carbon::createFromFormat('Y-m-d', $item->date)->format('d-m-Y');
                }
                if ($item->heated_end) {
                    $item->heated_end = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->heated_end)->format('H:i');
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
            ['THEO DÕI RA LÒ, ÉP KIỆN VÀ ĐÓNG GÓI SẢN PHẨM CSR10,20'], // Dòng tiêu đề phụ
            [],
            [
                'Ngày',
                'Thời gian ra lò',
                'Thùng số',
                'Nhiệt độ ép bành(độ C)',
                'Khối lượng bành(kg)',
                'Số bành/ thùng',
                'kiểm tra cắt bành',
                'Đánh giá',
                'Hạng dự kiến(CSR10/20)',
                'Lô số',
                'Số mẫu cắt',
                'Dạng đóng gói',
                'Nơi lưu trữ',
                'Ký xác nhận'
            ],
            ['(1)', '(2)', '(3)', '(4)', '(5)', '(6)', '(7)', '(8)', '(9)', '(10)', '(11)', '(12)', '(13)', '(14)'] // Đánh số thứ tự
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
        $sheet->mergeCells('A5:K5');
        $sheet->getStyle('A5:K5')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A5:K5')->getAlignment()->setHorizontal('center');

        // Định dạng tiêu đề
        $sheet->getStyle('A7:N8')->getFont()->setBold(true);
        $sheet->getStyle('A7:N8')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A7:N8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Căn giữa và tạo viền cho toàn bộ dữ liệu
        $sheet->getStyle('A9:N' . ($this->rowCount + 8))->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A9:N' . ($this->rowCount + 8))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Điều chỉnh độ rộng của cột để bảng rộng ra
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(22);
        $sheet->getColumnDimension('E')->setWidth(22);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(17);
        $sheet->getColumnDimension('M')->setWidth(17);
        $sheet->getColumnDimension('N')->setWidth(17);

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
