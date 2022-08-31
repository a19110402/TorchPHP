<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use app\models\User;
use Illuminate\Support\Facades\Hash;
use stdClass;

class FedexController extends Controller
{
    public function fedexOptions(Request $request){
    //    $response = $this->postToken($request);

        return view('fedex.fedexOptions');
    }
    public function index(){
        //$response = $this->postToken()['expires_in'];
        //return view('fedex.index', compact('response'));
        return view('fedex.index');
    }

    public function auth(){
        return view('fedex.auth');
    }

    public function findLocationForm()
    {   
        $countryCodes = $this->getCountryCode(); 
        return view('fedex.findLocationForm', compact('countryCodes'));
    }

    public function globalTradeForm(){
        $countryCodes = $this->getCountryCode(); 
        return view('fedex.globalTrade', compact('countryCodes'));
    }

    public function GroundDayCloseForm()
    {
        return view('fedex.groundDayClose');
    }

    public function serviceAvailabilityForm(){
        return view('fedex.serviceAvailability');
    }

    public function reprintDayCloseRequest(Request $request){
        $requestJson = json_decode($request->get('reprint_day_close'));
        $body = [
            "closeReqType"=> "GCDR",//$requestJson->{'closeReqType'}, //=> "GCDR",
            "reprintOption"=> "BY_SHIP_DATE",//$requestJson->{'closeReqType'}, //=> "GCDR",
            "groundServiceCategory"=> "GROUND",//$requestJson->{'groundServiceCategory'}, //=> "GROUND",
            "accountNumber" => [
                "value"=> "510051408"//$requestJson->{'accountNumber'},//=>"510051408",
            ],
            //"closeDate" => "2022-04-16",//$requestJson->{'closeDate'},//=> "2022-04-16",
        ];
        $response = $this->makeFedexJsonPostRequest(
            env('GROUND_DAY_CLOSE_TEST_URL'),
            env('GROUND_DAY_CLOSE_PRODUCTION_URL'),
            $body
        ); 
        return response()->json([
            'validateAddressJson' => $response->json(),
            'statusCode' => $response->status(),
            'cookie' => $body,
        ]);
    }

    public function GroundDayCloseRequest(Request $request){
        $requestJson = json_decode($request->get('ground_day_close'));
        $body = [
            "accountNumber" => [
                "value"=>$requestJson->{'accountNumber'},//=>"510051408",
            ],
            "closeReqType"=> $requestJson->{'closeReqType'}, //=> "GCDR",
            "closeDate" => $requestJson->{'closeDate'},//=> "2022-04-16",
            "groundServiceCategory"=> $requestJson->{'groundServiceCategory'}, //=> "GROUND",
        ];
        $response = $this->makeFedexJsonPutRequest(
            env('GROUND_DAY_CLOSE_TEST_URL'),
            env('GROUND_DAY_CLOSE_PRODUCTION_URL'),
            $body
        ); 
        return response()->json([
            'validateAddressJson' => $response->json(),
            'statusCode' => $response->status(),
            'cookie' => $body,
        ]);
    }

    // public function postToken(Request $request){
    //     $response = HTTP::asForm()->post(env('PRODUCTION_ENV') ?
    //     env('AUTHORIZATION_API_PRODUCITON_URL'): env('AUTHORIZATION_API_TEST_URL'), [
    //         'grant_type' => 'client_credentials',
    //         'client_id' => env('PRODUCTION_ENV') ?
    //         env('CLIENT_ID_FEDEX_PRODUCTION'): env('CLIENT_ID_FEDEX_TEST'),
    //         'client_secret' => env('PRODUCTION_ENV') ?
    //         env('CLIENT_SECRET_FEDEX_PRODUCTION'): env('CLIENT_SECRET_FEDEX_TEST'),
    //         'child_Key' => $request->get('client_id'),
    //         'child_secret' => $request->get('child_secret'),
    //     ]);
    //     $responseJson = $response;
    //     $responseJson->json();
    //     Cookie::queue(Cookie::forget('access_token_fedex'));
    //     Cookie::queue(Cookie::forget('token_type'));
    //     Cookie::queue(Cookie::forget('scope'));
    //     Cookie::queue(Cookie::make('access_token_fedex', $responseJson['access_token'], $responseJson['expires_in']));
    //     Cookie::queue(Cookie::make('token_type', $responseJson['token_type'], $responseJson['expires_in']));
    //     Cookie::queue(Cookie::make('scope', $responseJson['scope'], $responseJson['expires_in']));
    //     return response()->json([
    //         'answer' => $responseJson['token_type']." ".$responseJson['access_token'],
    //         'statusCode' => $response->status(),
    //         'cookie' => Cookie::get('token_type')." ".Cookie::get('access_token_fedex'),
    //     ]);
    // }
    public function postToken(){
        $response = HTTP::asForm()->post(env('PRODUCTION_ENV') ?
        env('AUTHORIZATION_API_PRODUCITON_URL'): env('AUTHORIZATION_API_TEST_URL'), [
            'grant_type' => 'client_credentials',
            'client_id' => env('PRODUCTION_ENV') ?
            env('CLIENT_ID_FEDEX_PRODUCTION'): env('CLIENT_ID_FEDEX_TEST'),
            'client_secret' => env('PRODUCTION_ENV') ?
            env('CLIENT_SECRET_FEDEX_PRODUCTION'): env('CLIENT_SECRET_FEDEX_TEST')
        ]);
        $responseJson = $response;
        $responseJson->json();
        Cookie::queue(Cookie::forget('access_token_fedex'));
        Cookie::queue(Cookie::forget('token_type'));
        Cookie::queue(Cookie::forget('scope'));
        Cookie::queue(Cookie::make('access_token_fedex', $responseJson['access_token'], $responseJson['expires_in']));
        Cookie::queue(Cookie::make('token_type', $responseJson['token_type'], $responseJson['expires_in']));
        Cookie::queue(Cookie::make('scope', $responseJson['scope'], $responseJson['expires_in']));
        return response()->json([
            'answer' => $responseJson['token_type']." ".$responseJson['access_token'],
            'statusCode' => $response->status(),
            'cookie' => Cookie::get('token_type')." ".Cookie::get('access_token_fedex'),
        ]);
    }

    public function findLocationRequest(Request $request)
    {
        $locationJson = json_decode($request->get('find_location'));
        $body = [
            "location" => [
                "address"=>[
                    "countryCode"=>$locationJson->{'country_code'},
                    "city"=>$locationJson->{'city'},
                ],
                "longLat"=>[
                    "latitude"=>$locationJson->{'latitude'},
                    "longitude"=>$locationJson->{'longitude'},
                ],
            ]
        ];
        $response = $this->makeFedexJsonPostRequest(
            env('FIND_LOCATION_API_TEST_URL'),
            env('FIND_LOCATION_API_PRODUCITON_URL'),
            $body
        ); 
        /*
        $response = HTTP::withHeaders([
            'content-type'=>'application/json',
            'authorization'=> Cookie::get('token_type')." ".Cookie::get('access_token_fedex'),
        ])->post(env('PRODUCTION_ENV') ?
            env('FIND_LOCATION_API_PRODUCITON_URL'): env('FIND_LOCATION_API_TEST_URL'), [
            'location' => $body,
        ]);
        */
        return response()->json([
            'validateAddressJson' => $response->json(),
            'statusCode' => $response->status(),
            'cookie' => $body,
        ]);
    }
    public function globalTradeRequest(Request $request){
        $requestJson = json_decode($request->get('global_trade'));
        $body = [
            "originAddress" => [
                "countryCode"=>$requestJson->{'countryCodeOrigin'},
                //"postalCode"=>"75063",
                //"stateOrProvinceCode"=>"TX"
            ],
            "destinationAddress" => [
                "countryCode"=>$requestJson->{'countryCodeDestination'},
                //"postalCode"=>"75063",
                //"stateOrProvinceCode"=>"TX"
            ],
            "carrierCode" => $requestJson->{'carrierCode'},
            /*"totalWeight" => [
                "units"=>"KG",
                "value"=>68
            ],*/
            "customsClearanceDetail" => [
                "customsValue" => [
                    "amount"=>"",
                    "currency"=>""
                ],
                "commodities" => array(
                    [
                        "harmonizedCode"=>$requestJson->{'harmonizedCode'},
                    ]
                ),
            ],
        ];
        $response = $this->makeFedexJsonPostRequest(
            env('GLOBAL_TRADE_API_TEST_URL'),
            env('GLOBAL_TRADE_API_PRODUCITON_URL'),
            $body
        ); 
        return response()->json([
            'validateAddressJson' => $response->json(),
            'statusCode' => $response->status(),
            'cookie' => $body,
        ]);
    }

