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
    "Authorization: Bearer eyJraWQiOiI2NGM0YjYyMC0yZmFhLTQzNTYtYjA0MS1mM2EwZjM2Y2MxZmEiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzM4NCJ9.eyJzdWIiOiJqb2huYXdlc29tZWpyQGdtYWlsLmNvbSIsImNsaWVudGlkIjoiZFJKR2kzbzRmdzhySTh3b05GaE1ZYjNMZmRCeGNkMmNpR0VtcXc5ME9Pc0NNTFE1IiwiaXNzIjoiaHR0cHM6Ly9hcGlzLnVwcy5jb20iLCJ1dWlkIjoiMDNFQTU0MDktRjUyQS0xREE0LUI4REQtRkMyQjNGNzlGODU3Iiwic2lkIjoiNjRjNGI2MjAtMmZhYS00MzU2LWIwNDEtZjNhMGYzNmNjMWZhIiwiYXVkIjoiVGVzdCIsImF0IjoiR0I2UGpjZ0JQQWNhVlQ5UnhtbWVCTUFKR3RaayIsIm5iZiI6MTcwMzQzMTUzNSwic2NvcGUiOiJMb2NhdG9yV2lkZ2V0IiwiRGlzcGxheU5hbWUiOiJUZXN0IiwiZXhwIjoxNzAzNDQ1OTM1LCJpYXQiOjE3MDM0MzE1MzUsImp0aSI6IjQwYzBmYTU0LTNiZTItNGFjNC1hN2Y3LTgzYTFhZWZkMjUyOCJ9.YbbByw6k_4fXKRHU-W-pTNeJ1GoJIyCIwCh6K-xNYHeiv97AGreCLYYZFk2-rOduGMFghqI20OshpFvorIqmZ9VDnTY1bEaHkLY28QWBptEo6cx0VY3W6aJzZbNXu1KJqQTlYSwhffsgPUsGbnVronwsu1pw7A9X3-4GtsyapFMYFYm_WvKSTFYskWJpUzAz55qCQF21bg0VvOIqvv9GTluRinVwEdyA3Qgf-Fh9IYCh90MTQdrPsfh9q-7oMYD304VT03bzfEF1pUFUpE3QgxXm6_I_H7o8DbZ_137kWcGQojO5G8wj1lumwMsAPaXC-CnHpPf02Fds9XV_ghNyV7uFrLM2JIoGzLGm2olAqaj2nEIDyRwEhRFmA6lJO-dV0QErtNQLbjPWe30Fa0Cgcu9YpTCSZgGzyadeSHRDxoLplKNa5gGUTesQg-T2U6XSzya47Ko2Exa5ixySMNQIacqeZcc1C_1dQcsGhKo_OnqIAPFLPKqtT2Ie892wNuTzqn_ceTCzou9aSeGvogXFNEL2TDgpalDf-cFERMxlGzFO2BdimkKOcj0UYwBdV6sgXeoyFPQ2Lkb2RV_bxszc4_2CV-zhmIifFnTEmlUn7wKuDPAt_7gzyUOJvjl_ny3D0tGW8mLtOaG21Fv87DNJhvIdOhFj8n2zpxJZ9q4z7C8",
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
  echo gettype($response);
}
?>