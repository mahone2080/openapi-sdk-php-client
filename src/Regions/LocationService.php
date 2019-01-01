<?php

namespace AlibabaCloud\Client\Regions;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\Request;

/**
 * Class LocationService
 *
 * @package   AlibabaCloud\Client\Regions
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class LocationService
{

    /**
     * @var Request
     */
    protected $request;
    /**
     * @var array
     */
    private static $cache = [];

    /**
     * LocationService constructor.
     *
     * @param Request $request
     */
    private function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @deprecated
     *
     * @param Request $request
     * @param string  $domain
     *
     * @return mixed
     * @throws ClientException
     * @throws ServerException
     */
    public static function findProductDomain(Request $request, $domain = LOCATION_SERVICE_DOMAIN)
    {
        return self::resolveHost($request, $domain);
    }

    /**
     * @param Request $request
     * @param string  $domain
     *
     * @return mixed
     * @throws ClientException
     * @throws ServerException
     */
    public static function resolveHost(Request $request, $domain = LOCATION_SERVICE_DOMAIN)
    {
        $instance = new static($request);
        $key      = $instance->request->realRegionId() . '#' . $instance->request->product;
        if (!isset(self::$cache[$key])) {
            $result = (new LocationServiceRequest($instance->request, $domain))->request();

            // @codeCoverageIgnoreStart
            if (!isset($result['Endpoints']['Endpoint'][0]['Endpoint'])) {
                throw new ClientException(
                    'Can Not Find RegionId From: ' . $domain,
                    \ALI_INVALID_REGION_ID
                );
            }

            if (!$result['Endpoints']['Endpoint'][0]['Endpoint']) {
                throw new ClientException(
                    'Invalid RegionId: ' . $result['Endpoints']['Endpoint'][0]['Endpoint'],
                    \ALI_INVALID_REGION_ID
                );
            }

            self::$cache[$key] = $result['Endpoints']['Endpoint'][0]['Endpoint'];
            // @codeCoverageIgnoreEnd
        }

        return self::$cache[$key];
    }

    /**
     * @deprecated
     *
     * @param string $regionId
     * @param string $product
     * @param string $domain
     */
    public static function addEndPoint($regionId, $product, $domain)
    {
        self::addHost($regionId, $product, $domain);
    }

    /**
     * @param string $regionId
     * @param string $product
     * @param string $domain
     */
    public static function addHost($regionId, $product, $domain)
    {
        $key               = $regionId . '#' . $product;
        self::$cache[$key] = $domain;
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     * @return             void
     */
    public static function modifyServiceDomain()
    {
    }
}
