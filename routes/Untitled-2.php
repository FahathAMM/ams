<?php

error_reporting(1);

date_default_timezone_set('Asia/Dubai');

include "db_conection.php";
include_once "execute_sp.php";

// Define a class for the SAP integration
class SapIntegration
{
    private $mysqli;
    private $sessionId;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function login()
    {
        $url = 'https://192.168.1.150:50000/b1s/v1/Login';
        $data = [
            'CompanyDB' => 'NOOR_INT',
            'Password' => 'Admin@123',
            'UserName' => 'manager',
        ];

        $result = $this->callApi("POST", $url, $data);
        if (isset($result->SessionId)) {
            $this->sessionId = $result->SessionId;
        }

        return $this->sessionId;
    }

    public function exportDepoTransfer()
    {
        if (empty($this->sessionId)) {
            throw new Exception("User not logged in.");
        }

        $paramArray = [
            date('Y-m-d'), //1: var_date
        ];

        $params = "'" . implode("','", $paramArray) . "'";
        $call_sp = "CALL int_exp_sap_depo_transfer($params)";
        $depotDataResponse = executequery($this->mysqli, $call_sp)[0];

        $groupedData = $this->prepareToDepoExport($depotDataResponse);
        $postUrl = 'https://192.168.1.150:50000/b1s/v1/InventoryTransferRequests';

        foreach ($groupedData as $key => $item) {
            $itemGroupResponse = $this->callApi("POST", $postUrl, $item, $this->sessionId);
            $this->logMessage(json_encode(['payload' => $item['DocEntry'], 'response' => $itemGroupResponse], JSON_PRETTY_PRINT), 'load_export_log.log');
        }
    }

    public function prepareToDepoExport($data)
    {
        $groupedData = [];
        $sr = 1;

        foreach ($data as $item) {
            $docEntry = (int) $item['LOADSHEETNUMBER'];
            $docDate = $item['LOADTRANSACTIONDATE'] . "T00:00:00Z";

            // $this->logMessage(json_encode(['doc' => $docEntry, 'cond' => !isset($groupedData[$docEntry]) ], JSON_PRETTY_PRINT));

            // Initialize the parent document if not already created
            if (!isset($groupedData[$docEntry])) {
                $groupedData[$docEntry] = [
                    "DocEntry" => $docEntry,
                    "DocDate" => $docDate,
                    "Comments" => $item['REASON'],
                    "FromWarehouse" => $item['FROMDEPOT'],
                    "ToWarehouse" => $item['TODEPOT'],
                    "DocNum" => $docEntry,
                    "U_Division" => "",
                    "StockTransferLines" => [],
                ];
                // $this->logMessage(json_encode(['sr' => $sr], JSON_PRETTY_PRINT));
                // $sr++;
            }

            // Add each item as a StockTransferLine entry under the corresponding DocEntry
            $groupedData[$docEntry]['StockTransferLines'][] = [
                "DocEntry" => $docEntry,
                "ItemCode" => $item['ITEMCODE'],
                "Quantity" => (float) $item['QUANTITY'],
                "WarehouseCode" => $item['TODEPOT'],
                "FromWarehouseCode" => $item['FROMDEPOT'],
                "UoMCode" => $item['UOM'],
            ];
        }

        // Convert associative array to indexed array for final output
        return array_values($groupedData);
    }

    public function exportReturn()
    {
        if (empty($this->sessionId)) {
            throw new Exception("User not logged in.");
        }

        $paramArray = [
            date('Y-m-d'), //1: var_date
        ];

        $params = "'" . implode("','", $paramArray) . "'";
        $call_sp = "CALL int_exp_sap_depo_transfer($params)";
        $depotDataResponse = executequery($this->mysqli, $call_sp)[0];

        $groupedData = $this->prepareToDepoExport($depotDataResponse);
        $postUrl = 'https://192.168.1.150:50000/b1s/v1/InventoryTransferRequests';

        foreach ($groupedData as $key => $item) {
            $itemGroupResponse = $this->callApi("POST", $postUrl, $item, $this->sessionId);
            $this->logMessage(json_encode(['payload' => $item['DocEntry'], 'response' => $itemGroupResponse], JSON_PRETTY_PRINT), 'load_export_log.log');
        }
    }

