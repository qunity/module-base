<?php

declare(strict_types=1);

namespace Qunity\Base\Model\Data;

use Magento\Framework\DataObject;
use Qunity\Base\Api\Data\CustomUrlInterface;

class CustomUrl extends DataObject implements CustomUrlInterface
{
    /**
     * @inheritDoc
     */
    public function getCode(): ?string
    {
        return $this->hasData(self::CODE)
            ? (string) $this->getData(self::CODE) : null;
    }

    /**
     * @inheritDoc
     */
    public function setCode(string $code): CustomUrlInterface
    {
        return $this->setData(self::CODE, $code);
    }

    /**
     * @inheritDoc
     */
    public function getUrl(): ?string
    {
        return $this->hasData(self::URL)
            ? (string) $this->getData(self::URL) : null;
    }

    /**
     * @inheritDoc
     */
    public function setUrl(string $url): CustomUrlInterface
    {
        return $this->setData(self::URL, $url);
    }

    /**
     * @inheritDoc
     */
    public function getRoutePath(): ?string
    {
        return $this->hasData(self::ROUTE_PATH)
            ? (string) $this->getData(self::ROUTE_PATH) : null;
    }

    /**
     * @inheritDoc
     */
    public function setRoutePath(string $path): CustomUrlInterface
    {
        return $this->setData(self::ROUTE_PATH, $path);
    }

    /**
     * @inheritDoc
     */
    public function getRouteParams(): ?array
    {
        return $this->hasData(self::ROUTE_PARAMS)
            ? (array) $this->getData(self::ROUTE_PARAMS) : null;
    }

    /**
     * @inheritDoc
     */
    public function setRouteParams(array $params): CustomUrlInterface
    {
        return $this->setData(self::ROUTE_PARAMS, $params);
    }
}
