<?php

// Set your application credentials
$clientID = 'dRJGi3o4fw8rI8woNFhMYb3LfdBxcd2ciGEmqw90OOsCMLQ5';
$clientSecret = 'G6dk2G5Hw1GrExvXGeGEr0A0ZcR0JaTT1QAASHtA94oDEun1TiO910Yb633RLn4d';
$redirectURI = 'https://https://playground.christensencreativeco.com/callBackUrl.php';

// Step 1: Initiate the authorization process
$authUrl = 'https://wwwcie.ups.com/security/v1/oauth/authorize';
$authUrl .= '?client_id=' . urlencode($clientID);
$authUrl .= '&redirect_uri=' . urlencode($redirectURI);
$authUrl .= '&response_type=code';

// Redirect the user to UPS login screen
header('Location: ' . $authUrl);
exit;

// Step 2: After user login, UPS redirects back to your callback URL
// Ensure to handle the callback URL in your application

// Step 3: Retrieve Auth-Code from the callback URL
if (isset($_GET['code'])) {
    $authCode = $_GET['code'];

    // Step 4: Exchange Auth-Code for an access token
    $tokenUrl = 'https://wwwcie.ups.com/security/v1/oauth/token';
    $tokenHeaders = [
        'Authorization: Basic ' . base64_encode($clientID . ':' . $clientSecret),
        'Content-Type: application/x-www-form-urlencoded',
    ];

    $tokenData = [
        'grant_type' => 'authorization_code',
        'code' => $authCode,
    ];

    $tokenResponse = makeCurlRequest($tokenUrl, 'POST', $tokenHeaders, $tokenData);

    // Process the token response
    if ($tokenResponse) {
        // Extract and store the access token and refresh token securely
        $accessToken = $tokenResponse['access_token'];
        $refreshToken = $tokenResponse['refresh_token'];

        // Use the access token to make API calls on behalf of the user
        // ...

        // Step 5: Refresh the access token when needed
        $refreshUrl = 'https://apis-pt.ups.com/security/v1/oauth/refresh';
        $refreshData = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ];

        $refreshResponse = makeCurlRequest($refreshUrl, 'POST', $tokenHeaders, $refreshData);

        // Process the refresh token response
        if ($refreshResponse) {
            // Update the access token with the new one
            $newAccessToken = $refreshResponse['access_token'];

            // Use the new access token to make API calls
            // ...
        }
    }
}

// Helper function to make cURL requests
function makeCurlRequest($url, $method, $headers, $data = null)
{
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    if ($data !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);

    return json_decode($response, true);
}
?>