    public function logMessage($message, $logFile = 'log.log')
    {
        $logDir = 'logs';

        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $date = date('Y-m-d H:i:s');
        $formattedMessage = "[$date] $message" . PHP_EOL;

        file_put_contents("$logDir/$logFile", $formattedMessage, FILE_APPEND);
    }

    public function importItemGroup()
    {
        if (empty($this->sessionId)) {
            throw new Exception("User not logged in.");
        }

        $getUrl = 'https://192.168.1.150:50000/b1s/v1/ItemGroups';
        $itemGroupResponse = $this->callApi("GET", $getUrl, null, $this->sessionId);

        if (isset($itemGroupResponse->value)) {
            foreach ($itemGroupResponse->value as $item) {
                $valueSets[] = $this->saveItemGroup($item);
            }

            $table = "int_imp_itemgroup";
            $columns = ["ITEMGROUPID", "SUBMAJORCATEGORYID", "ITEMGROUPNAME", "ARABICITEMGROUPNAME", "ACTIVESTATUS", "PAGENO", "CDATE", "LOG1"];
            $finalResponse = [];

            $this->truncateTable($table);

            $query = $this->insertQuery($table, $columns, $valueSets);

            executequery($this->mysqli, $query);

            $isRowExist = $this->numberOfTempTableRows($table)['tempcount'];

            if ($isRowExist > 0) {
                $this->validateTable('itemgroup');
                $this->executeMainTable('sp_int_imp_itemgroup');

                // $message = $this->errorStatus('itemgroup')[0][0];

                // if ($message['result'] == 'Success') {
                //     $finalResponse = [
                //         'msg' => 'Success',
                //         'response' => null,
                //     ];
                // } else {
                //     $logs = $this->logStatus('itemgroup');
                //     $finalResponse = [
                //         'msg' => 'Not found',
                //         'response' => $logs,
                //     ];
                // }

                // $this->logMessage(json_encode($finalResponse, JSON_PRETTY_PRINT));
            }
        }
    }

    private function saveItemGroup($item)
    {
        $var_itemgroup_id = $item->Number;
        $var_sub_itemgroup_id = 1; // You can modify this if needed
        $var_itemgroup_name = $item->GroupName;
        $var_arabic_itemgroup_name = $item->GroupName; // Modify this if you have a specific Arabic name field
        $var_active_status = 1; // Active status, assuming 1 means active
        $var_page_no = ''; // Modify if you have a page number value
        $var_log1 = ''; // Modify if you have a log1 value
        $var_cdate = ''; // Modify if you need a specific date value

        $valueSets = "('$var_itemgroup_id', '$var_sub_itemgroup_id', '$var_itemgroup_name', '$var_arabic_itemgroup_name', '$var_active_status', '$var_page_no', NOW(), '$var_log1')";
        return $valueSets;
    }

