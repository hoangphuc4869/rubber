<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Gate;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Gate::define('nguyenlieu', function ($user) {
            return $user->roles->pluck('name')->contains('Nguyên liệu');
        });

        Gate::define('canvat', function ($user) {
            return $user->roles->pluck('name')->contains('Cán vắt');
        });

        Gate::define('hat', function ($user) {
            return $user->roles->pluck('name')->contains('Gia công hạt');
        });

        Gate::define('nhiet', function ($user) {
            return $user->roles->pluck('name')->contains('Gia công nhiệt');
        });

        Gate::define('ep', function ($user) {
            return $user->roles->pluck('name')->contains('Ép kiện');
        });

        Gate::define('donggoi', function ($user) {
            return $user->roles->pluck('name')->contains('Đóng gói');
        });

        Gate::define('khoBHCK', function ($user) {
            return $user->roles->pluck('name')->contains('Kho BHCK');
        });

        Gate::define('khoTNSR', function ($user) {
            return $user->roles->pluck('name')->contains('Kho TNSR');
        });

        Gate::define('khoCRCK2', function ($user) {
            return $user->roles->pluck('name')->contains('Kho CRCK2');
        });

        Gate::define('contractBHCK', function ($user) {
            return $user->roles->pluck('name')->contains('Hợp đồng BHCK');
        });

        Gate::define('contractCRCK2', function ($user) {
            return $user->roles->pluck('name')->contains('Hợp đồng CRCK2');
        });

        Gate::define('contractTNSR', function ($user) {
            return $user->roles->pluck('name')->contains('Hợp đồng TNSR');
        });

        Gate::define('admin', function ($user) {
            return $user->roles->pluck('name')->contains('Admin');
        });


    }
}