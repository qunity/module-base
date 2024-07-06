<?php

declare(strict_types=1);

namespace Qunity\Base\Model\Service;

use Magento\Framework\UrlInterface;
use Qunity\Base\Api\Data\CustomUrlInterface;
use Qunity\Base\Api\Data\CustomUrlInterfaceFactory;
use Qunity\Base\Api\Service\GetCustomUrlListInterface;

class GetCustomUrlList implements GetCustomUrlListInterface
{
    /**
     * List of PHP objects containing info about custom URL list
     * @var CustomUrlInterface[]
     */
    private array $items;

    /**
     * @param UrlInterface $urlBuilder
     * @param CustomUrlInterfaceFactory $customUrlFactory
     * @param array $pathListData
     */
    public function __construct(
        private readonly UrlInterface $urlBuilder,
        private readonly CustomUrlInterfaceFactory $customUrlFactory,
        private readonly array $pathListData = []
    ) {
        // ...
    }

    /**
     * @inheritDoc
     */
    public function execute(): array
    {
        if (isset($this->items)) {
            return $this->items;
        }

        foreach ($this->pathListData as $code => $item) {
            $item[CustomUrlInterface::CODE] = $code;

            $routePath = $item[CustomUrlInterface::ROUTE_PATH] ?? null;
            $routeParams = $item[CustomUrlInterface::ROUTE_PARAMS] ?? null;

            $item[CustomUrlInterface::URL] = $this->urlBuilder->getUrl($routePath, $routeParams);

            $this->items[$code] = $this->customUrlFactory->create(['data' => $item]);
        }

        return $this->items;
    }
}
