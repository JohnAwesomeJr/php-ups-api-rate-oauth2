<?php
/**
 * Requires libcurl
 */

//  Used to define the request type. 
// Valid Values:
// Rate = The server rates (The default Request option is Rate if a Request Option is not provided). 
// Shop = The server validates the shipment, and returns rates for all UPS products from the ShipFrom to the ShipTo addresses. 
// Ratetimeintransit = The server rates with transit time 
// informationShoptimeintransit = The server validates the shipment, and returns rates and transit times for all UPS products from the ShipFrom to the ShipTo addresses.
// Rate is the only valid request option for UPS Ground Freight Pricing requests.

const version = "v2205";
const requestoption = "Rate";
$query = array();

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
    "Authorization: Bearer eyJraWQiOiI2NGM0YjYyMC0yZmFhLTQzNTYtYjA0MS1mM2EwZjM2Y2MxZmEiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzM4NCJ9.eyJzdWIiOiJqb2huYXdlc29tZWpyQGdtYWlsLmNvbSIsImNsaWVudGlkIjoiZFJKR2kzbzRmdzhySTh3b05GaE1ZYjNMZmRCeGNkMmNpR0VtcXc5ME9Pc0NNTFE1IiwiaXNzIjoiaHR0cHM6Ly9hcGlzLnVwcy5jb20iLCJ1dWlkIjoiMDNFQTU0MDktRjUyQS0xREE0LUI4REQtRkMyQjNGNzlGODU3Iiwic2lkIjoiNjRjNGI2MjAtMmZhYS00MzU2LWIwNDEtZjNhMGYzNmNjMWZhIiwiYXVkIjoiVGVzdCIsImF0IjoiMmI4MDBLQzBUSzI0enBtT1ZjeXNkSUhGRzJvQSIsIm5iZiI6MTcwMzQzODk2MCwic2NvcGUiOiJMb2NhdG9yV2lkZ2V0IiwiRGlzcGxheU5hbWUiOiJUZXN0IiwiZXhwIjoxNzAzNDUzMzYwLCJpYXQiOjE3MDM0Mzg5NjAsImp0aSI6IjNlODBlN2VmLWUzMTQtNGQwMy04OWExLTM0ZTQ0MWZmYTdjMiJ9.AB77JZUDYy6d9bC9XK8U5QnBA64BnxbLB6GTznIWQZmZaiH2Z45vtCA8G6dPsTOUqGeZVnFYsgG4lGStnN27dLLiSrA4CrkYzBc9hY80iOuS2Tm3PnTk9T4MUIGL3WFHIckKTzoggO1l9W64V8xbPtvghaBAtIQgDhCQOnVJqXBMJlBGZJ_WkSMetUPuToloAqDeOASSzlu182ikheK7XWSHI8LgFx8A4RNKTd0nSZr1gx5G3YPnA0V5GePZvO4jxVg_n1ncLZwgrK0cnGuuS77RVROou6UeTUqoWwgem6gBXstD_xh1IXFuQZuIz7KsQ2DkLwtoKNUxVCAtK89kWhEDLkWr_0fv3riBStTeYj-Ig3AEFLGNaxT_-w06vJa2GEeN9KOym4du-jNUhvyYQqbWyV7QMb0NzyiwWanHT7GGl4Vv8C7xQe3OUM3nLq2jV6KIeqgcnTIZJ2aDBD_NoBy1b8w69WZWaC0SyxUqlkx5ihScBPVKUrI6TJiz59nG2NvW0hhWAVwzFObvRT2AbokhBNsg-Qx_vPNUWW1xUpHJE4JCdVq3cSmUuDkjnZJXwRgcSZIaElyDq_l_QRpEtC74bS42btE1rG2BuJg2mz1QX9RHnerox5wCLd8XRMnMVsN0EPD0gPR2N4pRYOAHEftsCla3o9BZr6zdUDep9mc",
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
  header('Content-Type: application/json');
  $phpResponseObject = json_decode($response);
  echo json_encode($phpResponseObject->RateResponse->RatedShipment->TotalCharges->MonetaryValue);
}
?>