    public function importItem()
    {
        if (empty($this->sessionId)) {
            throw new Exception("User not logged in.");
        }

        $baseUrl = "https://192.168.1.150:50000/b1s/v1/Items";

        $filter = urlencode("SalesItem eq 'Y'");
        $select = urlencode("ItemCode,ItemName,ForeignName,BarCode,SalesUnit,ItemsGroupCode,Valid,ItemPrices,SalesVATGroup,U_Product,U_Category,U_PrdType");

        $getUrl = "$baseUrl?\$filter=$filter&\$select=$select";

        $pageno = 1;
        $valueSets = [];
        $table = "int_imp_item";
        $columns = [
            "ITEMCODE", // 1: Item Code
            "ITEMSHORTDESCRIPTION", // 2: Short Description
            "ITEMDESCRIPTION", // 3: Description
            "ARABICITEMDESCRIPTION", // 4: Arabic Item Description
            "ARABICLONGITEMDECRIPTION", // 5: Arabic Long Item Description
            "UNITSPERCASE", // 6: Units per Case
            "BARCODEEACH", // 7: Barcode Each
            "BARCODECARTON", // 8: Barcode Carton
            "EACHSALESPRICE", // 9: Each Sales Price
            "CARTONSALESPRICE", // 10: Carton Sales Price
            "EACHRETURNPRICE", // 11: Each Return Price
            "CARTONRETURNPRICE", // 12: Carton Return Price
            "UOMEACH", // 13: UOM Each
            "UOMCARTON", // 14: UOM Carton
            "ACTIVEITEM", // 15: Active Item
            "STATUS", // 16: Status
            "ITEMGROUPID", // 17: Item Group ID
            "PAGENO", // 18: Page No
            'SALESVATGROUP', // 19: Creation Date
            'UPRODUCT', // 20: Creation Date
            'UCATEGORY', // 21: Creation Date
            'UPRDTYPE', // 22: Creation Date

            "CDATE", // always last: Creation Date

        ];
        $finalResponse = [];

        do {
            $itemResponse = $this->callApi("GET", $getUrl, null, $this->sessionId);

            if (isset($itemResponse->value) && is_array($itemResponse->value)) {
                foreach ($itemResponse->value as $item) {
                    $item->PageNo = $pageno;
                    $valueSets[] = $this->saveItemMaster($item);
                }
            } else {
                $this->logMessage("Unexpected response format or no data received.");
            }

            $this->logMessage(json_encode(['url' => $getUrl, 'response' => $pageno], JSON_PRETTY_PRINT));
            $getUrl = isset($itemResponse->{'odata.nextLink'}) ? 'https://192.168.1.150:50000/b1s/v1/' . $itemResponse->{'odata.nextLink'} : false;
            $pageno++;
        } while ($getUrl);

        if (count($valueSets) > 0) {

            $this->truncateTable($table);

            $query = $this->insertQuery($table, $columns, $valueSets);

            $this->logMessage($query);

            executequery($this->mysqli, $query);

            $isRowExist = $this->numberOfTempTableRows($table)['tempcount'];

            if ($isRowExist > 0) {
                $this->validateTable('item');

                $this->executeMainTable('sp_int_imp_item');

                return 'executeMainTable';

                $message = $this->errorStatus('item')[0][0];

                // if ($message['result'] == 'Success') {
                //     $finalResponse = [
                //         'msg' => 'Success',
                //         'response' => null,
                //     ];
                // } else {
                //     $logs = $this->logStatus('item');
                //     $finalResponse = [
                //         'msg' => 'Not found',
                //         'response' => $logs,
                //     ];
                // }

                // $this->logMessage(json_encode($finalResponse, JSON_PRETTY_PRINT), 'log_itemmaster.log');
            }
        }
    }

    private function saveItemMaster($item)
    {
        $price = $item->ItemPrices[0]->Price;
        // $price = 10; // $item->ItemPrices[0]->Price;
        $status = $item->Valid == 'tYES' ? 1 : 0;

        $paramArray = [
            $item->ItemCode, // 1: ITEMCODE
            $item->ItemName, // 2: ITEMSHORTDESCRIPTION
            $item->ItemName, // 3: ITEMDESCRIPTION
            $item->ForeignName, // 4: ARABICITEMDESCRIPTION
            $item->ForeignName, // 5: ARABICLONGITEMDESCRIPTION
            1, // 6: UNITSPERCASE
            $item->BarCode, // 7: BARCODEEACH
            $item->BarCode, // 8: BARCODECARTON
            $price, // 9: EACHSALESPRICE
            $price, // 10: CARTONSALESPRICE
            $price, // 11: EACHRETURNPRICE
            $price, // 12: CARTONRETURNPRICE
            $item->SalesUnit, // 13: UOMEACH
            $item->SalesUnit, // 14: UOMCARTON
            $status, // 15: ACTIVEITEM
            $status, // 16: STATUS
            $item->ItemsGroupCode, // 17: ITEMGROUPID
            $item->PageNo, // 18: PAGENO

            $item->SalesVATGroup, // 19: SalesVATGroup
            $item->U_Product, // 20: UProduct
            $item->U_Category, // 21: UCategory
            $item->U_PrdType, // 22: UPrdType

        ];

        $valueSets = "('" . implode("', '", $paramArray) . "', NOW())";
        return $valueSets;
    }