    public function validationFedexRequest(Request $request){
        $addressJson = json_decode($request->get('address_to_validate'));
        $body = array(
                [
                    "address"=>[
                        "streetLines"=>array(
                            $addressJson->{'street_lines'},
                        ),
                        "countryCode"=>$addressJson->{'country_code'},
                    ],
                ]
            );
        $response = HTTP::withHeaders([
            'content-type'=>'application/json',
            'authorization'=> Cookie::get('token_type')." ".Cookie::get('access_token_fedex'),
        ])->post(env('PRODUCTION_ENV') ?
            env('ADDRES_VALIDATION_PRODUCTION_URL'): env('ADDRES_VALIDATION_TEST_URL'), [
            'addressesToValidate' => $body,
        ]);
        return response()->json([
            'validateAddressJson' => $response->json(),
            'statusCode' => $response->status(),
            'cookie' => $body,
        ]);
    }

    public function addresValidation(Request $request){
        $jayParsedAry = [
            "Arabic" => "ar_AE", 
            "Bulgarian" => "bg_BG", 
            "Chinese" => "zh_CN", 
            "Czech" => "cs_CZ", 
            "Danish" => "da_DK", 
            "Dutch" => "nl_NL", 
            "English" => "en_CA", 
            "English (United States)" => "en_US", 
            "Estonian" => "et_EE", 
            "Finnish" => "fi_FI", 
            "French" => "fr_CA", 
            "German" => "de_DE", 
            "Greek" => "el_GR", 
            "Hungarian" => "hu_HU", 
            "Italian" => "it_IT", 
            "Japanese" => "ja_JP", 
            "Korean" => "ko_KR", 
            "Latvian" => "lv_LV", 
            "Lithuanian" => "lt_LT", 
            "Norwegian" => "no_NO", 
            "Polish" => "pl_PL", 
            "Portuguese" => "pt_BR", 
            "Romanian" => "ro_RO", 
            "Russian" => "ru_RU", 
            "Slovak" => "sk_SK", 
            "Slovenian" => "sl_SI", 
            "Spanish" => "es_AR", 
            "Swedish" => "sv_SE", 
            "Thai" => "th_TH", 
            "Turkish" => "tr_TR", 
            "Ukrainian" => "uk_UA", 
            "Vietnamese" => "ar_AE" 
         ]; 
          
        $countryCode = $this->getCountryCode(); 
        return view('fedex.addresValidation', compact('jayParsedAry'), compact('countryCode'));
    }
    public function retriveServicePackagingOptRequest(Request $request){
        $requestJson = json_decode($request->get('service_availability'));
        $body = [
            "requestedShipment" => [
                "shipper" => [
                    "address" => [
                        "postalCode" => "75063",
                        "countryCode" => "US",
                    ],
                ],
                "recipients" => array([
                    "address" => [
                        "postalCode" => "38017",
                        "countryCode" => "US",
                    ],
                ]),
                "requestedPackageLineItems"=> array(
                    [
                        "weight"=> [
                            "units"=> "LB",
                            "value"=> 10,
                        ],
                        "packageSpecialServices"=> [
                            "codDetail"=> [
                                "codCollectionAmount"=> [
                                    "amount" => 12.45,
                                    "currency" => "USD",
                                ],
                            ],
                            "alcoholDetail"=> [
                                "alcoholRecipientType" => "CONSUMER",
                                "shipperAgreementType" => "retailer",
                            ],
                            "dryIceWeight"=> [
                                "units" => "LB",
                                "value" => 10,
                            ],
                        ],
                    ],
                ),
            ],
            "carrierCodes" => array(
                "FDXE",
                "FDXG"
            ),
        ];
        $response = $this->makeFedexJsonPostRequest(
            env('RETRIEVE_SERVICE_PACKAGING_OPT_TEST_URL'),
            env('RETRIEVE_SERVICE_PACKAGING_OPT_PRODUCTION_URL'),
            $body
        ); 
        return response()->json([
            'validateAddressJson' => $response->json(),
            'statusCode' => $response->status(),
            'cookie' => $body,
        ]);
    }

    //OPENSHIP API FEDEX////////////////////////////////////////////////////////////////////
    public function openShip(){
        $countryCode = $this->getCountryCode();
        $serviceType = $this->getServiceType();
        $packageType = $this->getPackageType();
        $pickupType =  $this->getPickupType();

        return view('fedex.openShip', compact('countryCode', 'serviceType', 'packageType', 'pickupType'));
    }
    public function createOpenShipmentRequest(Request $request){
        $requestJson = json_decode($request->get('open_shipment'));
        $responseCreate = $this->makeFedexJsonPostRequest(
            env('CREATE_OPEN_SHIP_TEST_URL'), env('CREATE_OPEN_SHIP_PRODUCTION_URL'),
            $requestJson
        );
        
        switch ($responseCreate->status()){
            case '401':
                return response()->json([
                    'createOpenShip' => $responseCreate,
                    'statusCode'=> $responseCreate->status(),
                    'cookie'=>$requestJson
                ]);
                // $responseToken=$this->postToken($request);

                // return response()->json([    
                // 'postToken'=>$responseToken,
                // 'statusCode'=>$responseToken->status(),
                // ]);
            //     // return response()->json([
            //     //     'API' => 'authToken',
            //     //     'statusCodeToken' => $responseToken->status(),
            //     //     'createOpenShip' => $responseCreate->json(),
            //     //     'statusCode' => $responseCreate->status(),
            //     // ]);
            // }
            // else{
            //     return response()->json([
            //         'statusCodeToken' => $responseToken->status(),
            //         'createOpenShip' => $responseCreate->json(),
            //         'statusCode' => $responseCreate->status(),
            //     ]);
            // }
            // //This code is for monitoring the response of an API
            // // return response()->json([
            // //     'createOpenShip' => $response->json(),
            // //     'statusCode' => $response->status(),
            // //     'cookie' => $requestJson
            // // ]
            // // );

                break;
            case '200':
                dd($responseCreate->status());
                break;
            default:
            return response()->json([
                'createOpenShip'=>$responseCreate->json(),
                'statusCode'=>$responseCreate->status(),
            ]);
        }


        // $requestJson = json_decode($request->get('open_shipment'));
        // $responseToken = $this->postToken($request);
        // if ($responseToken->status() == '200'){
        //     $response = $this->makeFedexJsonPostRequest(
        //         env('CREATE_OPEN_SHIP_TEST_URL'),
        //         env('CREATE_OPEN_SHIP_PRODUCTION_URL'),
        //         $requestJson
        //     ); 
        //     return response()->json([
        //         'validateAddressJson' => $response->json(),
        //         'statusCode' => $response->status(),
        //         'statusToken' => $responseToken->status(),
        //         'cookie' => $requestJson,
        //     ]);
        // }
        // else{
        //     return response()->json([
        //         'Response' => $responseToken,
        //         'AuthenticationProblem' => 'true'
        //     ]);
        }
    
