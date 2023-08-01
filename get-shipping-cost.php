<?php

$client_id = '';
$client_secret = '';

// ***** SHIPPING SERVICE AVAILABLE OPTIONS *****
// Domestic 	
// 14 =	UPS Next Day Air Early
// 01 =	UPS Next Day Air
// 13 =	UPS Next Day Air Saver
// 59 =	UPS 2nd Day Air A.M.
// 02 =	UPS 2nd Day Air
// 12 =	UPS 3 Day Select
// 03 =	UPS Ground
// International 	
// 11 =	UPS Standard
// 07 =	UPS Worldwide Express
// 54 =	UPS Worldwide Express Plus
// 08 =	UPS Worldwide Expedited
// 65 =	UPS Worldwide Saver
// 96 =	UPS Worldwide Express Freight
// 82 =	UPS Today Standard
// 83 =	UPS Today Dedicated Courier
// 84 =	UPS Today Intercity
// 85 =	UPS Today Express
// 86 =	UPS Today Express Saver
// 70 =	UPS Access Point Economy

// ***** PACKAGE TYPE AVAILABLE OPTIONS *****
// 01 = Bag, 
// 02 = Box, 
// 03 = Carton/Piece, 
// 04 = Crate, 
// 05 = Drum, 
// 06 = Pallet/Skid, 
// 07 = Roll, 
// 08 = Tube, 

// PACKAGE
$package_info = array(
    'service' => '03',
    'package_type' => '02',
    'Weight' => '5',
    'length' => '5',
    'width' => '5',
    'height' => '5',
);

// SHIPPER
$shipper_info = array(
    'account_number' => '',
    'name' => '',
    'address1' => '',
    'address2' => '',
    'address3' => '',
    'city' => '',
    'state' => '',
    'zip' => '',
    'country' => 'us',
);

// TO ADDRESS
$to_address_info = array(
    'name' => '',
    'address1' => '',
    'address2' => '',
    'address3' => '',
    'city' => '',
    'state' => '',
    'zip' => '',
    'country' => 'US',
);

// FROM ADDRESS
$from_address_info = array(
    'name' => '',
    'address1' => '',
    'address2' => '',
    'address3' => '',
    'city' => '',
    'state' => '',
    'zip' => '',
    'country' => 'us',
);




function getToken($client_id, $client_secret)
{
    $Combineuserandpassword = $client_id . ':' . $client_secret;
    $curl = curl_init();
    $payload = "grant_type=client_credentials";
    curl_setopt_array($curl, [
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/x-www-form-urlencoded",
            "x-merchant-id: string",
            "Authorization: Basic " . base64_encode($Combineuserandpassword)
        ],
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_URL => "https://onlinetools.ups.com/security/v1/oauth/token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
    ]);
    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    if ($error) {
        echo "cURL Error #:" . $error;
    } else {
        // echo $response;
    }
    // Convert the JSON response string to an associative array
    $responseArray = json_decode($response, true);
    // Extract the access token
    $accessToken = $responseArray['access_token'];
    return $accessToken;
}

function getShippingCost($accessToken, $shipper_info, $to_address_info, $from_address_info, $package_info)
{
    $version = "v1";
    $requestoption = "Rate";
    $query = array();
    $curl = curl_init();
    $payload = array(
        "RateRequest" => array(
            "Request" => array(
                "TransactionReference" => array(
                    "CustomerContext" => "CustomerContext",
                    "TransactionIdentifier" => "TransactionIdentifier"
                )
            ),
            "Shipment" => array(
                "Shipper" => array(
                    "Name" => $shipper_info['name'],
                    "ShipperNumber" => $shipper_info['account_number'],
                    "Address" => array(
                        "AddressLine" => array(
                            $shipper_info['address1'],
                            $shipper_info['address2'],
                            $shipper_info['address3']
                        ),
                        "City" => $shipper_info['city'],
                        "StateProvinceCode" => $shipper_info['state'],
                        "PostalCode" => $shipper_info['zip'],
                        "CountryCode" => $shipper_info['country']
                    )
                ),
                "ShipTo" => array(
                    "Name" => $to_address_info['name'],
                    "Address" => array(
                        "AddressLine" => array(
                            $to_address_info['address1'],
                            $to_address_info['address1'],
                            $to_address_info['address1']
                        ),
                        "City" => $to_address_info['city'],
                        "StateProvinceCode" => $to_address_info['state'],
                        "PostalCode" => $to_address_info['zip'],
                        "CountryCode" => $to_address_info['country']
                    )
                ),
                "ShipFrom" => array(
                    "Name" => $from_address_info['name'],
                    "Address" => array(
                        "AddressLine" => array(
                            $from_address_info['address1'],
                            $from_address_info['address2'],
                            $from_address_info['address3']
                        ),
                        "City" => $from_address_info['city'],
                        "StateProvinceCode" => $from_address_info['state'],
                        "PostalCode" => $from_address_info['zip'],
                        "CountryCode" => $from_address_info['country']
                    )
                ),
                "PaymentDetails" => array(
                    "ShipmentCharge" => array(
                        "Type" => "01",
                        "BillShipper" => array(
                            "AccountNumber" => $shipper_info['account_number']
                        )
                    )
                ),
                "Service" => array(
                    "Code" => $package_info['service'],
                    "Description" => "ground"
                ),
                "NumOfPieces" => "1",
                "Package" => array(
                    "PackagingType" => array(
                        "Code" => $package_info['package_type'],
                        "Description" => "Packaging"
                    ),
                    "Dimensions" => array(
                        "UnitOfMeasurement" => array(
                            "Code" => "IN",
                            "Description" => "Inches"
                        ),
                        "Length" => "7",
                        "Width" => "4",
                        "Height" => "2"
                    ),
                    "PackageWeight" => array(
                        "UnitOfMeasurement" => array(
                            "Code" => "LBS",
                            "Description" => "Pounds"
                        ),
                        "Weight" => "1"
                    )
                )
            )
        )
    );
    curl_setopt_array($curl, [
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $accessToken,
            "Content-Type: application/json",
            "transId: string",
            "transactionSrc: testing"
        ],
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_URL => "https://onlinetools.ups.com/api/rating/" . $version . "/" . $requestoption . "?" . http_build_query($query),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
    ]);
    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    if ($error) {
        echo "cURL Error #:" . $error;
    } else {
        // echo $response;
        $responseArray = json_decode($response, true);
        $totalCharges = $responseArray['RateResponse']['RatedShipment']['TotalCharges']['MonetaryValue'];
        // echo "Total Charges: " . $totalCharges;
        return $totalCharges;
    }
}

// EXAMPLE OF HOW TO USE
$accessToken = getToken($client_id, $client_secret);
$totalCharges = getShippingCost($accessToken, $shipper_info, $to_address_info, $from_address_info, $package_info);
echo 'Total Charges: $' . $totalCharges;