    public function importSalesman()
    {
        if (empty($this->sessionId)) {
            throw new Exception("User not logged in.");
        }

        $getUrl = "https://192.168.1.150:50000/b1s/v1/SalesPersons";

        $pageno = 1;
        $valueSets = [];
        $table = "int_imp_salesman";
        $columns = [
            "SALESMANCODE", // 1: Salesman Code
            "SALESNAME", // 2: Sales Name
            "ARABICSALESNAME", // 3: Arabic Sales Name
            "DIVISION_CODE", // 4: Division Code
            "STATUS", // 5: Status
            "COMPANYCODE", // 6: Company Code
            "PAGENO", // 7: Page No

            "CDATE", // always last: Creation Date

        ];
        $finalResponse = [];

        do {
            $itemResponse = $this->callApi("GET", $getUrl, null, $this->sessionId);

            if (isset($itemResponse->value) && is_array($itemResponse->value)) {
                foreach ($itemResponse->value as $item) {
                    if ($item->SalesEmployeeCode > 0) {
                        $item->PageNo = $pageno;
                        $valueSets[] = $this->saveSalesman($item);
                    }
                }
            } else {
                $this->logMessage("Unexpected response format or no data received.");
            }

            $this->logMessage(json_encode(['url' => $getUrl, 'response' => $pageno, 'perPageItems' => count($valueSets)], JSON_PRETTY_PRINT));
            $getUrl = isset($itemResponse->{'odata.nextLink'}) ? 'https://192.168.1.150:50000/b1s/v1/' . $itemResponse->{'odata.nextLink'} : false;
            $pageno++;
        } while ($getUrl);

        if (count($valueSets) > 0) {

            $this->truncateTable($table);

            $query = $this->insertQuery($table, $columns, $valueSets);

            $this->logMessage($query);

            executequery($this->mysqli, $query);

            $isRowExist = $this->numberOfTempTableRows($table)['tempcount'];

            if ($isRowExist > 0) {
                $this->validateTable('salesman');

                $this->executeMainTable('sp_int_imp_salesman');

                return 'executeMainTable';

                $message = $this->errorStatus('salesman')[0][0];
            }
        }
    }

    private function saveSalesman($salesman)
    {
        $status = $salesman->Active == 'tYES' ? 1 : 0; // Check active status

        $paramArray = [
            $salesman->SalesEmployeeCode, // 1: SALESMANCODE
            $salesman->SalesEmployeeName, // 2: SALESNAME
            $salesman->SalesEmployeeName, // 3: ARABICSALESNAME
            '', // 4: DIVISION_CODE (empty if not available)
            $status, // 5: STATUS (1 for active)
            'SHF01', // 6: COMPANYCODE (empty if not available)
            $PageNo, // 7: PAGENO (empty if not available)
        ];

        // Format array values into a SQL-compatible string, appending NOW() for the creation date
        $valueSets = "('" . implode("', '", $paramArray) . "', NOW())";
        return $valueSets;
    }