    public function confirmOpenShipmentRequest(Request $request){
        $requestJson = json_decode($request->get('open_shipment'));
        $body = [
            "accountNumber"=> [
                "value"=> "your account number",
            ],
            "index"=> "Test1234",
            "labelResponseOptions"=> "URL_ONLY",
            "labelSpecification" => [
                "shipper" => [
                    "labelStockType"=> "PAPER_85X11_TOP_HALF_LABEL",
                    "imageType"=> "PDF",
                ],
            ],
        ];
        $response = $this->makeFedexJsonPostRequest(
            env('ALTER_OPEN_SHIP_TEST_URL'),
            env('ALTER_OPEN_SHIP_PRODUCTION_URL'),
            $body
        ); 
        return response()->json([
            'validateAddressJson' => $response->json(),
            'statusCode' => $response->status(),
            'cookie' => $body,
        ]);
    }
    

    
    public function modifyOpenShipmentRequest(Request $request){
        $requestJson = json_decode($request->put('open_shipment'));
        
        $response = $this->makeFedexJsonPutRequest(
            env('ALTER_OPEN_SHIP_TEST_URL'),
            env('ALTER_OPEN_SHIP_PRODUCTION_URL'),
            $requestJson
        );
        return response()->json([
            'modifyOpenShip'=> $response->json(),
            'statusCode' => $response->status(),
            'cookie' => $requestJson,
        ]);
    }
    
    #PROBLEMA CON EL TRACKING NUMBER
    public function modifyOpenShipmentPackagesRequest(Request $request){
        $request = json_decode($request->post('modify_openShipment'));
        
        $body = json_decode('{
            "accountNumber": {
              "value": '+ $this->getAccountShipmentNumber()+ '
            },
            "index": "Test1234",
            "trackingId": {
              "trackingIdType": "FEDEX",
              "formId": "0263",
              "trackingNumber": "794953535000"
            },
            "requestedPackageLineItem": {
              "weight": {
                "units": "LB",
                "value": "20"
              },
              "dimensions": {
                "length": "12",
                "height": "12",
                "width": "16",
                "units": "IN"
              },
              "declaredValue": {
                "currency": "USD",
                "amount": "100"
              }
            }
          }');
        $response = $this ->makeFedexJsonPutRequest(
            env('ALTER_PACKAGES_OPEN_SHIP_TEST_URL'),
            env('ALTER_PACKAGES_SHIP_PRODUCTION_URL'),
            $body
        );
        return response() ->json([
            'modifyShipPackages'=> $response->json(),
            'statusCode'=> $response->status(),
            'cookie'=> $body
        ]);
    }
    #LISTA
    public function addOpenShipmentPackagesRequest(Request $request){
        $requestJson = json_decode($request->post('add_openShipmentPackages'));
        // $response = $this->getTokenValidation($request->post('add_openShipmentPackages'));
        // return response() ->json([
        //     'cookie' => $response
        // ]);
        $responseToken = $this->postToken($request);
        if ($responseToken->status() == '200'){
            $response = $this->makeFedexJsonPostRequest(
                env('ALTER_PACKAGES_OPEN_SHIP_TEST_URL'),
                env('ALTER_PACKAGES_SHIP_PRODUCTION_URL'),
                $requestJson
            );
            return response() -> json([
                'addOpenShipmentPackages'=>$response->json(),
                'statusCode'=> $response->status(),
                'cookie'=> $response
            ]);
        }
        else{
            return response()->json([
                'Response'=>$responseToken,
                'AuthenticationProblem'=>'true'
            ]);
        }
    }
    
    public function deleteOpenShipmentPackagesRequest(Request $request){
        # code...
    }
    
    public function retriveOpenShipmentPackagesRequest(Request $request){
        $request = json_decode($request->post('retrieve_openShipmentPackage'));
        $body = json_decode('{
            "accountNumber": {
              "value": "510087020"
            },
            "index": "Test1234",
            "trackingId": {
              "trackingIdType": "FEDEX",
              "formId": "0891",
              "trackingNumber": "794631811751"
            }
          }');
        
        $response = $this->makeFedexJsonPostRequest(
            env('RETRIVE_OPEN_SHIP_TEST_URL'),
            env('RETRIVE_OPEN_SHIP_PRODUCTION_URL'),
            $body
        );
        return response() -> json([
            'retrieveOpenShipmentPackages'=>$response->json(),
            'statusCode'=>$response->status(),
            'cookie'=>$body
        ]);
    }

    //API RATE AND TRANSIT TIMES
    public function rateAndTransitTimes(Request $request){
        $countryCode = $this->getCountryCode();
        // $responseToken = $this->postToken();
        return view('fedex.rateAndTransitTimes', compact('countryCode'));
        }

    public function rateAndTransitTimesRequest(Request $request){
        $requestJson = json_decode($request->post('json'));
        $requestJson->fedex->accountNumber->value = env('SHIPPER_ACCOUNT_TEST');
        $requestJson->dhl->RateRequest->RequestedShipment->Account= env('ACCOUNT_DHL_TEST');
        // dd($requestJson->ups);
        //                  FEDEX
        $responseFedex = $this->makeFedexJsonPostRequest(
            env('RATE_AND_TRANSIT_TIMES_URL'), 
            env('RATE_AND_TRANSIT_TIMES_PRODUCTION_URL'),
             $requestJson->fedex
            );
        //                  DHL
        $responseDhl = $this->makeDHLJsonPostRequest(
            env('RATE_REQUEST_TEST_URL_DHL'), 
            env('RATE_REQUEST_PRODUCTION_URL_DHL'),
            $requestJson->dhl
        );
        //                  UPS
        $responseUps = $this->makeUPSJsonPostRequest(
            env('RATE_REQUEST_TEST_URL_UPS'), 
            env('RATE_REQUEST_PRODUCTION_URL_UPS'),
            $requestJson->ups
        );
        // dd(json_encode($responseUps));
        
        return response()->json([
            'fedexResponse' => [
                'response' => $responseFedex ->json(),
                'statusCode' => $responseFedex->status()
            ], 
            'dhlResponse' => [
                'response' => $responseDhl->json(),
            ],
            'upsResponse' => [
                'response'  =>  $responseUps->json(),
                'statusCode' => $responseUps->status()
            ]
        ]);
    }
    public function rateAndServices(Request $request)
    {
        $requestJson = json_decode($request->post('json'));
        switch($requestJson->delivery)
        {
            case 'fedex':
                $requestJson->fedex->accountNumber->value = env('SHIPPER_ACCOUNT_TEST');
                $response = $this->makeFedexJsonPostRequest(
                    env('RATE_AND_TRANSIT_TIMES_URL'), 
                    env('RATE_AND_TRANSIT_TIMES_PRODUCTION_URL'),
                     $requestJson->fedex
                    );
                        
                break;
            case 'dhl':
                $requestJson->dhl->RateRequest->RequestedShipment->Account= env('ACCOUNT_DHL_TEST');
                $response = $this->makeDHLJsonPostRequest(
                    env('RATE_REQUEST_TEST_URL_DHL'), 
                    env('RATE_REQUEST_PRODUCTION_URL_DHL'),
                    $requestJson->dhl
                );
                break;
            case 'ups':
                $response = $this->makeUPSJsonPostRequest(
                    env('RATE_REQUEST_TEST_URL_UPS'), 
                    env('RATE_REQUEST_PRODUCTION_URL_UPS'),
                    $requestJson->ups
                );
                break;
        }
        return response()->json([
            'fedexResponse' => [
                'response' => $response ->json(),
                'statusCode' => $response->status()
            ]
        ]);
    }
    //API VALIDATE POSTAL CODE 
    public function validatePostalCodeRequest(Request $request)
    {
        $requestJson = json_decode($request->post('json'));
        $response = $this->makeFedexJsonPostRequest(
            env('VALIDATE_POSTAL_CODE_API_URL'),
            env('VALIDATE_POSTAL_CODE_PRODUCTION_URL'),
            $requestJson
        );
        return response()->json([
            'fedexResponse'=> [
                'validation' => $response->json(),
                'statusCode'=> $response->status(),
            ]
        ]);
    }
    //API Service Availability
    public function serviceAvailabilityRequest(Request $request)
    {
        $requestJson = json_decode($request->post('json'));
        $response = $this->makeFedexJsonPostRequest(
            env('VALIDATE_SERVICE_AVAILABILITY_TEST_URL'),
            env('VALIDATE_SERVICE_AVAILABILITY_PRODUCTION_URL'),
            $requestJson
        );
        return response()->json([
            'fedexResponse'=> [
                'validation' => $response->json(),
                'statusCode'=> $response->status(),
            ]
        ]);
    }
    //SHIPMENTS
    public function proveShipments(Request $request)
    {
        $countryCode = $this->getCountryCode();
        // $serviceType = $this->getServiceType();
        $packingType = $this->getPackageType();
        $pickupType = $this->getPickupType();
        return view('fedex.proveShipments', compact('countryCode', 'packingType', 'pickupType'));
    }

