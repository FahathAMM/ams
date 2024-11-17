<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {

        DB::table('settings')->truncate();


        DB::table('settings')->insert([
            // [
            //     'id' => 4,
            //     'key' => 'user_activity_view',
            //     'value' => '100',
            //     'is_active' => 1,
            //     'type' => 'text',
            //     'type_value' => null,
            //     'user_id' => null,
            //     'level' => 'app',
            //     'is_visible' => 1,
            //     'created_at' => '2024-10-09 14:36:58',
            //     'updated_at' => '2024-11-06 11:56:34',
            // ],
            // [
            //     'id' => 5,
            //     'key' => 'confirmation_mode',
            //     'value' => 'yes',
            //     'is_active' => 0,
            //     'type' => 'text',
            //     'type_value' => null,
            //     'user_id' => null,
            //     'level' => 'app',
            //     'is_visible' => 0,
            //     'created_at' => '2024-10-09 15:04:58',
            //     'updated_at' => '2024-10-16 15:53:01',
            // ],
            [
                'key' => 'user_activity_view',
                'value' => 'Yes',
                'is_active' => 1,
                'type' => 'select',
                'type_value' => 'Yes,No',
                'user_id' => null,
                'level' => 'app',
                'is_visible' => 1,
                'created_at' => '2024-10-09 15:04:58',
                'updated_at' => '2024-10-24 15:41:37',
            ],
            // [
            //     'key' => 'import_order_schedule',
            //     'value' => 'everyFiveMinutes',
            //     'is_active' => 1,
            //     'type' => 'select',
            //     'type_value' => 'everyMinute,everyFiveMinutes,everyTenMinutes,everyThirtyMinutes,hourly',
            //     'user_id' => null,
            //     'level' => 'app',
            //     'is_visible' => 1,
            //     'created_at' => '2024-10-09 15:04:58',
            //     'updated_at' => '2024-10-28 15:12:50',
            // ],
            // [
            //     'key' => 'export_order_schedule',
            //     'value' => 'everyFiveMinutes',
            //     'is_active' => 1,
            //     'type' => 'select',
            //     'type_value' => 'everyMinute,everyFiveMinutes,everyTenMinutes,everyThirtyMinutes,hourly',
            //     'user_id' => null,
            //     'level' => 'app',
            //     'is_visible' => 1,
            //     'created_at' => '2024-10-09 15:04:58',
            //     'updated_at' => '2024-10-21 15:07:57',
            // ],
            // [
            //     'key' => 'low_qty_notification_email',
            //     'value' => 'm.fahath@mirnah.com',
            //     'is_active' => 1,
            //     'type' => 'text',
            //     'type_value' => null,
            //     'user_id' => null,
            //     'level' => 'app',
            //     'is_visible' => 1,
            //     'created_at' => '2024-10-09 14:36:58',
            //     'updated_at' => '2024-10-25 11:45:19',
            // ],
            // [
            //     'key' => 'low_qty_notification_schedule',
            //     'value' => 'daily',
            //     'is_active' => 1,
            //     'type' => 'select',
            //     'type_value' => 'everyMinute,everyFiveMinutes,everyTenMinutes,everyThirtyMinutes,hourly,daily',
            //     'user_id' => null,
            //     'level' => 'app',
            //     'is_visible' => 1,
            //     'created_at' => '2024-10-09 15:04:58',
            //     'updated_at' => '2024-10-28 15:22:20',
            // ],
        ]);
    }
}