    public function importCustomer()
    {
        if (empty($this->sessionId)) {
            throw new Exception("User not logged in.");
        }

        ini_set('max_execution_time', 400); // 6 minutes
        ini_set('memory_limit', '512M');

        $select = 'CardCode,CardName,CardForeignName,CardType,GroupCode,MailAddress,Phone1,Phone2,Cellular,CreditLimit,SalesPersonCode,PayTermsGrpCode,U_Division,U_AreaName,U_Area,U_ArCode,U_SupViAr,U_ManagId,U_ManagNam,U_SprViId,U_SprViNam,ContactPerson,BPAddresses,ContactEmployees,CreditLimit,City,County,Valid,U_ARType,U_NoOfBills,U_InvPayTerm,U_SubGroup,U_AllowARColl,U_PayDays';

        $getUrl = 'https://192.168.1.150:50000/b1s/v1/BusinessPartners?$select=' . $select;

        // $getUrl = 'https://192.168.1.150:50000/b1s/v1/BusinessPartners';

        $pageno = 1;
        $valueSets = [];
        $table = "int_imp_customer";
        $columns = [
            "CUSTOMERCODE", // 1: Customer Code
            "TYPE", // 2: Type
            "HEADOFFICECODE", // 3: Head Office Code
            "ROUTECODE", // 4: Route Code
            "CUSTOMERNAME", // 5: Customer Name
            "ARABICCUSTOMERNAME", // 6: Arabic Customer Name
            "CUSTOMERADDRESS1", // 7: Customer Address 1
            "ARABICCUSTOMERADDRESS1", // 8: Arabic Customer Address 1
            "CUSTOMERADDRESS2", // 9: Customer Address 2
            "ARABICCONTACTNAME", // 10: Arabic Contact Name
            "CUSTOMERCITY", // 11: Customer City
            "CUSTOMERPHONENUMBER", // 12: Customer Phone Number
            "CUSTOMERCONTACTNAME", // 13: Customer Contact Name
            "INVOICEPAYMENTTERMS", // 14: Invoice Payment Terms
            "ACTIVECUSTOMER", // 15: Active Customer
            "CREDITLIMITDAYS", // 16: Credit Limit Days
            "CREDITLIMIT", // 17: Credit Limit
            "CUSTOMERCHANNELID", // 18: Customer Channel ID
            "CUSTOMERCATEGORYID", // 19: Customer Category ID
            "CUSTOMERLATITUDE", // 20: Customer Latitude
            "CUSTOMERLONGITUDE", // 21: Customer Longitude
            "ALLOWEDRADIUS", // 22: Allowed Radius
            "ALLOWARCOLLECTION", // 23: Allow AR Collection
            "ARTYPE", // 24: AR Type
            "NOOFOPENBILLS", // 25: No of Open Bills
            "COMPANYCODE", // 26: Company Code
            "PAGENO", // 27: Page No
            "LOG1", // 28: Log 1

            "CDATE", // always last: Creation Date

        ];

        do {
            $itemResponse = $this->callApi("GET", $getUrl, null, $this->sessionId);

            if (isset($itemResponse->value) && is_array($itemResponse->value)) {
                foreach ($itemResponse->value as $item) {
                    $item->PageNo = $pageno;
                    $valueSets[] = $this->saveCustomer($item);
                    // return $valueSets;
                }
            } else {
                $this->logMessage(json_encode(['error' => 'Unexpected response format or no data received', 'response' => $itemResponse], JSON_PRETTY_PRINT), 'error.log');
            }

            $this->logMessage(json_encode(['url' => $getUrl, 'pageno' => $pageno], JSON_PRETTY_PRINT), 'customer_import.log');

            $getUrl = isset($itemResponse->{'odata.nextLink'}) ? 'https://192.168.1.150:50000/b1s/v1/' . $itemResponse->{'odata.nextLink'} : false;
            $pageno++;
        } while ($getUrl);

        if (count($valueSets) > 0) {

            $this->truncateTable($table);

            $query = $this->insertQuery($table, $columns, $valueSets);
            $this->logMessage($query);
            return $query;

            // $param_array = array();
            // $param_array[1] = $sql;
            // $param_array[2] = $comments;
            // $result = $this->SFA_Comman->executequery('CALL int_sp_execute_query()', $param_array);

            // executequery($this->mysqli, $query);


            executequery($this->mysqli, $query);

            $isRowExist = $this->numberOfTempTableRows($table)['tempcount'];

            if ($isRowExist > 0) {
                $this->validateTable('customer');

                $this->executeMainTable('sp_int_imp_customer');

                return 'executeMainTable';

                $message = $this->errorStatus('salesman')[0][0];
            }
        }
    }

    private function saveCustomer($customer)
    {
        // Determine status, AR type, and allow collection based on the customer fields
        $status = $customer->Valid == 'tYES' ? 1 : 0;
        $arType = $customer->U_ARType == 'B' ? 1 : 0;
        $allowCollection = $customer->U_AllowARColl == 'Y' ? 1 : 0;

        // Map payment terms
        $payTermMapping = [
            'CA' => 0,
            'CC' => 1,
            'GC' => 2,
            'TC' => 3,
        ];
        $InvPayTerm = $payTermMapping[$customer->U_InvPayTerm] ?? '';

        // Prepare the parameter array with values
        $paramArray = [
            $customer->CardCode ?? '', // 1: CUSTOMERCODE
            $customer->CardType ?? '', // 2: TYPE
            1, // 3: HEADOFFICECODE
            $customer->U_ArCode ?? '', // 4: ROUTECODE
            $customer->CardName ?? '', // 5: CUSTOMERNAME
            $customer->CardName ?? '', // 6: ARABICCUSTOMERNAME
            $customer->BilltoDefault ?? '', // 7: CUSTOMERADDRESS1
            $customer->BilltoDefault ?? '', // 8: ARABICCUSTOMERADDRESS1
            $customer->BilltoDefault ?? '', // 9: CUSTOMERADDRESS2
            $customer->ContactPerson ?? '', // 10: ARABICCONTACTNAME
            $customer->City ?? '', // 11: CUSTOMERCITY
            $customer->Phone1 ?? '', // 12: CUSTOMERPHONENUMBER
            $customer->ContactPerson ?? '', // 13: CUSTOMERCONTACTNAME
            $InvPayTerm, // 14: INVOICEPAYMENTTERMS
            $status, // 15: ACTIVECUSTOMER
            $customer->U_PayDays ?? '', // 16: CREDITLIMITDAYS
            $customer->CreditLimit ?? '', // 17: CREDITLIMIT
            $customer->U_SubGroup ?? '', // 18: CUSTOMERCHANNELID
            $customer->GroupCode ?? 1, // 19: CUSTOMERCATEGORYID
            '', // 20: CUSTOMERLATITUDE
            '', // 21: CUSTOMERLONGITUDE
            '', // 22: ALLOWEDRADIUS
            $allowCollection, // 23: ALLOWARCOLLECTION
            $arType, // 24: ARTYPE
            $customer->U_NoOfBills ?? '', // 25: NOOFOPENBILLS
            'SHF01', // 26: COMPANYCODE
            $customer->PageNo ?? '', // 27: PAGENO
            '', // 28: LOG1
        ];

        // Format array values into a SQL-compatible string, appending NOW() for the creation date
        $valueSets = "('" . implode("', '", $paramArray) . "', NOW())";
        return $valueSets;
    }