    public function shipments(Request $request){
        $countryCode = $this->getCountryCode();
        // $serviceType = $this->getServiceType();
        $packingType = $this->getPackageType();
        $pickupType = $this->getPickupType();
        return view('fedex.shipments', compact('countryCode', 'packingType', 'pickupType'));
    }

    public function shipmentsRequest(Request $request){
        $requestJson = json_decode($request->post('json'));
        switch ($requestJson->delivery)
        {
            case 'fedex':
                $body = $this->setShipmentBody($request);
                   $responseFedex = $this->makeFedexJsonPostRequest(
                        env('SHIP_API_URL'),
                        env('SHIP_API_PRODUCTION_URL'),
                        $body
                    );
                    return response()->json([
                        'fedexResponse' => [
                            'response' => $responseFedex->json(),
                            'statusCode' => $responseFedex->status()
                        ]
                    ]);
                // $validateFedex = $this->makeFedexJsonPostRequest(
                //     env('VALIDATE_SHIP_API_URL'),
                //     env('VALIDATE_SHIP_API_PRODUCTION_URL'),
                //     $body
                // );
                // if($validateFedex->status() == '200'){
                //     $responseFedex = $this->makeFedexJsonPostRequest(
                //         env('SHIP_API_URL'),
                //         env('SHIP_API_PRODUCTION_URL'),
                //         $body
                //     );
                //     return response()->json([
                //         'fedexResponse' => [
                //             'response' => $responseFedex,
                //             'statusCode' => $responseFedex->status()
                //         ]
                //     ]);
                // }
                // else{
                //     return response()->json([
                //         'fedexResponse' => [
                //             'validationResponse' => $validateFedex,
                //             'statusCode' => $validateFedex->status()
                //         ]
                //     ]);
                // }
                break;
            case 'dhl':
                $body = $this->setShipmentBody($request);
                $responseDhl = $this->makeDHLJsonPostRequest(
                    env('SHIPMENT_REQUEST_TEST_URL_DHL'),
                    env('SHIPMENT_REQUEST_PRODUCTION_URL_DHL'),
                    $body
                );
                return response()->json([
                    'fedexResponse' => [
                        'response' => $responseDhl->json(),
                        'statusCode' => $responseDhl->status()
                    ]
                ]);
                //////////////////////////////////////////
                // {
                //     "ShipmentRequest": {
                //        "RequestedShipment": {
                //           "ShipmentInfo": {
                //                "DropOffType": "REGULAR_PICKUP",
                //              "ServiceType": "N",
                //              "Account": 999999999,
                //              "Currency": "MXN",
                //              "UnitOfMeasurement": "SI",
                //              "PackagesCount": 1,
                //             "LabelOptions": {
                //               "RequestWaybillDocument": "Y",
                //               "HideAccountInWaybillDocument": "Y"
                //             },
                //              "LabelType": "ZPL"
                //           },
                //           "ShipTimestamp": "2020-09-03T17:00:00GMT-06:00",
                //           "PaymentInfo": "DDU",
                //           "InternationalDetail": {
                //              "Commodities": {
                //                 "NumberOfPieces": 1,
                //                 "Description": "Test"
                //              },
                //             "Content" : "NON_DOCUMENTS"
                //           },
                //           "Ship": {
                //              "Shipper": {
                //                 "Contact": {
                //                    "PersonName": "TEST",
                //                    "CompanyName": "TEST",
                //                    "PhoneNumber": "55-55-55-55",
                //                    "EmailAddress": "test@gmail.com"
                //                 },
                //                 "Address": {
                //                    "StreetLines": "Prolongacion Hidalgo",
                //                    "City": "Mexico",
                //                    "PostalCode": "58741",
                //                    "CountryCode": "MX"
                //                 }
                //              },
                //              "Recipient": {
                //                 "Contact": {
                //                    "PersonName": "TEST",
                //                    "CompanyName": "TEST",
                //                    "PhoneNumber": "11-11-11-11",
                //                    "EmailAddress": "test@gmail.com"
                //                 },
                //                 "Address": {
                //                    "StreetLines": "Mariano Escobedo",
                //                    "City": "Mexico",
                //                    "PostalCode": "59920",
                //                    "CountryCode": "MX"
                //                 }
                //              }
                //           },
                //           "Packages": {
                //              "RequestedPackages": {
                //                 "@number": 1,
                //                 "InsuredValue": 10,
                //                 "Weight": 10,
                //                 "Dimensions": {
                //                    "Length": 10,
                //                    "Width": 10,
                //                    "Height": 10
                //                 },
                //                 "CustomerReferences": "FOLIO WMS 12345678"
                //              }
                //           }
                //        }
                //     }
                //  }

                //////////////////////////////////////////
                break;
            case 'ups':
                $body = $this->setShipmentBody($request);
                $responseUps = $this->makeUPSJsonPostRequest(env('SHIP_API_URL_UPS'), env('SHIP_API_PRODUCTION_URL_UPS '), $body);
                return response()->json([
                    'upsResponse'=>[
                        'response' => $responseUps -> json(),
                        'statusCode' => $responseUps -> status()
                    ]
                ]);
                break;
        }  
    }
    public function cancelShipmentRequest(Request $request){
        $requestJson = json_decode($request->post('json'));
        $requestJson->accountNumber->value = env('SHIPPER_ACCOUNT_TEST');
        $responseFedex = $this->makeFedexJsonPutRequest(
            env('SHIP_API_URL'),
            env('VALIDATE_SHIP_API_PRODUCTION_URL'),
            $requestJson
        );
        return response()->json([
            'fedexResponse' => [
                'response' => $responseFedex->json(),
                'statusCode' => $responseFedex->status()
            ]
        ]);
    }

    //API TRACKING

    public function tracking()
    {
        return view('fedex.tracking');
    }
    public function trackingRequest(Request $request)
    {
        $requestJson = json_decode($request->post('json'));
        switch ($requestJson->companyName)
        {
            case 'fedex':
                $body = [
                    "includeDetailedScans" => true,
                    "trackingInfo" => [
                        [
                        "trackingNumberInfo"=> [
                            "trackingNumber"=> $requestJson->trackingNumber,
                        ]
                    ]
                    ]
                        ];
                $responseFedex = $this->makeFedexJsonPostRequest(
                    env('TRACKING_API_URL'),
                    env('TRACKING_API_PRODUCTION_URL'),
                    $body
                );
                return response()->json([
                    'fedexResponse' =>[
                        'trackingResponse' => $responseFedex->json(),
                        'statusCode' => $responseFedex->status()
                    ] 
                ]);
                break;
        }
    }
    //|**********FEDEX JSON POST**********|
    public function resendFedexJsonPostRequest($urlTest, $urlProduction, $jsonArray, $token) {
        return $response = HTTP::withHeaders([
            'content-type'=>'application/json',
            'authorization'=> $token,
        ])->post(env('PRODUCTION_ENV') ? $urlProduction: $urlTest, $jsonArray);
    }
    public function makeFedexJsonPostRequest($urlTest, $urlProduction, $jsonArray) {
        return $response = HTTP::withHeaders([
            'content-type'=>'application/json',
            'authorization'=> Cookie::get('token_type')." ".Cookie::get('access_token_fedex'),
        ])->post(env('PRODUCTION_ENV') ? $urlProduction: $urlTest, $jsonArray);
    }
    
