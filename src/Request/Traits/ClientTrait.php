<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\Requests\AssumeRoleRequest;
use AlibabaCloud\Client\Credentials\Requests\GenerateSessionAccessKeyRequest;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\Request;

/**
 * Trait ClientTrait
 *
 * @package   AlibabaCloud\Client\Request\Traits
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @mixin     Request
 */
trait ClientTrait
{
    /**
     * @return Client
     * @throws ClientException
     */
    public function httpClient()
    {
        return AlibabaCloud::get($this->client);
    }

    /**
     * Return credentials directly if it is an AssumeRoleRequest or GenerateSessionAccessKeyRequest.
     *
     * @return AccessKeyCredential|BearerTokenCredential|CredentialsInterface|StsCredential
     * @throws ClientException
     * @throws ServerException
     */
    public function credential()
    {
        if ($this instanceof AssumeRoleRequest || $this instanceof GenerateSessionAccessKeyRequest) {
            return $this->httpClient()->getCredential();
        }

        return $this->httpClient()->getSessionCredential();
    }

    /**
     * @throws ClientException
     */
    public function mergeOptionsIntoClient()
    {
        $this->options = \AlibabaCloud\Client\arrayMerge([$this->httpClient()->options, $this->options]);
    }
}
