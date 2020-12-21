<?php

namespace Tygh\Addons\Aws;

use Tygh\Core\ApplicationInterface;
use Tygh\Core\BootstrapInterface;

/**
 * Class Bootstrap
 * @package Tygh\Addons\Aws
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritDoc
     */
    public function boot(ApplicationInterface $app)
    {
        $app->register(new ServiceProvider());
    }
}