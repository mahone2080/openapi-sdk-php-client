<?php

namespace AlibabaCloud\Client;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Traits\ClientTrait;
use AlibabaCloud\Client\Traits\EndpointTrait;
use AlibabaCloud\Client\Traits\RegionTrait;
use AlibabaCloud\Client\Traits\RequestTrait;

/**
 * Class AlibabaCloud
 *
 * @package   AlibabaCloud\Client
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 * @mixin     \AlibabaCloud\ServiceResolverTrait
 */
class AlibabaCloud
{
    use ClientTrait;
    use RegionTrait;
    use EndpointTrait;
    use RequestTrait;

    /**
     * This static method can directly call the specific service.
     *
     * @param string $serviceName
     * @param array  $arguments
     *
     * @codeCoverageIgnore
     * @return object
     * @throws ClientException
     */
    public static function __callStatic($serviceName, $arguments)
    {
        $serviceName = \ucfirst($serviceName);

        $class = 'AlibabaCloud' . '\\' . $serviceName . '\\' . $serviceName;
        if (\class_exists($class)) {
            return new $class;
        }

        if (\trait_exists("AlibabaCloud\\ServiceResolverTrait")) {
            throw new ClientException(
                "Please confirm that $serviceName exists.",
                \ALI_SERVICE_NOT_FOUND
            );
        }

        throw new ClientException(
            'Please install alibabacloud/sdk first.',
            \ALI_SERVICE_NOT_FOUND
        );
    }
}
