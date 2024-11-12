<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckUserLoggedIn;
use Illuminate\Support\Facades\Auth;
use App\Models\Contract;
use App\Models\Shipment;

class ContractsApi extends Controller
{
    public function __construct()
    {
        $this->middleware(CheckUserLoggedIn::class)->except(['login']);
    }
    public function getContracts()
    {

        $user = Auth::user();
        $customer = $user->customer;

        if($customer){
            $customer_info = [
                "id" => $customer->id,
                "name" => $customer->name,
                "email" => $customer->email,
                "phone" => $customer->phone,
                "description" => $customer->description,
                "company" => $customer->company,
            ];

            $contracts = $customer->contracts->map(function ($contract) {
                return [
                        'id' => $contract->id, 
                        'mahd' => $contract->contract_number, 
                        'ngayhd' => $contract->contract_date, 
                        'so_ngay_hd' => null, 
                        'loai_hd' => $contract->contract_type->name, 
                    ];
            });

            $result = [
                'customer_info' => $customer_info,
                'contracts' => $contracts,
            ];

            return response()->json([
                'status' => 1,
                'contracts_info' => $result
            ]);
        }

        return response()->json([
            'status' => 0,
            'contracts_info' => "Không có hợp đồng"
        ]);


        
    }

    public function getDetailContract(Request $request)
    {

        $user = Auth::user();
        
        $customer = $user->customer;


        // dd($request->all());

        $customer_info = [
            "id" => $customer->id,
            "name" => $customer->name,
            "email" => $customer->email,
            "phone" => $customer->phone,
            "description" => $customer->description,
            "company" => $customer->company,
        ];

        $contract_number = trim($request->contract_number, '"');
        
        $contract_detail =  Contract::where('contract_number', $contract_number)->with('contract_type')->first();


        if ($contract_detail && $contract_detail->customer_id == $customer->id) {

            $contract_detail->file_scan_pdf = asset($contract_detail->file_scan_pdf);

            $contract_detail->count_contract = $contract_detail->count_contract . " tấn";


            $shipments = Shipment::where('so_hop_dong', $contract_detail->contract_number)->get();

            $shipments = $shipments->map(function ($shipment) {
                $shipment->pdf = $shipment->pdf ? asset($shipment->pdf) : null;
                $shipment->plots = [
                    [
                        "id" => 1,
                        "code" => "dadasda",
                        "factory" => "dasdada",
                        "supplier_code" => "dsadadsa",
                        "created_at" => "2024-10-08 15:51:23",
                        "updated_at" => "2024-10-08 15:51:23",
                        "pivot" => [
                            [
                                "contract_id" => "dsadas",
                                "plots_id" => "dsadasdasda"
                            ]
                        ]
                    ]
                ]; 

                return $shipment; // Return the modified shipment
            });

            // Attach the modified shipments to the contract detail
            $contract_detail->shipments = $shipments; // Add shipments to contract detail

            $result = [
                'customer_info' => $customer_info,
                'contract_detail' => $contract_detail,
            ];

            return response()->json([
                'status' => 1,
                'contracts_info' => $result,
            ]);
        }

        return response()->json([
                'status' => 0,
                'message' => "Không có quyền truy cập"
            ]);

        
    }
}