    public function makeFedexJsonPutRequest($urlTest, $urlProduction, $jsonArray) {
        return $response = HTTP::withHeaders([
            'content-type'=>'application/json',
            'authorization'=> Cookie::get('token_type')." ".Cookie::get('access_token_fedex'),
        ])->put(env('PRODUCTION_ENV') ? $urlProduction: $urlTest, $jsonArray);
    }

    //|**********DHL JSON POST**********|
    public function makeDHLJsonPostRequest($urlTest, $urlProduction, $jsonArray)
    {
        return HTTP::withBasicAuth(
            env('PRODUCTION_ENV') ? env('USER_DHL_PRODUCTION'): env('USER_DHL_TEST'), 
            env('PRODUCTION_ENV') ? env('PASS_DHL_PRODUCTION'): env('PASS_DHL_TEST')
        )->post(env('PRODUCTION_ENV') ? $urlProduction: $urlTest, $jsonArray);
    }
    //|**********UPS JSON POST**********|
    public function makeUPSJsonPostRequest($urlTest, $urlProduction, $jsonArray)
    {
        return HTTP::withHeaders([
            'AccessLicenseNumber'=>'8DBB81E907AB4875',
            'Password'=>'Greetings@ups',
            'Content-Type'=>'application/json',
            'transId' => 'Tran123',
            'transactionSrc' => 'XOLT',
            'Username'=>'ufaAPI'
        ])->post(env('PRODUCTION_ENV') ? $urlProduction: $urlTest, $jsonArray);
    }
    //functions for forms//////////////////////////////////////////////////////////////
    public function getAccountShipmentNumber()
    {
        return env('PRODUCTION_ENV') ? env('SHIPPER_ACCOUNT_PRODUCTION'): env('SHIPPER_ACCOUNT_TEST');
    }
    private function getCountryCode()
    {
        return [
            "Afghanistan" => "AF", 
            "Albania" => "AL", 
            "Algeria" => "DZ", 
            "American_Samoa" => "AS", 
            "Andorra" => "AD", 
            "Angola" => "AO", 
            "Anguilla" => "AI", 
            "Antarctica" => "AQ", 
            "Antigua,_Barbuda" => "AG", 
            "Argentina" => "AR", 
            "Armenia" => "AM", 
            "Aruba" => "AW", 
            "Australia" => "AU", 
            "Austria" => "AT", 
            "Azerbaijan" => "AZ", 
            "Bahamas" => "BS", 
            "Bahrain" => "BH", 
            "Bangladesh" => "BD", 
            "Barbados" => "BB", 
            "Belarus" => "BY", 
            "Belgium" => "BE", 
            "Belize" => "BZ", 
            "Benin" => "BJ", 
            "Bermuda" => "BM", 
            "Bhutan" => "BT", 
            "Bolivia" => "BO", 
            "Bonaire" => "BQ", 
            "Bosnia-Herzegovina" => "BA", 
            "Botswana" => "BW", 
            "Bouvet_Island" => "BV", 
            "Brazil" => "BR", 
            "British_Indian_Ocean_Territory" => "IO", 
            "Brunei" => "BN", 
            "Bulgaria" => "BG", 
            "Burkina_Faso" => "BF", 
            "Burundi" => "BI", 
            "Cambodia" => "KH", 
            "Cameroon" => "CM", 
            "Canada" => "CA", 
            "Cape_Verde" => "CV", 
            "Central_African_Republic" => "CF", 
            "Chad" => "TD", 
            "Chile" => "CL", 
            "China" => "CN", 
            "Christmas_Island" => "CX", 
            "Cocos_(Keeling)_Islands" => "CC", 
            "Colombia" => "CO", 
            "Comoros" => "KM", 
            "Congo" => "CG", 
            "Congo,_Democratic_Republic_Of" => "CD", 
            "Cook_Islands" => "CK", 
            "Costa_Rica" => "CR", 
            "Croatia" => "HR", 
            "Cuba" => "CU", 
            "Curacao" => "CW", 
            "Cyprus" => "CY", 
            "Czech_Republic" => "CZ", 
            "Denmark" => "DK", 
            "Djibouti" => "DJ", 
            "Dominica" => "DM", 
            "Dominican_Republic" => "DO", 
            "East_Timor" => "TL", 
            "Ecuador" => "EC", 
            "Egypt" => "EG", 
            "El_Salvador" => "SV", 
            "England" => "GB", 
            "Equatorial_Guinea" => "GQ", 
            "Eritrea" => "ER", 
            "Estonia" => "EE", 
            "Ethiopia" => "ET", 
            "Faeroe_Islands" => "FO", 
            "Falkland_Islands" => "FK", 
            "Fiji" => "FJ", 
            "Finland" => "FI", 
            "France" => "FR", 
            "French_Guiana" => "GF", 
            "French_Southern_Territories" => "TF", 
            "Gabon" => "GA", 
            "Gambia" => "GM", 
            "Georgia" => "GE", 
            "Germany" => "DE", 
            "Ghana" => "GH", 
            "Gibraltar" => "GI", 
            "Grand_Cayman,_Cayman_Islands" => "KY", 
            "Great_Thatch_Island" => "VG", 
            "Greece" => "GR", 
            "Greenland" => "GL", 
            "Grenada" => "GD", 
            "Guadeloupe" => "GP", 
            "Guam" => "GU", 
            "Guatemala" => "GT", 
            "Guinea" => "GN", 
            "Guinea_Bissau" => "GW", 
            "Guyana" => "GY", 
            "Haiti" => "HT", 
            "Heard_and_McDonald_Islands" => "HM", 
            "Honduras" => "HN", 
            "Hong_Kong" => "HK", 
            "Hungary" => "HU", 
            "Iceland" => "IS", 
            "India" => "IN", 
            "Indonesia" => "ID", 
            "Iran" => "IR", 
            "Iraq" => "IQ", 
            "Ireland" => "IE", 
            "Israel" => "IL", 
            "Italy,_Vatican_City,_San_Marino" => "IT", 
            "Ivory_Coast" => "CI", 
            "Jamaica" => "JM", 
            "Japan" => "JP", 
            "Jordan" => "JO", 
            "Kazakhstan" => "KZ", 
            "Kenya" => "KE", 
            "Kiribati" => "KI", 
            "Kuwait" => "KW", 
            "Kyrgyzstan" => "KG", 
            "Laos" => "LA", 
            "Latvia" => "LV", 
            "Lebanon" => "LB", 
            "Lesotho" => "LS", 
            "Liberia" => "LR", 
            "Libya" => "LY", 
            "Liechtenstein" => "LI", 
            "Lithuania" => "LT", 
            "Luxembourg" => "LU", 
            "Macau" => "MO", 
            "Macedonia" => "MK", 
            "Madagascar" => "MG", 
            "Malawi" => "MW", 
            "Malaysia" => "MY", 
            "Maldives" => "MV", 
            "Mali" => "ML", 
            "Malta" => "MT", 
            "Marshall_Islands" => "MH", 
            "Martinique" => "MQ", 
            "Mauritania" => "MR", 
            "Mauritius" => "MU", 
            "Mayotte" => "YT", 
            "México" => "MX", 
            "Micronesia" => "FM", 
            "Moldova" => "MD", 
            "Monaco" => "MC", 
            "Mongolia" => "MN", 
            "Montenegro" => "ME", 
            "Montserrat" => "MS", 
            "Morocco" => "MA", 
            "Mozambique" => "MZ", 
            "Myanmar_/_Burma" => "MM", 
            "Namibia" => "NA", 
            "Nauru" => "NR", 
            "Nepal" => "NP", 
            "Netherlands,_Holland" => "NL", 
            "New_Caledonia" => "NC", 
            "New_Zealand" => "NZ", 
            "Nicaragua" => "NI", 
            "Niger" => "NE", 
            "Nigeria" => "NG", 
            "Niue" => "NU", 
            "Norfolk_Island" => "NF", 
            "North_Korea" => "KP", 
            "Northern_Mariana_Islands" => "MP", 
            "Norway" => "NO", 
            "Oman" => "OM", 
            "Pakistan" => "PK", 
            "Palau" => "PW", 
            "Palestine" => "PS", 
            "Panama" => "PA", 
            "Papua_New_Guinea" => "PG", 
            "Paraguay" => "PY", 
            "Peru" => "PE", 
            "Philippines" => "PH", 
            "Pitcairn" => "PN", 
            "Poland" => "PL", 
            "Portugal" => "PT", 
            "Puerto_Rico" => "PR", 
            "Qatar" => "QA", 
            "Reunion" => "RE", 
            "Romania" => "RO", 
            "Russia" => "RU", 
            "Rwanda" => "RW", 
            "Samoa" => "WS", 
            "Sao_Tome_and_Principe" => "ST", 
            "Saudi_Arabia" => "SA", 
            "Senegal" => "SN", 
            "Serbia" => "RS", 
            "Seychelles" => "SC", 
            "Sierra_Leone" => "SL", 
            "Singapore" => "SG", 
            "Slovak_Republic" => "SK", 
            "Slovenia" => "SI", 
            "Solomon_Islands" => "SB", 
            "Somalia" => "SO", 
            "South_Africa" => "ZA", 
            "South_Georgia" => "GS", 
            "South_Korea" => "KR", 
            "Spain,_Canary_Islands" => "ES", 
            "Sri_Lanka" => "LK", 
            "St._Barthelemy" => "BL", 
            "St._Christopher," => "KN", 
            "St._John,_St._Thomas" => "VI", 
            "St._Helena" => "SH", 
            "St._Lucia" => "LC", 
            "St._Maarten_(Dutch_Control)" => "SX", 
            "St._Martin_(French_Control)" => "MF", 
            "St._Pierre" => "PM", 
            "St._Vincent,_Union_Island" => "VC", 
            "Sudan" => "SD", 
            "Suriname" => "SR", 
            "Svalbard_and_Jan_Mayen_Island" => "SJ", 
            "Swaziland" => "SZ", 
            "Sweden" => "SE", 
            "Switzerland" => "CH", 
            "Syria" => "SY", 
            "Tahiti,_French_Polynesia" => "PF", 
            "Taiwan" => "TW", 
            "Tajikistan" => "TJ", 
            "Tanzania" => "TZ", 
            "Thailand" => "TH", 
            "Togo" => "TG", 
            "Tokelau" => "TK", 
            "Tonga" => "TO", 
            "Trinidad_and_Tobago" => "TT", 
            "Tunisia" => "TN", 
            "Turkey" => "TR", 
            "Turkmenistan" => "TM", 
            "Turks_and_Caicos_Islands" => "TC", 
            "Tuvalu" => "TV", 
            "U.S._Minor_Outlying_Islands" => "UM", 
            "Uganda" => "UG", 
            "Ukraine" => "UA", 
            "United_Arab_Emirates" => "AE", 
            "United_States" => "US", 
            "Uruguay" => "UY", 
            "Uzbekistan" => "UZ", 
            "Vanuatu" => "VU", 
            "Venezuela" => "VE", 
            "Vietnam" => "VN", 
            "Wallis_and_Futuna_Islands" => "WF", 
            "Western_Sahara" => "EH", 
            "Yemen" => "YE", 
            "Zambia" => "ZM", 
            "Zimbabwe" => "ZW" 
        ]; 
    }

