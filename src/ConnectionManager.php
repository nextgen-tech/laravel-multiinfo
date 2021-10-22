<?php

declare(strict_types=1);

namespace NGT\Laravel\MultiInfo;

use Illuminate\Support\Manager;
use NGT\Ewus\Contracts\Connection;
use NGT\MultiInfo\Connections\HttpConnection;

class ConnectionManager extends Manager
{
    /**
     * Create an instance of HTTP connection driver.
     *
     * @return \NGT\MultiInfo\Connections\HttpConnection
     */
    public function createHttpDriver(): HttpConnection
    {
        return $this->container->make(HttpConnection::class);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('multiinfo.connection', 'http');
    }
}