    public function importRouteMaster()
    {
        if (empty($this->sessionId)) {
            throw new Exception("User not logged in.");
        }

        $selectd = 'Code,U_Type,U_AreaCode,U_Name,U_SupArea,U_Manager,U_ManagID,U_SprVisr,U_SprVisID,U_SlpName,U_SlpCode,U_Active';

        $getUrl = 'https://192.168.1.150:50000/b1s/v1/OAMAST?$select=' . $selectd;

        $pageno = 1;
        $valueSets = [];
        $table = "int_imp_route";
        $columns = [
            "ROUTECODE",          // 1: Route Code
            "ROUTENAME",          // 2: Route Name
            "ARABICROUTENAME",    // 3: Arabic Route Name
            "SALESPERSONID",      // 4: Salesperson ID
            "SUBAREACODE",        // 5: Subarea Code
            "ACTIVESTATUS",       // 6: Active Status
            "RELATED_CUSTOMER",   // 7: Related Customer
            "COMPANYCODE",        // 8: Company Code
            "PAGENO",             // 9: Page Number
            "LOG1",               // 10: Log Information

            "CDATE",              // (always last)


        ];
        do {
            $itemResponse = $this->callApi("GET", $getUrl, null, $this->sessionId);

            if (isset($itemResponse->value) && is_array($itemResponse->value)) {
                foreach ($itemResponse->value as $item) {
                    $item->PageNo = $pageno;
                    $valueSets[] = $this->saveRouteMaster($item);

                    // $this->logMessage(json_encode($item, JSON_PRETTY_PRINT));
                }
            } else {
                // $this->logMessage("Unexpected response format or no data received.");
                $this->logMessage(json_encode(['error' => 'Unexpected response format or no data received', 'response' => $itemResponse], JSON_PRETTY_PRINT));
            }

            // $this->logMessage(json_encode(['url' =>$getUrl, 'response'=> $itemResponse->value], JSON_PRETTY_PRINT));

            $getUrl = isset($itemResponse->{'odata.nextLink'}) ? 'https://192.168.1.150:50000/b1s/v1/' . $itemResponse->{'odata.nextLink'} : false;
            $pageno++;
        } while ($getUrl); // Continue while there's a nextLink
    }

    private function saveRouteMaster($route)
    {
        // Prepare the parameter array with values
        $paramArray = [
            $route->Code ?? '',              // 1: ROUTECODE
            $route->U_Name ?? '',            // 2: ROUTENAME
            $route->U_Name ?? '',            // 3: ARABICROUTENAME
            $route->U_SprVisID ?? '',        // 4: SALESPERSONID
            $route->U_SlpCode ?? '',         // 5: SUBAREACODE
            $route->U_Active == 'Y' ? 1 : 0, // 6: ACTIVESTATUS (1 for active, 0 for inactive)
            $route->RelatedCustomer ?? '',   // 7: RELATED_CUSTOMER
            $route->CompanyCode ?? '',       // 8: COMPANYCODE
            $route->PageNo ?? '',            // 9: PAGENO (assuming blank for demo)
            '',                              // 10: LOG1 (empty, can be set for logging purposes if needed)
        ];

        // Format the array values into a SQL-compatible string, appending NOW() for the creation date if needed
        $valueSets = "('" . implode("', '", $paramArray) . "', NOW())";

        return $valueSets;
    }