    private function getServiceType(){
        return [
            "FedEx 2Day�"=>"FEDEX_2_DAY", 
            "FedEx 2Day� A.M."=>"FEDEX_2_DAY_AM", 
            "FedEx Custom Critical Air"=>"FEDEX_CUSTOM_CRITICAL_CHARTER_AIR", 
            "FedEx Custom Critical Air Expedite"=>"FEDEX_CUSTOM_CRITICAL_AIR_EXPEDITE", 
            "FedEx Custom Critical Air Expedite Exclusive Use"=>"FEDEX_CUSTOM_CRITICAL_AIR_EXPEDITE_EXCLUSIVE_USE", 
            "FedEx Custom Critical Air Expedite Network"=>"FEDEX_CUSTOM_CRITICAL_AIR_EXPEDITE_NETWORK", 
            "FedEx Custom Critical Point To Point"=>"FEDEX_CUSTOM_CRITICAL_POINT_TO_POINT", 
            "FedEx Custom Critical Surface Expedite"=>"FEDEX_CUSTOM_CRITICAL_SURFACE_EXPEDITE", 
            "FedEx Custom Critical Surface Expedite Exclusive Use"=>"FEDEX_CUSTOM_CRITICAL_SURFACE_EXPEDITE_EXCLUSIVE_USE", 
            "FedEx Distance Deferred"=>"FEDEX_DISTANCE_DEFERRED", 
            "FedEx Europe First"=>"EUROPE_FIRST_INTERNATIONAL_PRIORITY", 
            "FedEx Express Saver�"=>"FEDEX_EXPRESS_SAVER", 
            "FedEx First Overnight�"=>"FIRST_OVERNIGHT", 
            "FedEx First Overnight� EH"=>"FEDEX_FIRST_OVERNIGHT_EXTRA_HOURS", 
            "FedEx Ground"=>"FEDEX_GROUND", 
            "FedEx Home Delivery�"=>"GROUND_HOME_DELIVERY", 
            "FedEx International Airport-to-Airport"=>"FEDEX_CARGO_AIRPORT_TO_AIRPORT", 
            "FedEx International Connect Plus�"=>"FEDEX_INTERNATIONAL_CONNECT_PLUS", 
            "FedEx International Economy"=>"INTERNATIONAL_ECONOMY", 
            "FedEx International Economy DirectDistributionSM"=>"INTERNATIONAL_ECONOMY_DISTRIBUTION", 
            "FedEx International First�"=>"INTERNATIONAL_FIRST", 
            "FedEx International MailService"=>"FEDEX_CARGO_MAIL", 
            "FedEx International Premium�"=>"FEDEX_CARGO_INTERNATIONAL_PREMIUM", 
            "FedEx International Priority DirectDistribution�"=>"INTERNATIONAL_PRIORITY_DISTRIBUTION", 
            "FedEx International Priority� Express"=>"FEDEX_INTERNATIONAL_PRIORITY_EXPRESS", 
            "FedEx International Priority� (New IP Service)"=>"FEDEX_INTERNATIONAL_PRIORITY", 
            "FedEx International Priority Plus�"=>"FEDEX_INTERNATIONAL_PRIORITY_PLUS", 
            "FedEx Priority Overnight�"=>"PRIORITY_OVERNIGHT", 
            "FedEx Priority Overnight� EH"=>"PRIORITY_OVERNIGHT_EXTRA_HOURS", 
            "FedEx SameDay�"=>"SAME_DAY", 
            "FedEx SameDay� City"=>"SAME_DAY_CITY", 
            "FedEx SmartPost�"=>"SMART_POST", 
            "FedEx Standard Overnight� EH"=>"FEDEX_STANDARD_OVERNIGHT_EXTRA_HOURS", 
            "FedEx Standard Overnight�"=>"STANDARD_OVERNIGHT", 
            "FedEx Transborder Distribution"=>"TRANSBORDER_DISTRIBUTION_CONSOLIDATION", 
            "Temp-Assure Air�"=>"FEDEX_CUSTOM_CRITICAL_TEMP_ASSURE_AIR", 
            "Temp-Assure Validated Air�"=>"FEDEX_CUSTOM_CRITICAL_TEMP_ASSURE_VALIDATED_AIR", 
            "White Glove Services�"=>"FEDEX_CUSTOM_CRITICAL_WHITE_GLOVE_SERVICES", 
            "FedEx Regional Economy"=>"FEDEX_REGIONAL_ECONOMY", 
            "FedEx Regional Economy Freight"=>"FEDEX_REGIONAL_ECONOMY_FREIGHT", 
            "FedEx International Priority (Old IP Service)"=>"INTERNATIONAL_PRIORITY", 
            "FedEx 1 Day Freight"=>"FEDEX_1_DAY_FREIGHT", 
            "FedEx 2 Day Freight"=>"FEDEX_2_DAY_FREIGHT", 
            "FedEx 3 Day Freight"=>"FEDEX_3_DAY_FREIGHT", 
            "FedEx First Overnight Freight"=>"FIRST_OVERNIGHT_FREIGHT", 
            "FedEx Next Day Afternoon"=>"FEDEX_NEXT_DAY_AFTERNOON", 
            "FedEx Next Day Morning"=>"FEDEX_NEXT_DAY_EARLY_MORNING", 
            "FedEx Next Day End of Day"=>"FEDEX_NEXT_DAY_END_OF_DAY", 
            "FedEx Next Day Mid Morning"=>"FEDEX_NEXT_DAY_MID_MORNING", 
            "International Economy Freight"=>"INTERNATIONAL_ECONOMY_FREIGHT", 
            "International Priority Freight"=>"INTERNATIONAL_PRIORITY_FREIGHT"
        ];
}

