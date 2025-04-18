<?php

declare(strict_types=1);

namespace Qunity\Base\Api\Data;

interface CustomUrlInterface
{
    public const CODE = 'code';
    public const URL = 'url';
    public const ROUTE_PATH = 'route_path';
    public const ROUTE_PARAMS = 'route_params';

    /**
     * Get custom URL code
     *
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * Set custom URL code
     *
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): self;

    /**
     * Get custom URL
     *
     * @return string|null
     */
    public function getUrl(): ?string;

    /**
     * Set custom URL
     *
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): self;

    /**
     * Get custom URL route path
     *
     * @return string|null
     */
    public function getRoutePath(): ?string;

    /**
     * Set custom URL route path
     *
     * @param string $path
     * @return $this
     */
    public function setRoutePath(string $path): self;

    /**
     * Get custom URL route params
     *
     * @return array|null
     */
    public function getRouteParams(): ?array;

    /**
     * Set custom URL route params
     *
     * @param array $params
     * @return $this
     */
    public function setRouteParams(array $params): self;
}
