<?php

namespace App\Models\Administration;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLoginActivityLog extends Model
{
    use HasFactory;

    protected $table = 'user_login_activity_logs';

    protected $fillable = [
        'user_id',
        'action',
        'session_id',
        'ip_address',
        'location',
        'device',
        'os',
        'browser',
        'login_time',
        'logout_time',
        'status',
        'reason',
        'attempted_at',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createLog(array $data)
    {
        return self::create([
            'user_id' => $data['user_id'],
            'action' => $data['action'],
            'session_id' => $data['session_id'] ?? null,
            'ip_address' => $data['ip_address'] ?? self::detectIP(),
            'location' => $data['location'] ?? null,
            'device' => $data['device'] ?? self::detectDevice(),
            'os' => $data['os'] ?? self::detectOS(),
            'browser' => $data['browser'] ?? self::detectBrowser(),
            'login_time' => $data['login_time'] ?? null,
            'logout_time' => $data['logout_time'] ?? null,
            'status' => $data['status'] ?? 'success',
            'reason' => $data['reason'] ?? null,
            'attempted_at' => $data['attempted_at'] ?? now(),
            'user_agent' => $data['user_agent'] ?? request()->header('User-Agent'),
        ]);
    }

    private static function detectDevice()
    {
        $agent = request()->header('User-Agent');
        if (str_contains($agent, 'Mobile')) {
            return 'Mobile';
        } elseif (str_contains($agent, 'Tablet')) {
            return 'Tablet';
        }
        return 'Desktop';
    }

    private static function detectIP()
    {
        $ipAddress = request()->ip();
        if ($ipAddress == '::1') {
            $ipAddress = '127.0.0.1';  // You can manually switch it to IPv4
        }

        return $ipAddress;
    }

    private static function detectOS()
    {
        $agent = request()->header('User-Agent');
        if (str_contains($agent, 'Windows')) {
            return 'Windows';
        } elseif (str_contains($agent, 'Mac')) {
            return 'MacOS';
        } elseif (str_contains($agent, 'Linux')) {
            return 'Linux';
        } elseif (str_contains($agent, 'Android')) {
            return 'Android';
        } elseif (str_contains($agent, 'iPhone') || str_contains($agent, 'iPad')) {
            return 'iOS';
        }
        return 'Unknown';
    }

    private static function detectBrowser()
    {
        $agent = request()->header('User-Agent');
        if (str_contains($agent, 'Chrome')) {
            return 'Chrome';
        } elseif (str_contains($agent, 'Firefox')) {
            return 'Firefox';
        } elseif (str_contains($agent, 'Safari') && !str_contains($agent, 'Chrome')) {
            return 'Safari';
        } elseif (str_contains($agent, 'Edge')) {
            return 'Edge';
        } elseif (str_contains($agent, 'MSIE') || str_contains($agent, 'Trident')) {
            return 'Internet Explorer';
        }
        return 'Unknown';
    }
}
