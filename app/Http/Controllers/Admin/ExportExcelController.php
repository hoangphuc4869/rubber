<?php

namespace App\Http\Controllers\Admin;


use App\Exports\CvTtExport;
use App\Exports\GchTtExport;
use App\Exports\Gcn_TtExport;
use App\Exports\RlExport;
use App\Http\Controllers\Controller;
use App\Exports\RubberExport;
use App\Exports\TnTlExport;
use App\Models\Rolling;
use App\Models\Rubber;
use Illuminate\Http\Request; // Sử dụng đúng lớp Request
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExportExcelController extends Controller
{
    

    public function fillExcel()
    {

        $nt1_MDC = Rubber::where('farm_id', 1)->whereIn('latex_type', ['MỦ ĐÔNG CHÉN', 'MĐC GIA CÔNG'])->where('input_status', 1)->sum('fresh_weight');
        $nt2_MDC = Rubber::where('farm_id', 2)->whereIn('latex_type', ['MỦ ĐÔNG CHÉN', 'MĐC GIA CÔNG'])->where('input_status', 1)->sum('fresh_weight');
        $nt3_MDC = Rubber::where('farm_id', 3)->whereIn('latex_type', ['MỦ ĐÔNG CHÉN', 'MĐC GIA CÔNG'])->where('input_status', 1)->sum('fresh_weight');
        $nt4_MDC = Rubber::where('farm_id', 4)->whereIn('latex_type', ['MỦ ĐÔNG CHÉN', 'MĐC GIA CÔNG'])->where('input_status', 1)->sum('fresh_weight');
        $nt5_MDC = Rubber::where('farm_id', 5)->whereIn('latex_type', ['MỦ ĐÔNG CHÉN', 'MĐC GIA CÔNG'])->where('input_status', 1)->sum('fresh_weight');
        $nt6_MDC = Rubber::where('farm_id', 6)->whereIn('latex_type', ['MỦ ĐÔNG CHÉN', 'MĐC GIA CÔNG'])->where('input_status', 1)->sum('fresh_weight');
        $nt7_MDC = Rubber::where('farm_id', 7)->whereIn('latex_type', ['MỦ ĐÔNG CHÉN', 'MĐC GIA CÔNG'])->where('input_status', 1)->sum('fresh_weight');
        $nt8_MDC = Rubber::where('farm_id', 8)->whereIn('latex_type', ['MỦ ĐÔNG CHÉN', 'MĐC GIA CÔNG'])->where('input_status', 1)->sum('fresh_weight');

        $nt1 = Rubber::where('farm_id', 1)->where('input_status', 1)->first();
        $nt2 = Rubber::where('farm_id', 2)->where('input_status', 1)->first();
        $nt3 = Rubber::where('farm_id', 3)->where('input_status', 1)->first();
        $nt6 = Rubber::where('farm_id', 6)->where('input_status', 1)->first();

        // dd($nt1_MDC);

        
        $filePath = public_path('/excelFiles/Mẫu- báo cáo trạm cân.xlsx');

        $spreadsheet = IOFactory::load($filePath);

        
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('C10', $nt1_MDC ? $nt1_MDC : '');
        $sheet->setCellValue('C11', $nt1_MDC ? $nt2_MDC : '');
        $sheet->setCellValue('C12', $nt3_MDC ? $nt3_MDC : '');
        $sheet->setCellValue('C13', $nt6_MDC ? $nt6_MDC : '');

        $sheet->setCellValue('D10', $nt1 ? $nt1->drc_percentage : '');
        $sheet->setCellValue('D11', $nt2 ? $nt2->drc_percentage : '');
        $sheet->setCellValue('D12', $nt3 ? $nt3->drc_percentage : '');
        $sheet->setCellValue('D13', $nt6 ? $nt6->drc_percentage : '');

        $sheet->setCellValue('E10', $nt1 && $nt1_MDC ? $nt1_MDC * $nt1->drc_percentage /100 : '' );
        $sheet->setCellValue('E11', $nt2 && $nt2_MDC ? $nt2_MDC * $nt2->drc_percentage /100 : '');
        $sheet->setCellValue('E12', $nt3 && $nt3_MDC ? $nt3_MDC * $nt3->drc_percentage /100 : '');
        $sheet->setCellValue('E13', $nt6 && $nt6_MDC ? $nt6_MDC * $nt6->drc_percentage /100 : '');


        // $sheet->setCellValue('C3', 'Dữ liệu tại ô C3');

        $newFileName = 'filled_template.xlsx';
        $newFilePath = public_path('excelFiles/' . $newFileName);

        
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);

        return response()->download($newFilePath);
    }

    public function index()
    {
        return view('admin.exportExcel',);
    }
    //Cân xe
    public function export(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        if (isset($startDate) && isset($endDate)) {
            $formattedStartDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('d-m-Y');
            $formattedEndDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('d-m-Y');
            $fileName = 'CanXe_QLCL_' . $formattedStartDate . '_den_' . $formattedEndDate . '.xlsx';
            if ($formattedStartDate === $formattedEndDate) {
                // Nếu giống nhau, chỉ dùng một ngày cho tên file
                $fileName = 'CanXe_QLCL_' . $formattedStartDate . '.xlsx';
            } else {
                // Nếu khác nhau, dùng khoảng thời gian
                $fileName = 'CanXe_QLCL_' . $formattedStartDate . '_den_' . $formattedEndDate . '.xlsx';
            }
        } else {
            // Nếu không chọn ngày, xuất toàn bộ và đặt tên file là "All"
            $fileName = 'CanXe_QLCL_All.xlsx';
        }

        // Xuất file với tên tương ứng
        return Excel::download(new RubberExport($startDate, $endDate), $fileName);
    }

    //Tiếp nhận trợ lý
    public function export_tntl(Request $request)
    {
        $startDate = $request->start_date_tntl;
        $endDate = $request->end_date_tntl;

        if (isset($startDate) && isset($endDate)) {
            $formattedStartDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('d-m-Y');
            $formattedEndDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('d-m-Y');
            $fileName = 'Tiep_Nhan_Tro_Ly_' . $formattedStartDate . '_den_' . $formattedEndDate . '.xlsx';
            if ($formattedStartDate === $formattedEndDate) {
                // Nếu giống nhau, chỉ dùng một ngày cho tên file
                $fileName = 'Tiep_Nhan_Tro_Ly_' . $formattedStartDate . '.xlsx';
            } else {
                // Nếu khác nhau, dùng khoảng thời gian
                $fileName = 'Tiep_Nhan_Tro_Ly_' . $formattedStartDate . '_den_' . $formattedEndDate . '.xlsx';
            }
        } else {
            // Nếu không chọn ngày, xuất toàn bộ và đặt tên file là "All"
            $fileName = 'Tiep_Nhan_Tro_Ly_All.xlsx';
        }

        // Xuất file với tên tương ứng
        return Excel::download(new TnTlExport($startDate, $endDate), $fileName);
    }

    //Cán vắt
    public function export_cvtt(Request $request)
    {
        $startDate = $request->start_date_cvtt;
        $endDate = $request->end_date_cvtt;

        if (isset($startDate) && isset($endDate)) {
            $formattedStartDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('d-m-Y');
            $formattedEndDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('d-m-Y');
            $fileName = 'CanVat_ToTruong_' . $formattedStartDate . '_den_' . $formattedEndDate . '.xlsx';
            if ($formattedStartDate === $formattedEndDate) {
                // Nếu giống nhau, chỉ dùng một ngày cho tên file
                $fileName = 'CanVat_ToTruong_' . $formattedStartDate . '.xlsx';
            } else {
                // Nếu khác nhau, dùng khoảng thời gian
                $fileName = 'CanVat_ToTruong_' . $formattedStartDate . '_den_' . $formattedEndDate . '.xlsx';
            }
        } else {
            // Nếu không chọn ngày, xuất toàn bộ và đặt tên file là "All"
            $fileName = 'CanVat_ToTruong_All.xlsx';
        }

        // Xuất file với tên tương ứng
        return Excel::download(new CvTtExport($startDate, $endDate), $fileName);
    }

    //Gia công hạt
    public function export_gchtt(Request $request)
    {
        $startDate = $request->start_date_gchtt;
        $endDate = $request->end_date_gchtt;

        if (isset($startDate) && isset($endDate)) {
            $formattedStartDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('d-m-Y');
            $formattedEndDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('d-m-Y');
            $fileName = 'GiaCongHat_ToTruong_' . $formattedStartDate . '_den_' . $formattedEndDate . '.xlsx';
            if ($formattedStartDate === $formattedEndDate) {
                // Nếu giống nhau, chỉ dùng một ngày cho tên file
                $fileName = 'GiaCongHat_ToTruong_' . $formattedStartDate . '.xlsx';
            } else {
                // Nếu khác nhau, dùng khoảng thời gian
                $fileName = 'GiaCongHat_ToTruong_' . $formattedStartDate . '_den_' . $formattedEndDate . '.xlsx';
            }
        } else {
            // Nếu không chọn ngày, xuất toàn bộ và đặt tên file là "All"
            $fileName = 'GiaCongHat_ToTruong_All.xlsx';
        }

        // Xuất file với tên tương ứng
        return Excel::download(new GchTtExport($startDate, $endDate), $fileName);
    }

    //Gia công nhiệt
    public function export_gcntt(Request $request)
    {
        $startDate = $request->start_date_gcntt;
        $endDate = $request->end_date_gcntt;

        if (isset($startDate) && isset($endDate)) {
            $formattedStartDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('d-m-Y');
            $formattedEndDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('d-m-Y');
            $fileName = 'GiaCongNhiet_ToTruong_' . $formattedStartDate . '_den_' . $formattedEndDate . '.xlsx';
            if ($formattedStartDate === $formattedEndDate) {
                // Nếu giống nhau, chỉ dùng một ngày cho tên file
                $fileName = 'GiaCongNhiet_ToTruong_' . $formattedStartDate . '.xlsx';
            } else {
                // Nếu khác nhau, dùng khoảng thời gian
                $fileName = 'GiaCongNhiet_ToTruong_' . $formattedStartDate . '_den_' . $formattedEndDate . '.xlsx';
            }
        } else {
            // Nếu không chọn ngày, xuất toàn bộ và đặt tên file là "All"
            $fileName = 'GiaCongNhiet_ToTruong_All.xlsx';
        }

        // Xuất file với tên tương ứng
        return Excel::download(new Gcn_TtExport($startDate, $endDate), $fileName);
    }
    //Ra lò 
    public function export_rl(Request $request)
    {
        $startDate = $request->start_date_rl;
        $endDate = $request->end_date_rl;

        if (isset($startDate) && isset($endDate)) {
            $formattedStartDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('d-m-Y');
            $formattedEndDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('d-m-Y');
            $fileName = 'Ra_Lo_Ek_Bg_' . $formattedStartDate . '_den_' . $formattedEndDate . '.xlsx';
            if ($formattedStartDate === $formattedEndDate) {
                // Nếu giống nhau, chỉ dùng một ngày cho tên file
                $fileName = 'Ra_Lo_Ek_Bg_' . $formattedStartDate . '.xlsx';
            } else {
                // Nếu khác nhau, dùng khoảng thời gian
                $fileName = 'Ra_Lo_Ek_Bg_' . $formattedStartDate . '_den_' . $formattedEndDate . '.xlsx';
            }
        } else {
            // Nếu không chọn ngày, xuất toàn bộ và đặt tên file là "All"
            $fileName = 'Ra_Lo_Ek_Bg_All.xlsx';
        }

        // Xuất file với tên tương ứng
        return Excel::download(new RlExport($startDate, $endDate), $fileName);
    }

    public function canVat()
    {
        // Path to the Excel file
        $filePath = storage_path('app/public/excel/Book1.xlsx');

        // Load the Excel file
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet(); // Get the active sheet

        // Define the range of cells manually (instead of using getTableByName)
        $startRow = 8; // Row 6 as per your template image
        $startColumn = 'A'; // Column A as the starting point

        // Get the last row dynamically if you need to find the number of filled rows
        $highestRow = $sheet->getHighestRow(); // The last row with data
        $endColumn = $sheet->getHighestColumn(); // The last column with data

        // Query data from the database
        $data = Rolling::select(
            'rubber_warehouses.date',
            'curing_areas.code as curing_area_code',
            'farms.code as farm_code',
            'rubber_warehouses.impurity_removing',
            'rubber_warehouses.code',
            'rubber_warehouses.date_curing',
            'rubber_warehouses.time',
            'rubber_warehouses.weight_to_roll',
            'curing_houses.code as curing_house_code'
        )
            ->join('curing_areas', 'rubber_warehouses.curing_area_id', '=', 'curing_areas.id')
            ->join('farms', 'curing_areas.farm_id', '=', 'farms.id')
            ->join('curing_houses', 'rubber_warehouses.curing_house_id', '=', 'curing_houses.id')
            ->get();

        // Start inserting data from the first empty row after the header
        $currentRow = $startRow + 1;

        foreach ($data as $item) {
            // Format date fields if needed
            if ($item->date) {
                $item->date = Carbon::createFromFormat('Y-m-d', $item->date)->format('d-m-Y');
            }
            if ($item->date_curing) {
                $item->date_curing = Carbon::createFromFormat('Y-m-d', $item->date_curing)->format('d-m-Y');
            }

            // Insert data into specific columns
            $sheet->setCellValue('A' . $currentRow, $item->date);               // Column A: Thời gian bắt đầu gia công
            $sheet->setCellValue('B' . $currentRow, $item->curing_area_code);   // Column B: Khu ngăn
            $sheet->setCellValue('C' . $currentRow, $item->farm_code);          // Column C: Nguồn gốc
            $sheet->setCellValue('D' . $currentRow, $item->impurity_removing);  // Column D: Tạp chất loại bỏ
            $sheet->setCellValue('E' . $currentRow, $item->code);               // Column E: Thời gian tiếp nhận
            $sheet->setCellValue('F' . $currentRow, $item->date_curing);        // Column F: Thời gian tồn trữ (ngày)
            $sheet->setCellValue('G' . $currentRow, $item->time);               // Column G: Số lần cán
            $sheet->setCellValue('H' . $currentRow, $item->weight_to_roll);     // Column H: Trọng lượng quy khô
            $sheet->setCellValue('I' . $currentRow, $item->curing_house_code);  // Column I: Nơi lưu trữ

            $currentRow++; // Move to the next row for the next data item
        }

        // Save the modified Excel file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $newFilePath = storage_path('app/public/excel/Book1.xlsx');
        $writer->save($newFilePath);

        // Optional: Return the modified file for download
        return response()->download($newFilePath);
    }

    


}