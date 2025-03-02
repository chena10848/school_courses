<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * 定義 API 路由的前綴
     */
    public function boot()
    {
        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php')); // 這裡註冊 api.php 路由文件

            Route::middleware('web')
                ->group(base_path('routes/web.php')); // 這裡註冊 web.php 路由文件
        });
    }
}
