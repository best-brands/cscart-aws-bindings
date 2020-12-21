<?php

use function Aws\manifest;

/**
 * Contains an array as follows:
 * $manifest = [
 *     'service-name' => [
 *         'namespace' => 'ServiceName',
 *         'versions' => [
 *             'latest' => '2019-11-01',
 *             '2019-11-01' => '2019-11-01',
 *         ],
 *     ],
 * ];
 */

return manifest();