<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DhlController;
use Illuminate\Support\Facades\Http;

class DhlController extends Controller
{
    public static function rateRequest(){
        $rateRequest = new DhlController;
        
        $body = json_decode(
            '{
                "RateRequest": {
                    "ClientDetails": null,
                    "RequestedShipment": {
                        "DropOffType": "REQUEST_COURIER",
                        "ShipTimestamp": "2022-06-01T09:10:09",
                        "UnitOfMeasurement": "SU",
                        "Content": "DOCUMENTS",
                        "PaymentInfo": "DDU",
                      "Account": 980433193,
                        "Ship": {
                            "Shipper": {
                                "City": "",
                                "PostalCode": "65247",
                                "CountryCode": "US"
                            },
                            "Recipient": {
                                "City": "",
                                "PostalCode": "75063",
                                "CountryCode": "US"
                            }
                        },
                        "Packages": {
                            "RequestedPackages": {
                                "@number": "1",
                                "Weight": {
                                    "Value": 20
                                },
                                "Dimensions": {
                                    "Length": 20,
                                    "Width": 20,
                                    "Height": 20
                                }
                            }
                        }
                    }
                }
            }'
        );
        return $rateRequest ->makeDHLJsonPostRequest(
            env('RATE_REQUEST_DHL_TEST'),
            env('RATE_REQUEST_DHL_PRODUCTION'),
            $body
        );
    }
    public static function shipmentRequest()
    {
        $rateRequest = new DhlController;  

        $body = json_decode(
            '{
                "ShipmentRequest": {
                   "RequestedShipment": {
                      "ShipmentInfo": {
                           "DropOffType": "REGULAR_PICKUP",
                         "ServiceType": "N",
                         "Account": 980433193,
                         "Currency": "MXN",
                         "UnitOfMeasurement": "SI",
                         "PackagesCount": 1,
                        "LabelOptions": {
                          "RequestWaybillDocument": "Y",
                          "HideAccountInWaybillDocument": "Y"
                        },
                         "LabelType": "ZPL"
                      },
                      "ShipTimestamp": "2022-06-08T17:00:00GMT-06:00",
                      "PaymentInfo": "DDU",
                      "InternationalDetail": {
                         "Commodities": {
                            "NumberOfPieces": 1,
                            "Description": "Test"
                         },
                        "Content" : "DOCUMENTS"
                      },
                      "Ship": {
                         "Shipper": {
                            "Contact": {
                               "PersonName": "TEST",
                               "CompanyName": "TEST",
                               "PhoneNumber": "55-55-55-55",
                               "EmailAddress": "test@gmail.com"
                            },
                            "Address": {
                               "StreetLines": "Prolongacion Hidalgo",
                               "City": "Mexico",
                               "PostalCode": "58741",
                               "CountryCode": "MX"
                            }
                         },
                         "Recipient": {
                            "Contact": {
                               "PersonName": "TEST",
                               "CompanyName": "TEST",
                               "PhoneNumber": "11-11-11-11",
                               "EmailAddress": "test@gmail.com"
                            },
                            "Address": {
                               "StreetLines": "Mariano Escobedo",
                               "City": "Mexico",
                               "PostalCode": "59920",
                               "CountryCode": "MX"
                            }
                         }
                      },
                      "Packages": {
                         "RequestedPackages": {
                            "@number": 1,
                            "InsuredValue": 10,
                            "Weight": 10,
                            "Dimensions": {
                               "Length": 10,
                               "Width": 10,
                               "Height": 10
                            },
                            "CustomerReferences": "FOLIO WMS 12345678"
                         }
                      }
                   }
                }
             }'
        );
        return $rateRequest ->makeDHLJsonPostRequest(
            env('SHIPMENT_REQUEST_DHL_TEST'),
            env('SHIPMENT_REQUEST_DHL_PRODUCTION'),
            $body
        );
    }

    public static function pickupRequest()
    {
        $rateRequest = new DhlController;  
        
        $body = json_decode(
            '{
                "PickUpRequest": {
                    "PickUpShipment": {
                        "ShipmentInfo": {
                            "ServiceType": "N",
                            "Billing": {
                                "ShipperAccountNumber": "980433193",
                                "ShippingPaymentType": "S"
                            },
                            "UnitOfMeasurement": "SI"
                        },
                        "PickupTimestamp": "2022-06-08T09:10:09",
                        "PickupLocationCloseTime": "18:00",
                        "SpecialPickupInstruction": "Recolectar en recepción",
                        "PickupLocation": "Recepción",
                        "InternationalDetail": {
                            "Commodities": {
                                "Description": "TEST"
                            }
                        },
                        "Ship": {
                            "Shipper": {
                                "Contact": {
                                    "PersonName": "Test Shipper",
                                    "CompanyName": "Test",
                                    "PhoneNumber": "5500000000",
                                    "EmailAddress": "test@dhl.com"
                                },
                                "Address": {
                                    "StreetLines": "Fuerza Aerea Mexicana 540",
                                    "City": "Venustiano Carranza",
                                    "PostalCode": "15700",
                                    "CountryCode": "MX"
                                }
                            },
                            "Recipient": {
                                "Contact": {
                                    "PersonName": "Test Recipient",
                                    "CompanyName": "Test",
                                    "PhoneNumber": "5500000000",
                                    "EmailAddress": "test@dhl.com"
                                },
                                "Address": {
                                    "StreetLines": "Guadalajara centro",
                                    "City": "Guadalajara",
                                    "PostalCode": "44100",
                                    "CountryCode": "MX"
                                }
                            }
                        },
                        "Packages": {
                            "RequestedPackages": {
                                "@number": "1",
                                "Weight": "1",
                                "Dimensions": {
                                    "Length": "10",
                                    "Width": "10",
                                    "Height": "10"
                                },
                                "CustomerReferences": "Test"
                            }
                        }
                    }
                }
            }'
        );
        return $rateRequest ->makeDHLJsonPostRequest(
            env('REQUEST_PICKUP_DHL_TEST'),
            env('REQUEST_PICKUP_DHL_PRODUCTION'),
            $body
        );
    }
    public static function trackingRequest()
    {
        $rateRequest = new DhlController;  

        $body = json_decode(
            '{
                "trackShipmentRequest": {
                    "trackingRequest": {
                        "TrackingRequest": {
                            "Request": {
                                "ServiceHeader": {
                                    "MessageTime": "2022-06-08T09:10:09",
                                    "MessageReference": "CBJ180121002626"
                                }
                            },
                            "AWBNumber": {
                                "ArrayOfAWBNumberItem": CBJ180121002626
                            },
                            "LevelOfDetails": "ALL_CHECK_POINTS",
                            "PiecesEnabled": "B"
                        }
                    }
                }
            }'
        );
        return $rateRequest ->makeDHLJsonPostRequest(
            env('TRACKING_REQUEST_DHL_TEST'),
            env('TRACKING_REQUEST_DHL_PRODUCTION'),
            $body
        );
    }

    public function makeDHLJsonPostRequest($urlTest, $urlProduction, $jsonArray)
    {
        return HTTP::withBasicAuth(
            env('PRODUCTION_ENV') ? env('USER_DHL_PRODUCTION'): env('USER_DHL_TEST'), 
            env('PRODUCTION_ENV') ? env('PASS_DHL_PRODUCTION'): env('PASS_DHL_TEST')
        )->post(env('PRODUCTION_ENV') ? $urlProduction: $urlTest, $jsonArray)->json();
    }
}