    private function insertQuery($table, $columns, $valueSets)
    {
        $columnString = implode(", ", $columns);
        return $query = "INSERT INTO $table ($columnString) VALUES " . implode(", ", $valueSets) . ";";
    }

    private function truncateTable($table)
    {
        $paramArray = [
            $table,
        ];

        $params = $this->formatParams($paramArray);
        $call_sp = "CALL sp_int_imp_delete_tempdata($params)";
        executequery($this->mysqli, $call_sp);
    }

    private function numberOfTempTableRows($table)
    {
        $paramArray = [
            $table,
        ];

        $params = $this->formatParams($paramArray);
        $call_sp = "CALL sp_get_temp_data_count($params)";
        return executequery($this->mysqli, $call_sp)[0][0];
    }

    private function validateTable($table)
    {
        $paramArray = [
            $table,
        ];

        $params = $this->formatParams($paramArray);
        $call_sp = "CALL sp_validate_data($params)";
        return executequery($this->mysqli, $call_sp);
    }

    private function executeMainTable($sp)
    {
        $call_sp = "CALL $sp()";
        executequery($this->mysqli, $call_sp);
    }

    private function errorStatus($table)
    {
        $paramArray = [
            $table,
        ];

        $params = $this->formatParams($paramArray);
        $call_sp = "CALL sp_get_main_table_error_status($params)";
        return executequery($this->mysqli, $call_sp);
    }

    private function logStatus($table)
    {
        $paramArray = [
            $table,
        ];

        $params = $this->formatParams($paramArray);
        $call_sp = "CALL sp_get_log_status($params)";
        return executequery($this->mysqli, $call_sp);
    }

    public function importChannel()
    {
        if (empty($this->sessionId)) {
            throw new Exception("User not logged in.");
        }

        $getUrl = 'https://192.168.1.150:50000/b1s/v1/Channels'; // Assuming Channels API endpoint
        $channelResponse = $this->callApi("GET", $getUrl, null, $this->sessionId);

        if (isset($channelResponse->value)) {
            foreach ($channelResponse->value as $channel) {
                $this->saveChannel($channel);
            }
        }
    }

    public function importCategory()
    {
        if (empty($this->sessionId)) {
            throw new Exception("User not logged in.");
        }

        $getUrl = 'https://192.168.1.150:50000/b1s/v1/BusinessPartnerGroups';
        $categoryResponse = $this->callApi("GET", $getUrl, null, $this->sessionId);

        if (isset($categoryResponse->value)) {
            foreach ($categoryResponse->value as $category) {
                $this->saveCategory($category);
            }
        }
    }

    public function importDepoTransfer()
    {
        if (empty($this->sessionId)) {
            throw new Exception("User not logged in.");
        }

        ini_set('max_execution_time', 400); // 6 minutes
        ini_set('memory_limit', '512M');

        $selectd = 'DocEntry,DocNum,FromWarehouse,ToWarehouse,Comments,DocDate,StockTransferLines';
        $getUrl = 'https://192.168.1.150:50000/b1s/v1/StockTransfers?$select=' . $selectd;

        $pageno = 1;
        do {
            $itemResponse = $this->callApi("GET", $getUrl, null, $this->sessionId);

            if (isset($itemResponse->value) && is_array($itemResponse->value)) {
                foreach ($itemResponse->value as $key => $item) {
                    $item->PageNo = $pageno;
                    // $this->logMessage(json_encode(['parent' => $key], JSON_PRETTY_PRINT));
                    $this->saveDepoTransfer($item);
                }
            } else {
                $this->logMessage("Unexpected response format or no data received.");
            }

            // $this->logMessage(json_encode(['url' => $getUrl, 'pageno' => $pageno], JSON_PRETTY_PRINT));

            $getUrl = isset($itemResponse->{'odata.nextLink'}) ? 'https://192.168.1.150:50000/b1s/v1/' . $itemResponse->{'odata.nextLink'} : false;
            $pageno++;
        } while ($getUrl);
    }

