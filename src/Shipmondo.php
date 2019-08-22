<?php
require_once('ShipmondoException.php');

class Shipmondo {
    const API_ENDPOINT = 'https://app.shipmondo.com/api/public/v3';
    const VERSION = '3.0';

    private $_api_user;
    private $_api_key;

    public function __construct($api_user, $api_key, $api_base_path=self::API_ENDPOINT){
    $this->_api_user = $api_user;
        $this->_api_key = $api_key;
        $this->_api_base_path = $api_base_path;
    }

    public function accountBalance() {
        $result = $this->_makeApiCall('/account/balance');
        return $result;
    }

    public function accountPaymentRequests($params) {
        $result = $this->_makeApiCall('/account/payment_requests', 'GET', $params);
        return $result;
    }

    public function products($params) {
        $result = $this->_makeApiCall('/products', 'GET', $params);
        return $result;
    }

    public function pickupPoints($params) {
        $result = $this->_makeApiCall('/pickup_points', 'GET', $params);
        return $result;
    }

    public function shipmentMonitorStatuses($params) {
        $result = $this->_makeApiCall('/shipment_monitor_statuses', 'GET', $params);
        return $result;
    }  

    public function returnPortals($params) {
        $result = $this->_makeApiCall('/return_portals', 'GET', $params);
        return $result;
    }  
  
    public function returnPortal($id) {
        $result = $this->_makeApiCall('/return_portals/' . $id);
        return $result;
    }

    public function returnPortalShipments($return_portal_id, $params) {
        $result = $this->_makeApiCall('/return_portals/' . $return_portal_id . '/shipments');
        return $result;
    }

    public function shipments($params) {
        $result = $this->_makeApiCall('/shipments', 'GET', $params);
        return $result;
    }

    public function shipment($id) {
        $result = $this->_makeApiCall('/shipments/' . $id);
        return $result;
    }

    public function shipmentLabels($id, $params) {
        $result = $this->_makeApiCall('/shipments/' . $id . '/labels', 'GET', $params);
        return $result;
    }

    public function createShipment($params) {
        $result = $this->_makeApiCall('/shipments', 'POST', $params);
        return $result;
    }

    public function printQueueEntries($params) {
        $result = $this->_makeApiCall('/print_queue_entries', 'GET', $params);
        return $result;
    }  

    public function importedShipments($params) {
        $result = $this->_makeApiCall('/imported_shipments', 'GET', $params);
        return $result;
    }

    public function importedShipment($id) {
        $result = $this->_makeApiCall('/imported_shipments/' . $id);
        return $result;
    }

    public function createImportedShipment($params) {
        $result = $this->_makeApiCall('/imported_shipments', 'POST', $params);
        return $result;
    }

    public function updateImportedShipment($id, $params) {
        $result = $this->_makeApiCall('/imported_shipments/'. $id, 'PUT', $params);
        return $result;
    }

    public function deleteImportedShipment($id) {
        $result = $this->_makeApiCall('/imported_shipments/'. $id, 'DELETE');
        return $result;
    }

    public function labels($params) {
        $result = $this->_makeApiCall('/labels/', 'GET', $params);
        return $result;
    }

    private function _makeApiCall($path, $method = 'GET', $params = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD, $this->_api_user . ":" . $this->_api_key);
        $params['user_agent'] = 'smd_php_library v' . self::VERSION;

        switch ($method) {
            case 'GET':
                $query = http_build_query($params);
                curl_setopt($ch, CURLOPT_URL, $this->_api_base_path . '/' . $path . '?' . $query);
                break;
            case 'POST':
                $query = json_encode($params);
                curl_setopt($ch, CURLOPT_URL, $this->_api_base_path . '/' . $path);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($query)
                ]);
                break;
            case 'PUT':
                $query = json_encode($params);
                curl_setopt($ch, CURLOPT_URL, $this->_api_base_path . '/' . $path);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($query)
                ]);
                break;
            case 'DELETE':
                $query = http_build_query($params);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); 
                curl_setopt($ch, CURLOPT_URL, $this->_api_base_path . '/' . $path . '?' . $query);
                break;
        }

        $headers = [];
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // this function is called by curl for each header received
        curl_setopt($ch, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $name = strtolower(trim($header[0]));
                if (!array_key_exists($name, $headers))
                    $headers[$name] = [trim($header[1])];
                else
                    $headers[$name][] = trim($header[1]);

                return $len;
            }
        );

        $output = curl_exec($ch);
        $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
        $output = json_decode($output, true);
        
        curl_close($ch);
        
        if ($http_code != 200) {
            throw new ShipmondoException($output['error']);
        }

        $pagination = $this->_extractPagination($headers);

        $output = [
            'output' => $output,
            'pagination' => $pagination
        ];

        return $output;
  }

  private function _extractPagination($headers) {
    $arr = ['x-per-page', 'x-current-page', 'x-total-count', 'x-total-pages'];
    $pagination = [];
    foreach ($arr as &$key) {
      if (array_key_exists($key, $headers))
        $pagination[$key] = $headers[$key][0];
      else
        return $pagination;
    }
    
    return $pagination;
  }

}
?>