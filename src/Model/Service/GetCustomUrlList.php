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
        private readonly array $pathListData
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
            $item[CustomUrlInterface::URL] = $this->getUrl($item);

            $this->items[$code] = $this->customUrlFactory->create(['data' => $item]);
        }

        return $this->items;
    }

    /**
     * Get URL by custom URL data
     *
     * @param array $data
     * @return string
     */
    private function getUrl(array $data): string
    {
        $routePath = $data[CustomUrlInterface::ROUTE_PATH] ?? null;
        $routeParams = $data[CustomUrlInterface::ROUTE_PARAMS] ?? null;

        return $this->urlBuilder->getUrl($routePath, $routeParams);
    }
}
