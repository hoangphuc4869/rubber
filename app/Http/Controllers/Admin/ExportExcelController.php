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
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportExcelController extends Controller
{
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

    public function export_bc(Request $request)
    {
        $start_date_bc = $request->input('start_date_bc');
        $month_bc = date('m', strtotime($start_date_bc));
        $year_bc = date('Y', strtotime($start_date_bc));
        // Đường dẫn đến file Excel
        $filePath = public_path('/excelFiles/Mẫu- báo cáo trạm cân.xlsx');
        // Load file Excel
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        // NÔNG TRƯỜNG 1
        $totalFreshWeightFarm1 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 1')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcFarm1 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 1')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightFarm1 = ($totalFreshWeightFarm1 * $drcFarm1) / 100;
        $totalFreshWeightLatexTypeFarm1 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 1')
            ->where('input_status', 1)
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');

        $drcLatexTypeFarm1 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 1')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightLatexTypeFarm1 = ($totalFreshWeightLatexTypeFarm1 * $drcLatexTypeFarm1) / 100;

        $sheet->setCellValue('C10', $totalFreshWeightFarm1);  // Tổng fresh_weight cho NÔNG TRƯỜNG 1
        $sheet->setCellValue('D10', $drcFarm1);              // DRC% cho NÔNG TRƯỜNG 1
        $sheet->setCellValue('E10', $dryWeightFarm1);        // Quy khô cho NÔNG TRƯỜNG 1 (fresh_weight * DRC%)
        $sheet->setCellValue('G10', $totalFreshWeightLatexTypeFarm1);  // Tổng fresh_weight cho MỦ DÂY
        $sheet->setCellValue('H10', $drcLatexTypeFarm1);               // DRC% cho MỦ DÂY
        $sheet->setCellValue('I10', $dryWeightLatexTypeFarm1);         // Quy khô cho MỦ DÂY (fresh_weight * DRC%)
        // Nông trường 2
        $totalFreshWeightFarm2 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 2')
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->where('input_status', 1)
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcFarm2 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 2')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightFarm2 = ($totalFreshWeightFarm2 * $drcFarm2) / 100;
        $totalFreshWeightLatexTypeFarm2 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('input_status', 1)
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 2')
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcLatexTypeFarm2 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 2')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightLatexTypeFarm2 = ($totalFreshWeightLatexTypeFarm2 * $drcLatexTypeFarm2) / 100;
        $sheet->setCellValue('C11', $totalFreshWeightFarm2);  // Tổng fresh_weight cho NÔNG TRƯỜNG 2
        $sheet->setCellValue('D11', $drcFarm2);              // DRC% cho NÔNG TRƯỜNG 2
        $sheet->setCellValue('E11', $dryWeightFarm2);        // Quy khô cho NÔNG TRƯỜNG 2 (fresh_weight * DRC%)
        $sheet->setCellValue('G11', $totalFreshWeightLatexTypeFarm2);  // Tổng fresh_weight cho MỦ DÂY
        $sheet->setCellValue('H11', $drcLatexTypeFarm2);               // DRC% cho MỦ DÂY
        $sheet->setCellValue('I11', $dryWeightLatexTypeFarm2);         // Quy khô cho MỦ DÂY (fresh_weight * DRC%)
        // NÔNG TRƯỜNG 3
        $totalFreshWeightFarm3 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 3')
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->where('input_status', 1)
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcFarm3 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 3')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightFarm3 = ($totalFreshWeightFarm3 * $drcFarm3) / 100;
        $totalFreshWeightLatexTypeFarm3 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('input_status', 1)
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 3')
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcLatexTypeFarm3 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 3')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightLatexTypeFarm3 = ($totalFreshWeightLatexTypeFarm3 * $drcLatexTypeFarm3) / 100;
        $sheet->setCellValue('C12', $totalFreshWeightFarm3);  // Tổng fresh_weight cho NÔNG TRƯỜNG 3
        $sheet->setCellValue('D12', $drcFarm3);              // DRC% cho NÔNG TRƯỜNG 3
        $sheet->setCellValue('E12', $dryWeightFarm3);        // Quy khô cho NÔNG TRƯỜNG 3 (fresh_weight * DRC%)
        $sheet->setCellValue('G12', $totalFreshWeightLatexTypeFarm3);  // Tổng fresh_weight cho MỦ DÂY
        $sheet->setCellValue('H12', $drcLatexTypeFarm3);               // DRC% cho MỦ DÂY
        $sheet->setCellValue('I12', $dryWeightLatexTypeFarm3);         // Quy khô cho MỦ DÂY (fresh_weight * DRC%)
        // NÔNG TRƯỜNG 6
        $totalFreshWeightFarm6 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 6')
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->where('input_status', 1)
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcFarm6 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 6')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightFarm6 = ($totalFreshWeightFarm6 * $drcFarm6) / 100;
        $totalFreshWeightLatexTypeFarm6 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('input_status', 1)
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 6')
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcLatexTypeFarm6 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 6')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightLatexTypeFarm6 = ($totalFreshWeightLatexTypeFarm6 * $drcLatexTypeFarm6) / 100;
        $sheet->setCellValue('C13', $totalFreshWeightFarm6);  // Tổng fresh_weight cho NÔNG TRƯỜNG 6
        $sheet->setCellValue('D13', $drcFarm6);              // DRC% cho NÔNG TRƯỜNG 6
        $sheet->setCellValue('E13', $dryWeightFarm6);        // Quy khô cho NÔNG TRƯỜNG 6 (fresh_weight * DRC%)
        $sheet->setCellValue('G13', $totalFreshWeightLatexTypeFarm6);  // Tổng fresh_weight cho MỦ DÂY
        $sheet->setCellValue('H13', $drcLatexTypeFarm6);               // DRC% cho MỦ DÂY
        $sheet->setCellValue('I13', $dryWeightLatexTypeFarm6);         // Quy khô cho MỦ DÂY (fresh_weight * DRC%)
        // NÔNG TRƯỜNG 4
        $totalFreshWeightFarm4 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 4')
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->where('input_status', 1)
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcFarm4 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 4')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightFarm4 = ($totalFreshWeightFarm4 * $drcFarm4) / 100;
        $totalFreshWeightLatexTypeFarm4 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('input_status', 1)
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 4')
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcLatexTypeFarm4 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 4')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightLatexTypeFarm4 = ($totalFreshWeightLatexTypeFarm4 * $drcLatexTypeFarm4) / 100;
        $sheet->setCellValue('C15', $totalFreshWeightFarm4);  // Tổng fresh_weight cho NÔNG TRƯỜNG 4
        $sheet->setCellValue('D15', $drcFarm4);              // DRC% cho NÔNG TRƯỜNG 4
        $sheet->setCellValue('E15', $dryWeightFarm4);        // Quy khô cho NÔNG TRƯỜNG 4 (fresh_weight * DRC%)
        $sheet->setCellValue('G15', $totalFreshWeightLatexTypeFarm4);  // Tổng fresh_weight cho MỦ DÂY
        $sheet->setCellValue('H15', $drcLatexTypeFarm4);               // DRC% cho MỦ DÂY
        $sheet->setCellValue('I15', $dryWeightLatexTypeFarm4);         // Quy khô cho MỦ DÂY (fresh_weight * DRC%)

        // NÔNG TRƯỜNG 5
        $totalFreshWeightFarm5 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 5')
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->where('input_status', 1)
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcFarm5 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 5')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightFarm5 = ($totalFreshWeightFarm5 * $drcFarm5) / 100;
        $totalFreshWeightLatexTypeFarm5 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('input_status', 1)
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 5')
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcLatexTypeFarm5 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 5')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightLatexTypeFarm5 = ($totalFreshWeightLatexTypeFarm5 * $drcLatexTypeFarm5) / 100;
        $sheet->setCellValue('C16', $totalFreshWeightFarm5);  // Tổng fresh_weight cho NÔNG TRƯỜNG 5
        $sheet->setCellValue('D16', $drcFarm5);              // DRC% cho NÔNG TRƯỜNG 5
        $sheet->setCellValue('E16', $dryWeightFarm5);        // Quy khô cho NÔNG TRƯỜNG 5 (fresh_weight * DRC%)
        $sheet->setCellValue('G16', $totalFreshWeightLatexTypeFarm5);  // Tổng fresh_weight cho MỦ DÂY
        $sheet->setCellValue('H16', $drcLatexTypeFarm5);               // DRC% cho MỦ DÂY
        $sheet->setCellValue('I16', $dryWeightLatexTypeFarm5);         // Quy khô cho MỦ DÂY (fresh_weight * DRC%)
        // NÔNG TRƯỜNG 7
        $totalFreshWeightFarm7 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 7')
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->where('input_status', 1)
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcFarm7 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 7')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightFarm7 = ($totalFreshWeightFarm7 * $drcFarm7) / 100;
        $totalFreshWeightLatexTypeFarm7 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('input_status', 1)
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 7')
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcLatexTypeFarm7 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 7')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightLatexTypeFarm7 = ($totalFreshWeightLatexTypeFarm7 * $drcLatexTypeFarm7) / 100;
        $sheet->setCellValue('C17', $totalFreshWeightFarm7);  // Tổng fresh_weight cho NÔNG TRƯỜNG 7
        $sheet->setCellValue('D17', $drcFarm7);              // DRC% cho NÔNG TRƯỜNG 7
        $sheet->setCellValue('E17', $dryWeightFarm7);        // Quy khô cho NÔNG TRƯỜNG 7 (fresh_weight * DRC%)
        $sheet->setCellValue('G17', $totalFreshWeightLatexTypeFarm7);  // Tổng fresh_weight cho MỦ DÂY
        $sheet->setCellValue('H17', $drcLatexTypeFarm7);               // DRC% cho MỦ DÂY
        $sheet->setCellValue('I17', $dryWeightLatexTypeFarm7);         // Quy khô cho MỦ DÂY (fresh_weight * DRC%)

        // NÔNG TRƯỜNG 8
        $totalFreshWeightFarm8 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 8')
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->where('input_status', 1)
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcFarm8 = Rubber::where('farm_name', 'NÔNG TRƯỜNG 8')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightFarm8 = ($totalFreshWeightFarm8 * $drcFarm8) / 100;
        $totalFreshWeightLatexTypeFarm8 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('input_status', 1)
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 8')
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcLatexTypeFarm8 = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 8')
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $dryWeightLatexTypeFarm8 = ($totalFreshWeightLatexTypeFarm8 * $drcLatexTypeFarm8);
        $sheet->setCellValue('C18', $totalFreshWeightFarm8);  // Tổng fresh_weight cho NÔNG TRƯỜNG 8
        $sheet->setCellValue('D18', $drcFarm8);              // DRC% cho NÔNG TRƯỜNG 8
        $sheet->setCellValue('E18', $dryWeightFarm8);        // Quy khô cho NÔNG TRƯỜNG 8 (fresh_weight * DRC%)
        $sheet->setCellValue('G18', $totalFreshWeightLatexTypeFarm8);  // Tổng fresh_weight cho MỦ DÂY
        $sheet->setCellValue('H18', $drcLatexTypeFarm8);               // DRC% cho MỦ DÂY
        $sheet->setCellValue('I18', $dryWeightLatexTypeFarm8);         // Quy khô cho MỦ DÂY (fresh_weight * DRC%)
        $totalFreshWeightTNSR = Rubber::where('farm_name', 'TÂY NINH SR')
            ->where('input_status', 1)
            ->whereDate('date', $start_date_bc)
            ->sum('fresh_weight');
        $drcTNSR = Rubber::where('farm_name', 'TÂY NINH SR')
            ->where('input_status', 1)
            ->whereDate('date', $start_date_bc)
            ->value('drc_percentage');
        $sheet->setCellValue('C23', $totalFreshWeightTNSR);
        $sheet->setCellValue('E23', $drcTNSR);

        //Month NT1
        $totalFreshWeightFarm1Month = Rubber::where('farm_name', 'NÔNG TRƯỜNG 1')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');

        $totalFreshWeightLatexTypeFarm1Month = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 1')
            ->where('input_status', 1)
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');
        $sheet->setCellValue('C29', $totalFreshWeightFarm1Month);
        $sheet->setCellValue('C41', $totalFreshWeightLatexTypeFarm1Month);
        //Month NT2
        $totalFreshWeightFarm2Month = Rubber::where('farm_name', 'NÔNG TRƯỜNG 2')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');

        $totalFreshWeightLatexTypeFarm2Month = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 2')
            ->where('input_status', 1)
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');
        $sheet->setCellValue('C30', $totalFreshWeightFarm2Month);
        $sheet->setCellValue('C42', $totalFreshWeightLatexTypeFarm2Month);
        //Month3
        $totalFreshWeightFarm3Month = Rubber::where('farm_name', 'NÔNG TRƯỜNG 3')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');

        $totalFreshWeightLatexTypeFarm3Month = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 3')
            ->where('input_status', 1)
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');
        $sheet->setCellValue('C31', $totalFreshWeightFarm3Month);
        $sheet->setCellValue('C43', $totalFreshWeightLatexTypeFarm3Month);
        //Month6
        $totalFreshWeightFarm6Month = Rubber::where('farm_name', 'NÔNG TRƯỜNG 6')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');

        $totalFreshWeightLatexTypeFarm6Month = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 6')
            ->where('input_status', 1)
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');
        $sheet->setCellValue('C32', $totalFreshWeightFarm6Month);
        $sheet->setCellValue('C44', $totalFreshWeightLatexTypeFarm6Month);
        //Month4
        $totalFreshWeightFarm4Month = Rubber::where('farm_name', 'NÔNG TRƯỜNG 4')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');

        $totalFreshWeightLatexTypeFarm4Month = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 4')
            ->where('input_status', 1)
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');
        $sheet->setCellValue('C34', $totalFreshWeightFarm4Month);
        $sheet->setCellValue('C46', $totalFreshWeightLatexTypeFarm4Month);
        //Month5
        $totalFreshWeightFarm5Month = Rubber::where('farm_name', 'NÔNG TRƯỜNG 5')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');

        $totalFreshWeightLatexTypeFarm5Month = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 5')
            ->where('input_status', 1)
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');
        $sheet->setCellValue('C35', $totalFreshWeightFarm5Month);
        $sheet->setCellValue('C47', $totalFreshWeightLatexTypeFarm5Month);
        //Month7
        $totalFreshWeightFarm7Month = Rubber::where('farm_name', 'NÔNG TRƯỜNG 7')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');

        $totalFreshWeightLatexTypeFarm7Month = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 7')
            ->where('input_status', 1)
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');
        $sheet->setCellValue('C36', $totalFreshWeightFarm7Month);
        $sheet->setCellValue('C48', $totalFreshWeightLatexTypeFarm7Month);
        //Month8
        $totalFreshWeightFarm8Month = Rubber::where('farm_name', 'NÔNG TRƯỜNG 8')
            ->where('input_status', 1)
            ->where('latex_type', '!=', 'MỦ DÂY')
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');

        $totalFreshWeightLatexTypeFarm8Month = Rubber::where('latex_type', 'MỦ DÂY')
            ->where('farm_name', '=', 'NÔNG TRƯỜNG 8')
            ->where('input_status', 1)
            ->whereMonth('date', $month_bc)
            ->whereYear('date', $year_bc)
            ->sum('fresh_weight');
        $sheet->setCellValue('C37', $totalFreshWeightFarm8Month);
        $sheet->setCellValue('C49', $totalFreshWeightLatexTypeFarm8Month);

        // Tạo file Excel mới với tên khác, không ghi đè lên file gốc
        $fileName = 'Báo_Cáo_Trạm Cân_' . $start_date_bc . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save(public_path('/excelFiles' . $fileName));
        // Trả file về cho người dùng tải xuống
        return response()->download(public_path('/excelFiles/' . $fileName));
    }
}