    private function getPackageType(){
        return [
            "Customer Packaging, FedEx Express Services" =>"YOUR_PACKAGING",
            "Customer Packaging, FedEx SmartPost Services" =>"YOUR_PACKAGING",
            "FedEx Letters" =>"FEDEX_ENVELOPE",
            "FedEx Box" =>"FEDEX_BOX",
            "FedEx Small Box" =>"FEDEX_SMALL_BOX",
            "FedEx Medium Box" =>"FEDEX_MEDIUM_BOX",
            "FedEx Large Box" =>"FEDEX_LARGE_BOX",
            "FedEx Extra Large Box" =>"FEDEX_EXTRA_LARGE_BOX",
            "FedEx 10kg Box" =>"FEDEX_10KG_BOX",
            "FedEx 25kg Box" =>"FEDEX_25KG_BOX",
            "FedEx Pak" =>"FEDEX_PAK",
            "FedEx Tube" =>"FEDEX_TUBE"
        ];
    }
    private function getPickupType(){
        return[
            "Indicates FedEx will be contacted to request a pickup." =>"CONTACT_FEDEX_TO_SCHEDULE",
            "Indicates Shipment will be dropped off at a FedEx Location." =>"DROPOFF_AT_FEDEX_LOCATION",
            "Indicates Shipment will be picked up as part of a regular scheduled pickup." =>"USE_SCHEDULED_PICKUP",
            "Indicates the pickup will be scheduled by calling FedEx." =>"ON_CALL",
            "Indicates the pickup by FedEx Ground Package Returns Program." =>"PACKAGE_RETURN_PROGRAM",
            "Indicates the pickup at the regular pickup schedule." =>"REGULAR_STOP",
            "Indicates the pickup specific to an Express tag or Ground call tag pickup request." =>"TAG",
        ];
    }

