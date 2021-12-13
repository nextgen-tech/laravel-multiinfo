<?php

declare(strict_types=1);

namespace NGT\Laravel\MultiInfo;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use NGT\MultiInfo\Certificate;
use NGT\MultiInfo\Contracts\Connection as ConnectionContract;
use NGT\MultiInfo\Contracts\Credentials as CredentialsContract;
use NGT\MultiInfo\Credentials;
use NGT\MultiInfo\Url;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->mergeConfig();
        $this->registerBindings();
    }

    /**
     * Merge user-defined config with default values.
     *
     * @return void
     */
    private function mergeConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/multiinfo.php', 'multiinfo');
    }

    /**
     * Register class bindings to container.
     *
     * @return void
     */
    private function registerBindings(): void
    {
        $this->app->singleton(Url::class, function ($app) {
            /** @var \Illuminate\Contracts\Config\Repository */
            $config = $app->make('config');

            return new Url($config->get('multiinfo.api_version'));
        });

        $this->app->singleton(CredentialsContract::class, function ($app) {
            /** @var \Illuminate\Contracts\Config\Repository */
            $config = $app->make('config');

            return new Credentials(
                $config->get('multiinfo.credentials.login'),
                $config->get('multiinfo.credentials.password'),
                $config->get('multiinfo.credentials.service_id'),
            );
        });

        $this->app->singleton(Certificate::class, function ($app) {
            /** @var \Illuminate\Contracts\Config\Repository */
            $config = $app->make('config');

            return new Certificate(
                $config->get('multiinfo.certificate.public_key_path'),
                $config->get('multiinfo.certificate.private_key_path'),
                $config->get('multiinfo.certificate.password'),
                $config->get('multiinfo.certificate.type'),
            );
        });

        $this->app->singleton(ConnectionContract::class, function ($app) {
            /** @var \NGT\Laravel\MultiInfo\ConnectionManager */
            $manager = $app->make(ConnectionManager::class);

            return $manager->driver();
        });
    }

    /**
     * @inheritDoc
     */
    public function boot(ChannelManager $manager): void
    {
        $this->publishes([
            __DIR__ . '/../config/multiinfo.php' => $this->app->configPath('multiinfo.php'),
        ]);

        $manager->extend('multiinfo', function (Container $container) {
            return $container->make(MultiInfoChannel::class);
        });
    }

    /**
     * @inheritDoc
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [
            ChannelManager::class, // required for extending

            Certificate::class,
            CredentialsContract::class,
            ConnectionContract::class,
            Url::class,
        ];
    }
}
