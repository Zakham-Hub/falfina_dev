<?php

namespace App\Providers;

use App\Helpers\AliasHelper;
use Illuminate\Support\ServiceProvider;
use App\Models\{Setting};
use Illuminate\Support\Facades\{View, Cache};
use App\Models\Concerns\UploadMedia;
use App\Services\Contracts\UserInterface;
use App\Repositories\UserRepository;
use Carbon\Carbon;
class AppServiceProvider extends ServiceProvider
{
    use UploadMedia;
    public function register(): void {}

    public function boot(): void
    {
          Carbon::serializeUsing(function ($carbon) {
        return $carbon->setTimezone(config('app.timezone'))->toDateTimeString();
    });
        $settings = Cache::remember('settings', now()->addMinutes(5), function () {
            return Setting::with(['media'])->first() ?? new Setting();
        });
        $logo = $settings->getMediaUrl('logo') ?? null;
        $favicon = $settings->getMediaUrl('favicon') ?? null;
        $alarm_audio = $settings->getMediaUrl('alarm_audio') ?? null;
        View::share([
            'settings' => $settings,
            'logo' => $logo,
            'favicon' => $favicon,
            'alarm_audio' => $alarm_audio,
        ]);
    }
}
