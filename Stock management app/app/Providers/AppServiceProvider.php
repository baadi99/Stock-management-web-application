<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Setting the boostrap pagination view as default instead of tailwind Css
        Paginator::useBootstrap(); 
        
        //Setting up a moneyformat blade directive
        Blade::directive('format_money', function ($number) {
            //The format_money function is defined in app/helpers/helper
            return "<?php echo format_money($number); ?>";
        });

        //Setting up an isAdmin blade directive
        Blade::if('isAdmin', function ($role) {
            return $role === 'Admin';
        });
    }
}
