<?php

namespace App\Providers;

use Exception;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;

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
        $this->loadGoogleStorageDriver();
        // Passport::enablePasswordGrant();

    }

    private function loadGoogleStorageDriver(string $driverName = 'google') 
    {
        try {
            Storage::extend(
                $driverName, 
                function ($app, $config) {
                    $options = [];
        
                    if (!empty($config['teamDriveId'] ?? null)) {
                        $options['teamDriveId'] = $config['teamDriveId'];
                    }
        
                    $client = new Client();
                    $client->setClientId($config['clientId']);
                    $client->setClientSecret($config['clientSecret']);
                    $client->refreshToken($config['refreshToken']);
        
                    $service = new Drive($client);
                    $adapter = new GoogleDriveAdapter(
                        $service, 
                        $config['folder'] ?? '/', 
                        $options
                    );
                    $driver = new Filesystem($adapter);
        
                    return new FilesystemAdapter($driver, $adapter);
                }
            );
        } catch(Exception $e) {
            Log::error($e);
        }
    }
}