    public function setShipmentBody(Request $request)
    {
        $requestJson = json_decode($request->post('json'));
        $delivery = $requestJson->delivery;
        $requestJson = $requestJson->json;
        switch($delivery)
        {
            case 'fedex':
                // $body = json_encode([
                //     "labelResponseOptions" => "URL_ONLY",
                //     "requestedShipment" => [
                //         "shipper" => [
                //             "contact" => [
                //                 "personName" => "",
                //             ]
                //         ],
                //         "recipients" => array([
                //             "contact" => [
                //                 "personName" => "",
                //             ]
                //     ]),
                //         "shipDatestamp" => "2020-12-30",
                //       "serviceType" => "STANDARD_OVERNIGHT",
                //       "packagingType" => "FEDEX_SMALL_BOX",
                //       "pickupType" => "USE_SCHEDULED_PICKUP",
                //       "blockInsightVisibility" => false,
                //       "shippingChargesPayment" =>[
                //           "paymentType" => "SENDER"
                //       ],
                //       "shipmentSpecialServices" => [
                //           "specialServiceTypes" => array(
                //               "FEDEX_ONE_RATE"
                //           )
                //       ],
                //       "labelSpecification" => [
                //           "imageType" => "PDF",
                //           "labelStockType" => "PAPER_85X11_TOP_HALF_LABEL"
                //       ],
                //       "requestedPackageLineItems" => array(
                //         []
                //       )
                //      ],
                //     "accountNumber" => [
                //         "value" => env("SHIPPER_ACCOUNT_TEST ")
                //     ]
                // ]);
                // $body = json_decode($body);
                // $body = json_decode('{
                //     "labelResponseOptions": "URL_ONLY",
                //     "requestedShipment": {
                //       "shipper": {
                //         "contact": {
                //           "personName": "SHIPPER NAME",
                //           "phoneNumber": 1234567890,
                //           "companyName": "Shipper Company Name"
                //         },
                //         "address": {
                //           "streetLines": [
                //             "SHIPPER STREET LINE 1"
                //           ],
                //           "city": "HARRISON",
                //           "stateOrProvinceCode": "AR",
                //           "postalCode": 72601,
                //           "countryCode": "US"
                //         }
                //       },
                //       "recipients": [
                //         {
                //           "contact": {
                //             "personName": "RECIPIENT NAME",
                //             "phoneNumber": 1234567890,
                //             "companyName": "Recipient Company Name"
                //           },
                //           "address": {
                //             "streetLines": [
                //               "RECIPIENT STREET LINE 1",
                //               "RECIPIENT STREET LINE 2"
                //             ],
                //             "city": "Collierville",
                //             "stateOrProvinceCode": "TN",
                //             "postalCode": 38017,
                //             "countryCode": "US"
                //           }
                //         }
                //       ],
                //       "shipDatestamp": "2020-12-30",
                //       "serviceType": "STANDARD_OVERNIGHT",
                //       "packagingType": "FEDEX_SMALL_BOX",
                //       "pickupType": "USE_SCHEDULED_PICKUP",
                //       "blockInsightVisibility": false,
                //       "shippingChargesPayment": {
                //         "paymentType": "SENDER"
                //       },
                //       "shipmentSpecialServices": {
                //         "specialServiceTypes": [
                //           "FEDEX_ONE_RATE"
                //         ]
                //       },
                //       "labelSpecification": {
                //         "imageType": "PDF",
                //         "labelStockType": "PAPER_85X11_TOP_HALF_LABEL"
                //       },
                //       "requestedPackageLineItems": [
                //         {}
                //       ]
                //     },
                //     "accountNumber": {
                //       "value": "740561073"
                //     }
                //   }');
                $body = json_encode([
                    
                    "labelResponseOptions" => "URL_ONLY",
                    "requestedShipment" => [
                        "shipper" => [
                            "contact" => [
                                "personName" => $requestJson->shipper->contact->personName,
                                "phoneNumber"=> $requestJson->shipper->contact->phoneNumber,
                            ],
                            "address" => [
                                "streetLines" => [
                                    $requestJson->shipper->address->streetLines
                                ],
                                "city" => $requestJson->shipper->address->city,
                                "stateOrProvinceCode" => $requestJson->shipper->address->stateOrProvinceCode,
                                "postalCode" => $requestJson->shipper->address->postalCode,
                                "countryCode" =>  $requestJson->shipper->address->countryCode
                        ]   
                        ],
                        "recipients" => array ([
                            "contact" => [
                            "personName" => $requestJson->recipients[0]->contact->personName,
                            "phoneNumber"=> $requestJson->recipients[0]->contact->phoneNumber,
                            // "companyName": ""
                            ],
                            "address" => [
                            "streetLines" => [
                                $requestJson->recipients[0]->address->streetLines
                            ],
                            "city" => $requestJson->recipients[0]->address->city,
                            "stateOrProvinceCode" => $requestJson->recipients[0]->address->stateOrProvinceCode,
                            "postalCode" => $requestJson->recipients[0]->address->postalCode,
                            "countryCode" => $requestJson->recipients[0]->address->countryCode
                        ]
                         ]),
                            
                                "shipDatestamp" => $requestJson->shipDatestamp,
                                "serviceType" => $requestJson->serviceType,
                                "packagingType" => $requestJson->packagingType,
                                "pickupType" => $requestJson->pickupType,
                                "shippingChargesPayment" => [
                                "paymentType" => "SENDER"
                            ],
                                
                                "labelSpecification" => [
                                "imageType" => "PDF",
                                "labelStockType" => "PAPER_85X11_TOP_HALF_LABEL"
                            ],
                                "requestedPackageLineItems" => array([
                                    "weight" => [
                                    "units" => $requestJson->requestedPackageLineItems[0]->weight->units,
                                    "value" => $requestJson->requestedPackageLineItems[0]->weight->value
                                ]
                                ])
                        ],
                "accountNumber" => [
                    "value" => env('SHIPPER_ACCOUNT_TEST')
                ],
                ]);
                $body  = json_decode($body);
                break;
            case 'dhl':
                $UnitOfMeasurement = '';
                if($requestJson->requestedPackageLineItems[0]->weight->units == 'KG')
                {
                    $UnitOfMeasurement = "SI";
                }
                else if($requestJson->requestedPackageLineItems[0]->weight->units == 'LB')
                {
                    $UnitOfMeasurement = "SU";
                }
                $body = [
                    "ShipmentRequest" => [
                        "RequestedShipment" => [
                            "ShipmentInfo" => [
                                "DropOffType" => "REGULAR_PICKUP",
                                "ServiceType" => "N",
                                "Account" => env("ACCOUNT_DHL_TEST"),
                                "Currency" => "MXN",
                                "UnitOfMeasurement" => $UnitOfMeasurement,
                                "PackagesCount" => 1,
                            "LabelOptions" => [
                                "RequestWaybillDocument" => "Y",
                                "HideAccountInWaybillDocument" => "Y"
                            ],
                                "LabelType" => "ZPL"
                        ],
                            "ShipTimestamp" => $requestJson->shipDatestamp,
                            "PaymentInfo" => "DDU",
                            "InternationalDetail" => [
                                "Commodities" => [
                                    "NumberOfPieces" => 1,
                                    "Description" => "Test"
                                ],
                            "Content"  => "NON_DOCUMENTS"
                        ],
                            "Ship" => [
                                "Shipper" => [
                                "Contact" => [
                                    "PersonName" => $requestJson->shipper->contact->personName,
                                    "CompanyName" => $requestJson->shipper->contact->company,
                                    "PhoneNumber" => $requestJson->shipper->contact->phoneNumber,
                                    "EmailAddress" => $requestJson->shipper->contact->shipperEmail
                                ],
                                "Address" => [
                                    "StreetLines" => $requestJson->shipper->address->streetLines[0],
                                    "City" => $requestJson->shipper->address->city,
                                    "PostalCode" => $requestJson->shipper->address->postalCode,
                                    "CountryCode" => $requestJson->shipper->address->countryCode
                                ]
                            ],
                                "Recipient" => [
                                "Contact" => [
                                    "PersonName" =>  $requestJson->recipients[0]->contact->personName,
                                    "CompanyName" => $requestJson->recipients[0]->contact->company,
                                    "PhoneNumber" => $requestJson->recipients[0]->contact->phoneNumber,
                                    "EmailAddress" => $requestJson->recipients[0]->contact->recipientEmail
                                ],
                                "Address" => [
                                    "StreetLines" => $requestJson->recipients[0]->address->streetLines[0],
                                    "City" => $requestJson->recipients[0]->address->city,
                                    "PostalCode" => $requestJson->recipients[0]->address->postalCode,
                                    "CountryCode" => $requestJson->recipients[0]->address->countryCode
                                ]
                                ]
                        ],
                            "Packages" => [
                                "RequestedPackages" => [
                                "@number" => 1,
                                "InsuredValue" => 10,
                                "Weight" => $requestJson->requestedPackageLineItems[0]->weight->value,
                                "Dimensions" => [
                                    "Length" => $requestJson->requestedPackageLineItems[0]->dimensions->lenght,
                                    "Width" => $requestJson->requestedPackageLineItems[0]->dimensions->width,
                                    "Height" => $requestJson->requestedPackageLineItems[0]->dimensions->height
                                ],
                                "CustomerReferences" => "FOLIO WMS 12345678"
                            ]
                            ]
                ]
                            ]
                            ];
                break;
            case 'ups':
                $body = [
                    "ShipmentRequest" => [
                       "Shipment" => [
                            "PaymentInformation" => [
                                "ShipmentCharge"=>[
                                    "Type"=>"01",
                                    "BillShipper"=>[
                                        "AccountNumber"=> env('ACCOUNT_NUMBER_UPS')
                                    ]
                                ]
                                    ],
                            "Shipper" => [
                                "Name" => $requestJson->shipper->contact->shipperPersonName,
                                "Phone" => [
                                    "Number" => $requestJson->shipper->contact->shipperPhoneNumber
                                ],
                          "ShipperNumber" => env('ACCOUNT_NUMBER_UPS'),
                          "Address" => [
                             "AddressLine" => $requestJson->shipper->address->streetLines[0],
                             "City" => $requestJson->shipper->address->city,
                             "PostalCode" => $requestJson->shipper->address->postalCode,
                             "CountryCode" => $requestJson->shipper->address->countryCode
                          ]
                        ],
                       "ShipTo" => [
                          "Name" => $requestJson->recipients[0]->contact->personName,
                          "Phone" => [
                             "Number" => $requestJson->recipients[0]->contact->phoneNumber
                       ],
                       "Address" => [
                          "AddressLine" => $requestJson->recipients[0]->address->streetLines[0],
                          "City" => $requestJson->recipients[0]->address->city,
                          "PostalCode" => $requestJson->recipients[0]->address->postalCode,
                          "CountryCode" => $requestJson->recipients[0]->address->countryCode
                       ]
                    ],
                       "ShipFrom" => [
                       "Name" => $requestJson->shipper->contact->shipperPersonName,
                       "Phone" => [
                          "Number" => $requestJson->shipper->contact->shipperPhoneNumber
                       ],
                       "Address" => [
                          "AddressLine" => $requestJson->shipper->address->streetLines[0],
                          "City" => $requestJson->shipper->address->city,
                          "PostalCode" => $requestJson->shipper->address->postalCode,
                          "CountryCode" => $requestJson->shipper->address->countryCode
                       ]
                    ],
                       "Service" => [
                          "Code" => "service code",
                          "Description" => "service Description"
                       ],
                       "Package" => [
                          "Packaging" => [
                             "Code" => "Packaging code",
                       ]
                       ]
                    ]
                ]
                ];
                break;
        }
        return $body;
    }
}

