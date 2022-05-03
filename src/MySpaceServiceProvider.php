<?php

namespace Eutranet\MySpace;

use Eutranet\Init\PackageServiceProvider;
use Eutranet\Init\Package;
use Illuminate\Routing\Router;
use Eutranet\MySpace\Console\Commands\EutranetInstallMySpaceCommand;
use Eutranet\MySpace\Http\Middleware\HasAcceptedMySpaceGeneralTermsOn;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Eutranet\MySpace\View\Composers\MySpaceComposer;
use Eutranet\MySpace\View\Composers\UserAccountComposer;
use Eutranet\MySpace\Providers\MySpaceMenuServiceProvider;
use Eutranet\MySpace\Http\Middleware\MySpaceMigratedMiddleware;
use Eutranet\MySpace\Http\Middleware\MySpaceInstalledMiddleware;

class MySpaceServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-my-space')
            ->hasConfigFile(['eutranet-my-space']) // php artisan vendor:publish --tag=your-laravel-init-name-config
            ->hasViews('my-space') // ->hasViews('custom-view-namespace::myView.subview');
            ->hasMigration('add_has_accepted_general_terms_on_to_users_table')
            ->hasMigration('add_has_accepted_my_space_general_terms_on_to_users_table')
            ->hasMigration('create_dashboard_menus_table')
            ->hasMigration('create_my_space_general_terms_table')
            ->hasMigration('add_is_locked_to_users_table')
            ->hasMigration('add_is_valid_to_users_table')
            ->hasMigration('add_deletion_specific_fields_to_users_table')
            //->hasMigration('create_user_agreements_table')
            ->hasMigration('create_user_infos_table')
            ->hasMigration('create_user_social_medias_table')
            ->hasMigration('create_user_payments_table')
            ->hasMigration('create_contractables_table')
            ->hasTranslations()
            ->hasViewComposer('my-space::*', MySpaceComposer::class)
            ->hasViewComposer('my-space::account.show', UserAccountComposer::class)
            ->hasAssets()
            ->hasRoutes('config', 'web', 'back', 'setup')
            ->hasCommand(EutranetInstallMySpaceCommand::class);
        // ->hasMigration('create_package_tables');
    }

    public function boot()
    {
        parent::boot();

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('my-space-migrated', MySpaceMigratedMiddleware::class);
        $router->aliasMiddleware('my-space-installed', MySpaceInstalledMiddleware::class);
        $router->aliasMiddleware('has-accepted-my-space-general-terms-on', HasAcceptedMySpaceGeneralTermsOn::class);
        $router->pushMiddlewareToGroup('web', 'my-space-migrated');
        $router->pushMiddlewareToGroup('web', 'my-space-installed');
    }

    public function register()
    {
        parent::register();
        $this->app->register(MySpaceMenuServiceProvider::class);
        // ... other things
        //		$this->registerRoutes();
        $this->loadMigrationsFrom(app_path('Eutranet/MySpace/database/migrations'));
    }

    protected function registerRoutes()
    {
        //		Route::group($this->routeConfiguration(), function () {
//			$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
//			$this->loadRoutesFrom(__DIR__ . '/../routes/back.php');
//			$this->loadRoutesFrom(__DIR__ . '/../routes/test.php');
//		});
    }

    protected function routeConfiguration(): array
    {
        return [
            // 'middleware' => config('eutranet-setup.middlewares'),
        ];
    }
}
