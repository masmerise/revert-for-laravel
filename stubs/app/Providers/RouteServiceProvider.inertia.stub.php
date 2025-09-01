<?php declare(strict_types=1);

namespace App\Providers;

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        EncryptCookies::except(['appearance', 'sidebar_state']);

        $this->pushMiddlewareToGroup('web', HandleAppearance::class);
        $this->pushMiddlewareToGroup('web', HandleInertiaRequests::class);
        $this->pushMiddlewareToGroup('web', AddLinkHeadersForPreloadedAssets::class);

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
