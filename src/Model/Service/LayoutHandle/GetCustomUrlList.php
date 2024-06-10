<?php

declare(strict_types=1);

namespace Qunity\Base\Model\Service\LayoutHandle;

use Magento\Framework\App\Area;
use Magento\Framework\App\State as AppState;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;
use Qunity\Base\Api\Data\LayoutHandle\CustomUrlInterface;
use Qunity\Base\Api\Data\LayoutHandle\CustomUrlInterfaceFactory;
use Qunity\Base\Api\Service\LayoutHandle\GetCustomUrlListInterface;

class GetCustomUrlList implements GetCustomUrlListInterface
{
    /**
     * List of PHP objects containing info about custom URL list
     * @var CustomUrlInterface[][]
     */
    private array $items;

    /**
     * @param UrlInterface $urlBuilder
     * @param AppState $appState
     * @param CustomUrlInterfaceFactory $customUrlFactory
     * @param array $customUrlList
     */
    public function __construct(
        private readonly UrlInterface $urlBuilder,
        private readonly AppState $appState,
        private readonly CustomUrlInterfaceFactory $customUrlFactory,
        private readonly array $customUrlList = []
    ) {
        // ...
    }

    /**
     * @inheritDoc
     */
    public function execute(string $areaCode = null): array
    {
        if (empty($areaCode)) {
            $areaCode = $this->getAreaCode();
        }

        if (isset($this->items[$areaCode])) {
            return $this->items[$areaCode];
        }

        $this->items[$areaCode] = $this->getAreaCustomUrlList($areaCode);

        return $this->items[$areaCode];
    }

    /**
     * Get current area code
     *
     * @return string
     */
    private function getAreaCode(): string
    {
        try {
            return $this->appState->getAreaCode();
        } catch (LocalizedException) {
            return Area::AREA_GLOBAL;
        }
    }

    /**
     * Get registered custom URL list by area code
     *
     * @param string $areaCode
     * @return CustomUrlInterface[]
     */
    private function getAreaCustomUrlList(string $areaCode): array
    {
        $result = [];
        foreach ($this->customUrlList as $code => $item) {
            $itemAreaCode = $item[CustomUrlInterface::AREA_CODE] =
                $item[CustomUrlInterface::AREA_CODE] ?? Area::AREA_GLOBAL;
            if ($areaCode != $itemAreaCode) {
                continue;
            }

            $item[CustomUrlInterface::CODE] = $code;
            if (!isset($item[CustomUrlInterface::URL])) {
                $routePath = $item[CustomUrlInterface::ROUTE_PATH] ?? '';
                $item[CustomUrlInterface::URL] = $this->urlBuilder->getUrl($routePath);
            }

            $result[$areaCode][$code] = $this->customUrlFactory->create(['data' => $item]);
        }

        return $result[$areaCode] ?? [];
    }
}
