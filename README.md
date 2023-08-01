# UPS API Shipping Cost Calculator with Required OAuth2 Authentication 🚀

Welcome to the UPS Shipping Cost Calculator script! 🚀

Please note that UPS now mandates the use of OAuth2 authentication for accessing their API, ensuring the highest level of security and compliance. 🔒

## Getting Started ✨

Before you begin, make sure you have your UPS API credentials handy - the `client_id` and `client_secret`.

## How it Works 🔧

1. The script uses the required OAuth2 authentication to access the UPS API. You must provide the `client_id` and `client_secret` as part of this authentication process. This change has been implemented by UPS to enhance the security of the API. 🗝️

2. Customize the shipment details in the `$package_info`, `$shipper_info`, `$to_address_info`, and `$from_address_info` arrays. Choose from the various UPS shipping service and package type options available.

### Available UPS Shipping Service Options 📦

- Domestic:
  - 14: UPS Next Day Air Early
  - 01: UPS Next Day Air
  - 13: UPS Next Day Air Saver
  - 59: UPS 2nd Day Air A.M.
  - 02: UPS 2nd Day Air
  - 12: UPS 3 Day Select
  - 03: UPS Ground

- International:
  - 11: UPS Standard
  - 07: UPS Worldwide Express
  - 54: UPS Worldwide Express Plus
  - 08: UPS Worldwide Expedited
  - 65: UPS Worldwide Saver
  - 96: UPS Worldwide Express Freight
  - 82: UPS Today Standard
  - 83: UPS Today Dedicated Courier
  - 84: UPS Today Intercity
  - 85: UPS Today Express
  - 86: UPS Today Express Saver
  - 70: UPS Access Point Economy

### Available Package Type Options 📦

- 01: Bag
- 02: Box
- 03: Carton/Piece
- 04: Crate
- 05: Drum
- 06: Pallet/Skid
- 07: Roll
- 08: Tube

3. Save the code in a PHP file and run it.

4. The script will obtain an access token from the UPS API using the mandatory OAuth2 authentication method. Then, it will calculate the shipping cost based on your inputs.

5. Voilà! The calculated shipping cost will be displayed as a delightful surprise! 💰

## Important Notes 📋

- To keep things both secure and efficient, ensure that your server has cURL enabled to execute the API requests. Safety first! 🔐

- The script uses the UPS API, and the required OAuth2 authentication ensures that your data is handled with the highest level of security.

- Feel free to customize the code to suit your specific use case. Have fun experimenting!

## Let's Get Shipping! 📦

Now that you have the power of the UPS Shipping Cost Calculator with required OAuth2 authentication, go ahead and give it a spin! 💫

Please remember to use the UPS API responsibly and follow their usage guidelines. Happy shipping, and may your packages reach their destination with love and speed! ❤️
