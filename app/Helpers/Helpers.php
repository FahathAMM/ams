<?php

use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

if (!function_exists('getBrowser')) {

    function getBrowser()
    {
        $userAgent =  request()->header('User-Agent');
        $pattern = "/(MSIE|Trident|Firefox|Chrome|Safari|Opera)/i";
        $log_browser = "";

        if (preg_match($pattern, $userAgent, $matches)) {
            $log_browser =  $matches[0];
        }

        return $log_browser;
    }
}

if (!function_exists('pdfToBase64')) {
    function pdfToBase64($pdfPath)
    {
        return  $b64Doc = chunk_split(base64_encode(file_get_contents($pdfPath)));
    }
}

if (!function_exists('logActivity')) {

    function logActivity($log_form_name = "", $log_form_record_code = "", $log_action = "",  $log_form_record_detail = "",  $log_user = "")
    {
        $log_user = auth()->user();
        $log_cdate = now();

        $userAgent =  request()->header('User-Agent');
        $pattern = "/(MSIE|Trident|Firefox|Chrome|Safari|Opera)/i";

        if (preg_match($pattern, $userAgent, $matches)) {
            $log_browser =  $matches[0];
        }

        $msg = " | ";
        $msg .= 'userID: ' . $log_user->id . " | ";
        $msg .= 'userName: ' . $log_user->full_name . " | ";
        $msg .= 'formName: ' . $log_form_name . " | ";
        $msg .= 'formRecordID: ' . $log_form_record_code . " | ";
        $msg .= 'Action: ' . $log_action . " | ";
        $msg .= 'formRecordDesc: ' . $log_form_record_detail . " | ";
        $msg .= 'Date: ' . $log_cdate . " | ";


        if ($log_user) {
            DB::table('user_logs')->insert([
                'user_id'        => $log_user->id,
                'user_name'      => $log_user->full_name,
                'form_name'      => $log_form_name,
                'form_record_id'      => $log_form_record_code,
                'log_action'     => $log_action,
                'browser'        => $log_browser,
                'create_date'    => now(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        Log::channel('userActivity')->info($msg);
    }
}

if (!function_exists('can')) {
    function can($per = '')
    {
        if (auth()->user()->hasRole('Super-Admin')) {
            return true;
        }

        $LoggedUserAccesspermissions = collect(auth()->user()->getPermissionsViaRoles()->toArray())
            ->pluck('name')->unique()->values()->toArray();

        return  in_array($per, $LoggedUserAccesspermissions);
    }
}

if (!function_exists('currentUserID')) {
    function currentUserID()
    {
        return auth()->user()->id;
    }
}

// if (!function_exists('currentUser')) {
//     function currentUser()
//     {
//         $user = auth()->user();
//         // return  auth()->load('roles', 'employee');
//     }
// }

if (!function_exists('currentUser')) {
    function currentUser()
    {

        log::info('currentuser');
        $user = auth()->user();

        // Check if user is authenticated
        if ($user) {
            // Load the roles and employee relationships for the authenticated user
            return $user->load('roles', 'employee');
        }

        // If no user is authenticated, return null or handle accordingly
        return null;
    }
}

if (!function_exists('fetchCurrentEmployeeWithReportingManagers')) {
    function fetchCurrentEmployeeWithReportingManagers()
    {
        $empId = currentUser()->employee_id;

        if ($empId) {
            return $emp = Employee::with(['reportManager:id,first_name,last_name,img'])->find($empId);
        }

        return abort(450);
    }
}


if (!function_exists('actionBtns')) {
    function actionBtns($id = "",  $editRouteName = '', $url = '', $deleteDisplayValue = "", $permission = [])
    {
        // <div class="hstack gap-3 fs-15">
        //  <a href="javascript:void(0);" class="link-primary"><i class="ri-settings-4-line"></i></a>
        //  <a href="javascript:void(0);" class="link-danger"><i class="ri-delete-bin-5-line"></i></a>
        // </div>

        $btn = "";
        $btn .= "<div class='hstack gap-3 fs-15 d-flex justify-content-center'>";
        if ($permission['isEdit']) {
            //edit btn
            $btn .= '<a href="' . route($editRouteName, $id) . '"class="link-primary"  title="Edit"><i class="ri-pencil-line"></i></a>';
        }

        if ($permission['isDelete']) {
            //delete btn
            $btn .= '<a href="#" delete-url="' . url($url) . '" delete-item="' . $deleteDisplayValue . '" class="delete link-danger" id= "' . $id . '"  title="Delete"><i class="ri-delete-bin-5-line"></i></a>';
        }

        if ($permission['isView']) {
            //view btn
            $btn .= '<a href="' . url($url . '/' . $id) . '"class="link-info" title="View"><i class="ri-eye-line"></i></a>';
        }

        if ($permission['isPrint']) {
            //print btn
        }

        if ($permission['isTracking'] ?? false) {
            $btn .= '<a href="#" tracking-url="' . url($url) . '" tracking-item="' . $deleteDisplayValue . '" class="tracking link-danger" id= "' . $id . '"  title="Tracking"><i class="ri-download-cloud-2-line"></i></a>';
        }

        if ($permission['isExtra'] ?? false) {
            //extra btn
            $btn .= '<a href="' . url($permission['isExtra']['url'] . '/' . $id) . '"class="btn btn-outline-primary btn-sm" title="' . $permission['isExtra']['title'] . '"><i class="' . $permission['isExtra']['icon'] . '"></i></a>';
        }

        $btn .= "</div>";
        return $btn;
    }
}

if (!function_exists('addBtn')) {
    function addBtn($title, $isAdd = false, $routeName = "")
    {
        if ($isAdd) {
            // Add button
            $className = 'btn btn-primary buttons-excel buttons-html5 bg-primary text-white border-primary me-1 ms-1';
            return '<a class="' . $className . '" href="' . route($routeName) . '" title="Add ' . $title . '">
            <i class="fas fa-plus-circle fa-lg" style="font-size: 12px;"></i> </a>';
        }
        return "";
    }
}

if (!function_exists('convertToSqlDateFormat')) {
    function convertToSqlDateFormat($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}

if (!function_exists('displayDateFormat')) {
    function displayDateFormat($date)
    {
        return  $date ? date('d-m-Y', strtotime($date)) : "";
    }
}

if (!function_exists('currentDate')) {
    function currentDate()
    {
        return date('d-m-Y');
    }
}

if (!function_exists('getTimeFromDate')) {
    function getTimeFromDate($date)
    {
        return  $date ? date('H:i', strtotime($date)) : "";
    }
}

if (!function_exists('dl')) {
    function dl($arr)
    {
        echo "<pre>" . json_encode($arr, JSON_PRETTY_PRINT) . "</pre>";
        // die;
    }
}

if (!function_exists('ApplicationVersion')) {
    function ApplicationVersion()
    {
        return session('appVersion');
    }
}

if (!function_exists('customEncrypt')) {
    function customEncrypt($pass)
    {
        $str = $pass; // $pass['password'];
        $key = '4QcTlzuaNUcX289Z9D0ovPCzb';
        $iv = "1234567812345678";
        $encryption_key = base64_encode($key);
        $encrypted = openssl_encrypt($str, 'aes-256-cbc', $encryption_key, true, $iv);
        $encrypted_data = base64_encode($encrypted);
        return ($encrypted_data);
    }
}

if (!function_exists('downloadAndAddFileFromCdn')) {
    function downloadAndAddFileFromCdn()
    {
        return;

        $files = [
            'https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js',
            'https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js',
            'https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js',
            'https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js',
            'https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js',
            'https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js',
            'https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js',
            'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js',
            'https://cdn.datatables.net/searchbuilder/1.4.0/js/dataTables.searchBuilder.min.js',
            'https://cdn.datatables.net/datetime/1.5.3/js/dataTables.dateTime.min.js',
        ];

        $savePath = 'D:/Install/laragon/www/oms/public/assets/report/js/';

        foreach ($files as $file) {
            return  $filename = basename($file);
            file_put_contents($savePath . $filename, fopen($file, 'r'));
            echo "Downloaded<br>: $filename\n";
        }

        echo "All files have been downloaded.";
    }
}
