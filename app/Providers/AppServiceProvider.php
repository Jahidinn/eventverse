<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

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
	public function boot(Request $request): void
	{
		Paginator::useBootstrap();
		// URL::forceScheme('https');
		if ($request->header('X-Forwarded-Proto') === 'https') {
			URL::forceScheme('https');
		}
	}
}
