<?php

namespace App\Http\Controllers\Pages\Administration;

use Illuminate\Http\Request;
use App\Models\Setting\Setting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Warehouse\WarehouseStock;

class SettingController extends Controller
{
    protected $modelName = 'Setting';
    protected $routeName = 'setting.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct()
    {
        $this->isDestroyingAllowed = true;
        $this->middleware('userpermission:administration-setting-view')->only('index');
    }

    public function index(Request $request)
    {
        $settings = Setting::whereIsVisible(1)->get();

        // $cronSchedules = DB::table('monitored_scheduled_tasks')
        //     ->where('name', '!=', 'DatabaseBackup')
        //     ->get($this->scheduleCols());

        return view('pages/administration/setting/index', [
            'settings' => $settings,
            'title' => $this->modelName,
            'cronSchedules' => $cronSchedules ?? [],
        ]);
    }

    public function store(Request $request)
    {
        try {

            $settings = Setting::all();

            foreach ($settings as $setting) {

                if ($request->has($setting->key)) {

                    if ($setting->value != $request->input($setting->key)) {
                        logActivity('Setting Update', "Setting Key is " . ucwords(str_replace('_', ' ', $setting->key)), 'Update');
                    }

                    $setting->value = $request->input($setting->key);
                }

                $setting->is_active = $request->has($setting->key . '_is_active') ? 1 : 0;
                $setting->save();
            }

            // exec("php artisan schedule-monitor:sync");

            return redirect()->back()->with('success', 'Settings updated successfully.');
        } catch (\Throwable $th) {
            return  $this->response($th->getMessage(), null, false);
        }
    }



    private function scheduleCols(): array
    {
        return [
            'name',
            'last_started_at',
            'last_finished_at',
            'cron_expression'
        ];
    }
}
