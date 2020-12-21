<?php

namespace Tygh\Addons\Aws;

use Aws\AwsClient;
use Aws\MultiRegionClient;
use Aws\Sdk;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Tygh\Registry;

/**
 * Class ServiceProvider
 * @package Tygh\Addons\Aws
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $pimple)
    {
        /**
         * The AWS manifest file containing all versions.
         * @return array
         */
        $pimple['aws.manifest'] = static function() {
            return fn_get_schema('aws', 'manifest');
        };

        /**
         * The AWS software development kit.
         * @return Sdk
         */
        $pimple['aws.sdk'] = static function ($pimple) {
            return new Sdk([
                'region' => $pimple['aws.region'],
            ]);
        };

        /**
         * The defined AWS region for our cloud environment.
         * @return string
         */
        $pimple['aws.region'] = static function () {
            return Registry::get('addons.aws.region');
        };

        /**
         * The defined AWS account ID.
         * @return string
         */
        $pimple['aws.account_id'] = static function () {
            return Registry::get('addons.aws.account_id');
        };

        /**
         * The defined AWS access key ID.
         * @return string
         */
        $pimple['aws.access_key_id'] = static function () {
            return Registry::get('addons.aws.account_id');
        };

        /**
         * The defined AWS secret access key.
         * @return string
         */
        $pimple['aws.secret_access_key'] = static function() {
            return Registry::get('addons.aws.secret_access_key');
        };

        /**
         * Register all services defined in the manifest to our dependency injector.
         */
        foreach ($pimple['aws.manifest'] as $service => $manifest) {
            /**
             * Create an AWS service client on demand.
             * @param Container $pimple The dependency injector.
             * @return AwsClient
             */
            $pimple['aws.' . $service] = static function(Container $pimple) use ($manifest) {
                /** @var Sdk $sdk */
                $sdk = &$pimple['aws.sdk'];

                return $sdk->{'create' . $manifest['namespace']}([
                    'version' => $manifest['versions']['latest']
                ]);
            };

            /**
             * Create an AWS multi region client on demand.
             * @param Container $pimple The dependency injector.
             * @return MultiRegionClient
             */
            $pimple['aws.multi_region.' . $service] = static function(Container $pimple) use ($manifest) {
                /** @var Sdk $sdk */
                $sdk = &$pimple['aws.sdk'];

                return $sdk->{'createMultiRegion' . $manifest['namespace']}([
                    'version' => $manifest['versions']['latest']
                ]);
            };
        }
    }
}