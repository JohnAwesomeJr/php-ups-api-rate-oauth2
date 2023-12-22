<?php
/**
 * Requires libcurl
 */

const version = "v2205";
const requestoption = "Shop";
$query = array(
  "additionalinfo" => "timeintransit "
);

$curl = curl_init();

$payload = array(
  "RateRequest" => array(
    "Request" => array(
      "TransactionReference" => array(
        "CustomerContext" => "CustomerContext"
      )
    ),
    "Shipment" => array(
      "Shipper" => array(
        "Name" => "John",
        "ShipperNumber" => "C870V5",
        "Address" => array(
          "AddressLine" => array(
            "John Christensen",
            "1927 Lost Creek Drive",
            "",
          ),
          "City" => "Arlington",
          "StateProvinceCode" => "TX",
          "PostalCode" => "76006",
          "CountryCode" => "US"
        )
      ),
      "ShipTo" => array(
        "Name" => "ShipToName",
        "Address" => array(
          "AddressLine" => array(
            "John Christensen",
            "1927 Lost Creek Drive",
            "",
          ),
          "City" => "Arlington",
          "StateProvinceCode" => "TX",
          "PostalCode" => "76006",
          "CountryCode" => "US"
        )
      ),
      "ShipFrom" => array(
        "Name" => "ShipFromName",
        "Address" => array(
          "AddressLine" => array(
            "Jenny",
            "10986 Deer Valley Rd",
            "",
          ),
          "City" => "Yucaipa",
          "StateProvinceCode" => "CA",
          "PostalCode" => "92399",
          "CountryCode" => "US"
        )
      ),
      "PaymentDetails" => array(
        "ShipmentCharge" => array(
          "Type" => "01",
          "BillShipper" => array(
            "AccountNumber" => "C870V5"
          )
        )
      ),
      "Service" => array(
        "Code" => "03",
        "Description" => "Ground"
      ),
      "NumOfPieces" => "1",
      "Package" => array(
        "SimpleRate" => array(
          "Description" => "SimpleRateDescription",
          "Code" => "XS"
        ),
        "PackagingType" => array(
          "Code" => "02",
          "Description" => "Packaging"
        ),
        "Dimensions" => array(
          "UnitOfMeasurement" => array(
            "Code" => "IN",
            "Description" => "Inches"
          ),
          "Length" => "5",
          "Width" => "5",
          "Height" => "5"
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
    "Authorization: Bearer TG9iU1FHYUEtVTJGc2RHVmtYMS9RbmFzbXpGbVk1S1lPRjRZVkFkV0h3OS9BUjVqQklqQVRoeUQyMndMSlBwUHhXcVdUSTZqZW5FRzFOQkxIM3dCNnQrTmUxVE9NelE9PQ==",
    "Content-Type: application/json",
    "transId: string",
    "transactionSrc: testing"
  ],
  CURLOPT_POSTFIELDS => json_encode($payload),
  CURLOPT_URL => "https://wwwcie.ups.com/api/rating/" . version . "/" . requestoption . "?" . http_build_query($query),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
]);

$response = curl_exec($curl);
$error = curl_error($curl);

curl_close($curl);

if ($error) {
  echo "cURL Error #:" . $error;
} else {
  echo $response;
}
?>
