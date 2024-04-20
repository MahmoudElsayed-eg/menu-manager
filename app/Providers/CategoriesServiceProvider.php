<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class CategoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        // $categories = Category::notDeleted()->get();
        // $categories = Category::with([
        //     'meals.sizes.promotion', 'meals.promotion'
        // ])->notDeleted()->get();
        // $categories->with('meals.sizes.promotion', 'meals.promotion');
        // $logo = asset('storage/images/logo.png');
        // $plate_empty = asset('storage/images/plate_empty_black.svg');
        // $location = asset('storage/images/location.png');
        // $phone = asset('storage/images/phone.svg');
        // $email = asset('storage/images/email.svg');
        if (!Cookie::has('dark-light')) {
            Cookie::queue('dark-light', "not", null, null, null, false, false);
        }
        // Inertia::share('categories', $categories);
        // Inertia::share('logo', $logo);
        // Inertia::share('plate_empty', $plate_empty);
        // Inertia::share('location_icon', $location);
        // Inertia::share('phone', $phone);
        // Inertia::share('email', $email);
    }
}