    private function saveDepoTransfer($transfer)
    {
        if ($transfer->StockTransferLines && is_array($transfer->StockTransferLines)) {

            $DocEntry = $transfer->DocEntry;
            $FromWarehouse = $transfer->FromWarehouse;
            $ToWarehouse = $transfer->ToWarehouse;
            $FromLocation = $transfer->FromWarehouse;
            $ToLocation = $transfer->ToWarehouse;
            $ItemCode = $transfer->ItemCode;
            $DocDate = $transfer->DocDate;
            $Comments = $transfer->Comments;
            $DocNum = $transfer->DocNum;
            $PageNo = $transfer->PageNo;
            $Time = date('H:i');

            foreach ($transfer->StockTransferLines as $key => $StockTransferLines) {
                $paramArray = [
                    $DocEntry, // 1: var_loadsheet_number
                    $FromWarehouse, // 2: var_from_depot
                    $ToWarehouse, // 3: var_to_depot
                    $FromLocation, // 4: var_from_location
                    $ToLocation, // 5: var_to_location
                    $StockTransferLines->ItemCode, // 6: var_item_code
                    $StockTransferLines->Quantity, // 7: var_quantity
                    $StockTransferLines->UoMCode, // 8: var_uom
                    $DocDate, // 9: var_load_transaction_date
                    $Time, // 10: var_load_transaction_time
                    $StockTransferLines->$LOADREQUESTREFERENCE, // 11: var_load_request_reference
                    '', // 12: var_stock_location
                    $Comments, // 13: var_reason
                    $DocNum, // 14: var_refer
                    $PageNo, // 15: var_page
                ];

                $params = $this->formatParams($paramArray);
                $call_sp = "CALL int_imp_sap_get_depo_transfer($params)";
                executequery($this->mysqli, $call_sp);
                // $this->logMessage(json_encode(['child' => $key], JSON_PRETTY_PRINT));
            }
        }
    }

    private function saveCategory($category)
    {
        $paramArray = [
            $category->Code ?? '', // CUSTOMERCATEGORYID - Dummy ID if null
            $category->Name ?? '', // DESCRIPTION - Dummy Description if null
            $category->Name ?? '', // ARABICDESCRIPTION - Dummy Arabic Description if null
            $category->Type ?? '', // TYPE - Dummy Type if null
            1, // ACTIVESTATUS - Assuming active status
            '', // COMPANYCODE - Dummy Company Code if null
            '', // PAGENO - Dummy Page Number
            '', // LOG1 - Dummy Log Info
            '', // CDATE - Dummy Creation Date
        ];

        $params = $this->formatParams($paramArray);
        $call_sp = "CALL int_imp_sap_get_category($params)";
        executequery($this->mysqli, $call_sp);
    }

    private function saveChannel($channel)
    {
        $paramArray = [
            $channel->CustomerChannelID, // CUSTOMERCHANNELID
            $channel->Description, // DESCRIPTION
            $channel->ArabicDescription, // ARABICDESCRIPTION
            isset($channel->ActiveStatus) ? 1 : 0, // ACTIVESTATUS (1 for active, 0 for inactive)
            $channel->CompanyCode, // COMPANYCODE
            '', // PAGENO (assuming blank for demo)
            '', // CDATE (current timestamp handled in SP)
            '', // LOG1
        ];

        $params = "'" . implode("','", $paramArray) . "'";
        $call_sp = "CALL int_imp_sap_get_channel($params)";
        executequery($this->mysqli, $call_sp);
    }

    private function callApi($method, $url, $data = [], $token = "")
    {
        $curl = curl_init();

        // Set the common cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ));

        // Set the HTTP method
        switch (strtoupper($method)) {
            case 'GET':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                if (!empty($data)) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                    curl_setopt($curl, CURLOPT_URL, $url);
                }
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'PATCH':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (!empty($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            default:
                return "Invalid HTTP Method";
        }

        // Set the headers
        $headers = ['Content-Type: application/json'];
        if ($token) {
            $headers[] = 'Cookie: B1SESSION=' . $token . '; ROUTEID=.node5';
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Handle cURL errors
        if ($response === false) {
            $error = curl_error($curl);
            $error_no = curl_errno($curl);
            curl_close($curl);
            return "cURL Error: " . $error . " (Error Code: " . $error_no . ") Url is: " . $url . "  Method Is: " . $method;
        }

        curl_close($curl);
        return json_decode($response);
    }

    private function formatParams(array $paramArray): string
    {
        return "'" . implode("','", $paramArray) . "'";
    }
}
