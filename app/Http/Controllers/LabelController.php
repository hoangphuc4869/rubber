<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 
use PhpOffice\PhpWord\PhpWord;  
use PhpOffice\PhpWord\IOFactory;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter; 
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

use App\Exports\DrumExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Batch;

use PhpOffice\PhpWord\TemplateProcessor; 

class LabelController extends Controller
{
    public function export(Request $request)  
    {  
        $templateProcessor = new TemplateProcessor(public_path('labelFiles/label.docx'));  
        $ids = explode(',', $request->ids);  
        
        $logos = ['NLNT1', 'NLNT2', 'NLNT3', 'NLNT4', 'NLNT5','NLNT6','NLNT7','NLNT8'];  
        
        $farms = [  
            'NLNT1' => 'Farm 1',  
            'NLNT2' => 'Farm 2',  
            'NLNT3' => 'Farm 3',  
            'NLNT4' => 'Farm 4',  
            'NLNT5' => 'Farm 5',  
            'NLNT6' => 'Farm 6',  
            'NLNT7' => 'Farm 7',  
            'NLNT8' => 'Farm 8',  
            'NLTNSR' => 'TNSR',  
            'NLTM' => 'Sourced Materials',  
        ];  
        
        $batches = [];  
        $qr_codes = [];
        
        foreach ($ids as $id) {  
            $batch = Batch::findOrFail($id);  
            $heatedEnd = \Carbon\Carbon::parse($batch->drums->last()->heated_end)->format('H:i');  
            $shift = \Carbon\Carbon::parse($heatedEnd)->between(\Carbon\Carbon::parse('06:30'), \Carbon\Carbon::parse('18:30')) ? 'No 1 (A)' : 'No 2 (B)';  
            $source_materials = isset($farms[$batch->from_farm]) ? $farms[$batch->from_farm] : 'Unknown Farm';  
            


            $qrCode = new QrCode(
                data: $batch->batch_code,
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::Low,
                // size: 600,
                margin: 10, 
            );
        
            
            $writer = new PngWriter();  
        
            $result = $writer->write($qrCode);  
            
            $qrCodeFilePath = tempnam(sys_get_temp_dir(), 'qr_code_') . '.png';  
            file_put_contents($qrCodeFilePath, $result->getString()); 

            $qr_codes[] = $qrCodeFilePath;

            
            $batches[] = [  
                'lot_code' => $batch->batch_code,  
                'processing_date' => \Carbon\Carbon::parse($batch->drums->last()->heated_date)->format('Y-m-d'),  
                'production_shift' => $shift,   
                'tracking_sheet_no' =>   
                    ($batch->drums[0]->rolling?->location ?? '') .   
                    ($batch->drums[0]->rolling?->date_curing   
                        ? \Carbon\Carbon::parse($batch->drums[0]->rolling->date_curing)->format('ymd')   
                        : ''),  
                'source_materials' => $source_materials,  
                'pageBreakHere' => '<w:p><w:r><w:br w:type="page"/></w:r></w:p>',   
                'logo' => in_array($batch->from_farm, $logos),  
            ];  
        } 


        
        

        $templateProcessor->cloneBlock('block_name', 0, true, false, $batches);  

        foreach ($batches as $index => $batch) {  
            if ($batch['logo']) {  
                $templateProcessor->setImageValue('eudr', public_path('labelFiles/eudr.png'));  
            } else {  
                $templateProcessor->setValue('eudr', '');  
            }  
            

            $templateProcessor->setImageValue('qr_code', [  
                'path' => $qr_codes[$index],  
                'width' => 150, 
                'height' => 150, 
                'ratio' => false,  
            ], 1);  
        }  



        $temp_file = tempnam(sys_get_temp_dir(), 'Rubber_Processing_Factory_') . '.docx';  
        $templateProcessor->saveAs($temp_file);  

        return response()->download($temp_file, 'labels.docx')->deleteFileAfterSend(true);  
    }   



    public function exportDrums()
    {
        // $path = public_path('labelFiles/epkien_donggoi.xlsx');

        return Excel::download(new DrumExport, 'drum_export.xlsx');
    }





   
}