<?php

namespace Tygh\Addons\Aws;

use Tygh\Tygh;

/**
 * Class Helper
 * @package Tygh\Addons\Aws
 */
class Helper
{
    /**
     * Process a string and replace common identifiers.
     * @param string $input
     * @return string
     */
    public static function process(string $input): string
    {
        return str_replace(
            [
                '[account_id]',
                '[region]',
            ],
            [
                Tygh::$app['aws.account_id'],
                Tygh::$app['aws.region']
            ],
            $input
        );
    }
}