<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WarehouseExport implements FromArray, WithHeadings
{
    /**
     * Dữ liệu xuất ra file Excel
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Trả về mảng dữ liệu để xuất
     */
    public function array(): array
    {
        return $this->data;
    }

    /**
     * Định nghĩa tiêu đề cho các cột
     */
    public function headings(): array
    {
        return ['Tên kho', 'Vị trí', 'Mã lô'];
    }
}