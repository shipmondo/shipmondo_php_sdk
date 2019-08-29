# Shipmondo's official PHP library

This SDK supports Shipmondo API v3.

Specification: https://app.shipmondo.com/api/public/v3/specification

**Note:** If you want to upgrade from [pakkelabels-php-sdk](https://github.com/pakkelabels/pakkelabels-php-sdk) use refer to [this section](#migrating-from-pakkelabelspakkelabels-php-sdk)

## Getting started

Below is a simple PHP script which illustrate the minimum amount of code needed to getting started.

```php5
<?php
  try {
    $client = new Shipmondo('api_user', 'api_key');
  } catch (ShipmondoException $e) {
    echo $e->getMessage();
  }
?>
```

Once the $client object is created, you can begin to use the API.

## Examples
#### Get current balance
```php5
<?php
  echo $client->getAccountBalance();
?>
```
#### Get outstanding payment requests
```php5
<?php
  $params = [
    'created_at_min' => '2019-08-22',
    'page' => 1
  ];
  echo $client->getAccountPaymentRequests($params);
?>
```
#### Get available products
```php5
<?php
  $params = [
    'country_code' => 'DK',
    'carrier_code' => 'gls',
    'page' => 1
  ];
  echo $client->getProducts($params);
?>
```
Pagination is supported

#### Get available / nearest pickup points
```php5
<?php
  $params = [
    'country_code' => 'DK',
    'carrier_code' => 'gls',
    'zipcode' => '5000'
  ];
  echo $client->pickupPoints($params);
?>
```
#### Get shipments
```php5
<?php
  $params = [
    'page' => 1,
    'carrier_code' => 'dao'
  ];
  echo $client->getShipments($params);
?>
```
Pagination is supported

#### Get shipment by id:
```php5
<?php
  $id = 5545625;
  echo $client->getShipment($id);  
?>
```
#### Get label(s) for shipment
```php5
<?php
  $shipment_id = 5545625;
  $params = [
    'label_format' => '10x19_pdf'
  ];
  echo $client->getShipmentLabels($shipment_id, $params);  
?>
```
#### Create shipment
```php5
<?php
  $params = [
    "test_mode" => true,
    "own_agreement" => true,
    "label_format" => "a4_pdf",
    "product_code" => "GLSDK_HD",
    "service_codes" => "EMAIL_NT,SMS_NT",
    "order_id" => "10001",
    "reference" => "Webshop 10001",
    "sender" => [
      "name" => "Shipmondo ApS",
      "address1" => "Strandvejen 6B",
      "address2" => null,
      "country_code" => "DK",
      "zipcode" => "5240",
      "city" => "Odense NØ",
      "attention" => null,
      "email" => "firma@email.dk",
      "telephone" => "70400407",
      "mobile" => "70400407"       
    ),
    "receiver" => [
      "name" => "Lene Jensen",
      "address1" => "Vindegade 112",
      "address2" => null,
      "country_code" => "DK",
      "zipcode" => "5000",
      "city" => "Odense C",
      "attention" => null,
      "email" => "lene@email.dk",
      "telephone" => "50607080",
      "mobile" => "50607080",
      "instruction" => null
    ),
    "parcels" => [
      [
        "weight" => 1000
      ]
    ),
  ];
  echo $client->createShipment($params);
?>
```
#### Get shipment monitor statuses
```php5
<?php
  $params = [
    'ids' => '5546689,5546696',
    'page' => 1
  ];
  echo $client->getShipmentMonitorStatuses($params);  
?>
```
#### Get print queue entries
```php5
<?php
  $params = [
    'page' => 1
  ];
  echo print_r($client->getPrintQueueEntries($params);
?>
```
#### Get return portals
```php5
<?php
  $params = [
    'page' => 1
  ];
  echo $client->getReturnPortals($params);  
?>
```
#### Get return portal by id
```php5
<?php
  $id = 4766;
  echo $client->getReturnPortal($id);  
?>
```
#### Get return shipments for return portal
```php5
<?php
  $return_portal_id = 4766;
  $params = [
    'page' => 1
  ];
  echo $client->getReturnPortalShipments($return_portal_id, $params);  
?>
```
Pagination is supported
#### Get imported shipments
```php5
<?php
  $params = [
    'page' => 1
  ];
  echo $client->getImportedShipments($params);
?>
```
Pagination is supported
#### Get imported shipment by id
```php5
<?php
  $id = 75545625;
  echo $client->getImportedShipment($id);
?>
```
#### Create imported shipment
```php5
<?php
  $params = [
    "carrier_code" => "gls",
    "product_code" => "GLSDK_HD",
    "service_codes" => "EMAIL_NT,SMS_NT",
    "order_id" => "10001",
    "reference" => "Webshop 10001",
    "sender" => [
      "name" => "Shipmondo ApS",
      "address1" => "Strandvejen 6B",
      "address2" => null,
      "country_code" => "DK",
      "zipcode" => "5240",
      "city" => "Odense NØ",
      "attention" => null,
      "email" => "firma@email.dk",
      "telephone" => "70400407",
      "mobile" => "70400407"       
    ],
    "receiver" => [
      "name" => "Lene Jensen",
      "address1" => "Vindegade 112",
      "address2" => null,
      "country_code" => "DK",
      "zipcode" => "5000",
      "city" => "Odense C",
      "attention" => null,
      "email" => "lene@email.dk",
      "telephone" => "50607080",
      "mobile" => "50607080",
      "instruction" => null
    ]
  ];
  echo $client->createImportedShipment($params);
?>
```
#### Update imported shipment by id
```php5
<?php
  $id = 75545625;
  $params = [
    "carrier_code" => "gls",
    "product_code" => "GLSDK_HD",
    "service_codes" => "EMAIL_NT,SMS_NT",
    "order_id" => "10001",
    "reference" => "Webshop 10001",
    "sender" => [
      "name" => "Shipmondo ApS",
      "address1" => "Strandvejen 6B",
      "address2" => null,
      "country_code" => "DK",
      "zipcode" => "5240",
      "city" => "Odense NØ",
      "attention" => null,
      "email" => "firma@email.dk",
      "telephone" => "70400407",
      "mobile" => "70400407"       
    ],
    "receiver" => [
      "name" => "Lene Jensen",
      "address1" => "Vindegade 112",
      "address2" => null,
      "country_code" => "DK",
      "zipcode" => "5000",
      "city" => "Odense C",
      "attention" => null,
      "email" => "lene@email.dk",
      "telephone" => "50607080",
      "mobile" => "50607080",
      "instruction" => null
    ]
  ];
  echo $client->updateImportedShipment($id, $params);
?>
```
#### Delete/archive an imported shipment by id
```php5
<?php
  $id = 75545625;
  echo $client->deleteImportedShipment($id);
?>
```

## Migrating from [pakkelabels-php-sdk](https://github.com/pakkelabels/pakkelabels-php-sdk)

If you have used the pakkelabels-php-sdk library and you want to upgrade to shipmondo_php_sdk, you have to do as follows:
- Change _Pakkelabels.php_ to _Shipmondo.php_ in any require you use
- Change references to the _Pakkelabels_ and _PakkelabelsException_ class to _Shipmondo_ and _ShipmondoException_
- All function calls must be changes to camelCase i.e. _create\_shipment_ -> _createShipment_
- All GET function calls must add _get_ in front of, as well as camelCase i.e. _account\_balance_ -> _getAccountBalance_
