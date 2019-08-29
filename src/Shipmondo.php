<?php
require_once('ShipmondoException.php');

class Shipmondo {
    const API_ENDPOINT = 'https://app.shipmondo.com/api/public/v3';
    const VERSION = '3.1.0';

    private $_api_user;
    private $_api_key;

    public function __construct($api_user, $api_key, $api_base_path=self::API_ENDPOINT){
    $this->_api_user = $api_user;
        $this->_api_key = $api_key;
        $this->_api_base_path = $api_base_path;
    }

    public function getAccountBalance() {
        $result = $this->_makeApiCall("/account/balance", 'GET');
        return $result;
    }
    
    public function getAccountPaymentRequests($params = []) {
        $result = $this->_makeApiCall("/account/payment_requests", 'GET', $params);
        return $result;
    }
    
    public function getProducts($params = []) {
        $result = $this->_makeApiCall("/products", 'GET', $params);
        return $result;
    }
    
    public function getPackageTypes($params = []) {
        $result = $this->_makeApiCall("/package_types", 'GET', $params);
        return $result;
    }
    
    public function getShipments($params = []) {
        $result = $this->_makeApiCall("/shipments", 'GET', $params);
        return $result;
    }
    
    public function createShipment($params) {
        $result = $this->_makeApiCall("/shipments", 'POST', $params);
        return $result;
    }
    
    public function getShipment($id) {
        $result = $this->_makeApiCall("/shipments/$id", 'GET');
        return $result;
    }
    
    public function getShipmentLabels($shipment_id, $params = []) {
        $result = $this->_makeApiCall("/shipments/$shipment_id/labels", 'GET', $params);
        return $result;
    }
    
    public function getShipmentProformaInvoices($shipment_id) {
        $result = $this->_makeApiCall("/shipments/$shipment_id/proforma_invoices", 'GET');
        return $result;
    }
    
    public function getCmrWaybills($params = []) {
        $result = $this->_makeApiCall("/cmr_waybills", 'GET', $params);
        return $result;
    }
    
    public function createCmrWaybill($params) {
        $result = $this->_makeApiCall("/cmr_waybills", 'POST', $params);
        return $result;
    }
    
    public function getCmrWaybill($id) {
        $result = $this->_makeApiCall("/cmr_waybills/$id", 'GET');
        return $result;
    }
    
    public function getImportedShipments($params = []) {
        $result = $this->_makeApiCall("/imported_shipments", 'GET', $params);
        return $result;
    }
    
    public function createImportedShipment($params) {
        $result = $this->_makeApiCall("/imported_shipments", 'POST', $params);
        return $result;
    }
    
    public function getImportedShipment($id) {
        $result = $this->_makeApiCall("/imported_shipments/$id", 'GET');
        return $result;
    }
    
    public function updateImportedShipment($id, $params) {
        $result = $this->_makeApiCall("/imported_shipments/$id", 'PUT', $params);
        return $result;
    }
    
    public function deleteImportedShipment($id) {
        $result = $this->_makeApiCall("/imported_shipments/$id", 'DELETE');
        return $result;
    }
    
    public function getPickupPoints($params) {
        $result = $this->_makeApiCall("/pickup_points", 'GET', $params);
        return $result;
    }
    
    public function getShipmentMonitorStatuses($params) {
        $result = $this->_makeApiCall("/shipment_monitor_statuses", 'GET', $params);
        return $result;
    }
    
    public function getShipmentMonitorDetails($params) {
        $result = $this->_makeApiCall("/shipment_monitor_details", 'GET', $params);
        return $result;
    }
    
    public function getPrintQueueEntries($params = []) {
        $result = $this->_makeApiCall("/print_queue_entries", 'GET', $params);
        return $result;
    }
    
    public function getPrinters() {
        $result = $this->_makeApiCall("/printers", 'GET');
        return $result;
    }
    
    public function getReturnPortals($params = []) {
        $result = $this->_makeApiCall("/return_portals", 'GET', $params);
        return $result;
    }
    
    public function getReturnPortal($id) {
        $result = $this->_makeApiCall("/return_portals/$id", 'GET');
        return $result;
    }
    
    public function getReturnPortalShipments($return_portal_id, $params = []) {
        $result = $this->_makeApiCall("/return_portals/$return_portal_id/shipments", 'GET', $params);
        return $result;
    }
    
    public function getLabels($params) {
        $result = $this->_makeApiCall("/labels", 'GET', $params);
        return $result;
    }
    
    public function getQuote($params) {
        $result = $this->_makeApiCall("/quotes", 'POST', $params);
        return $result;
    }
    
    public function getCarriers($params) {
        $result = $this->_makeApiCall("/carriers", 'GET', $params);
        return $result;
    }
    
    public function getShipmentTemplates($params = []) {
        $result = $this->_makeApiCall("/shipment_templates", 'GET', $params);
        return $result;
    }
    
    public function getShipmentTemplate($id) {
        $result = $this->_makeApiCall("/shipment_templates/$id", 'GET');
        return $result;
    }
    
    public function getSalesOrders($params = []) {
        $result = $this->_makeApiCall("/sales_orders", 'GET', $params);
        return $result;
    }
    
    public function createSalesOrder($params) {
        $result = $this->_makeApiCall("/sales_orders", 'POST', $params);
        return $result;
    }
    
    public function getSalesOrder($id) {
        $result = $this->_makeApiCall("/sales_orders/$id", 'GET');
        return $result;
    }
    
    public function getPaymentGateways($params = []) {
        $result = $this->_makeApiCall("/payment_gateways", 'GET', $params);
        return $result;
    }
    
    public function getPaymentGateway($id) {
        $result = $this->_makeApiCall("/payment_gateways/$id", 'GET');
        return $result;
    }
    
    public function getDocumentEndOfDay($params) {
        $result = $this->_makeApiCall("/documents/end_of_day", 'GET', $params);
        return $result;
    }
    
    public function getDocumentWaybill($params) {
        $result = $this->_makeApiCall("/documents/waybill", 'GET', $params);
        return $result;
    }
    
    public function getPickupRequests($params = []) {
        $result = $this->_makeApiCall("/pickup_requests", 'GET', $params);
        return $result;
    }
    
    public function createPickupRequest($params) {
        $result = $this->_makeApiCall("/pickup_requests", 'POST', $params);
        return $result;
    }
    
    public function getPickupRequest($id) {
        $result = $this->_makeApiCall("/pickup_requests/$id", 'GET');
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