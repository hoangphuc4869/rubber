<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function updateLots()
    {
        // $client = new Client();
        // $token = '30dd7d4f-bbd4-4c23-b7df-13e5a9e1055f';
        // $url = 'https://kcs.chusekptrubber.vn/api/certificate?rank=20&year_test=2024';

        // try {
        //     $response = $client->request('GET', $url, [
        //         'headers' => [
        //             'Authorization' => 'Bearer ' . $token,
        //             'Accept'        => 'application/json',
        //         ],
        //     ]);

        //     $data = json_decode($response->getBody(), true); 

        //     $lotNumbers = [];

            
        //     foreach ($data['results']['data'] as $item) {
        //         $lots = explode(' , ', $item['lot_no']); 
        //         $lotNumbers = array_merge($lotNumbers, $lots);
        //     }

           
        //     foreach ($lotNumbers as $lotNo) {
        //         $lot = Batch::where('batch_code', $lotNo)->first(); 
        //         if ($lot) {
        //             $lot->checked = 1; 
        //             $lot->save();
        //         }
        //     }

        //     // return response()->json(['success' => true, 'message' => 'Lots updated successfully.' . implode(', ', $lotNumbers)]);
        //     return redirect()->back()->with('success', 'Cập nhật thành công');
        // } catch (\Exception $e) {
        //     return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        // }

        $batches = Batch::all();
        if($batches){
            foreach ($batches as $batch) {
                $batch->checked = 1;
                $batch->save();
            }
        }

        return redirect()->back()->with('success', 'Cập nhật thành công');
    }
}