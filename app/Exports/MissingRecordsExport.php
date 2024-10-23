<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MissingRecordsExport implements FromCollection, WithHeadings
{
    protected $missingRecords;

    public function __construct(array $missingRecords)
    {
        $this->missingRecords = $missingRecords;
    }

    public function collection()
    {
        return collect($this->missingRecords);
    }

    public function headings(): array
    {
        return [
            'Tên lô',
            'Nông trường',
            'Năm trồng',
            'Giống',
            'Diện tích',
            'Tổ',
            'X',
            'Y',
            'geo',
            'ID',
        ];
    }
}