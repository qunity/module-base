<?php

declare(strict_types=1);

namespace Qunity\Base\Api\Data;

interface CustomUrlInterface
{
    public const CODE = 'code';
    public const AREA_CODE = 'area_code';
    public const URL = 'url';
    public const ROUTE_PATH = 'route_path';

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
     * Get custom URL area code
     *
     * @return string|null
     */
    public function getAreaCode(): ?string;

    /**
     * Set custom URL area code
     *
     * @param string $code
     * @return $this
     */
    public function setAreaCode(string $code): self;

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
}
