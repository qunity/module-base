<?php

declare(strict_types=1);

namespace Qunity\Base\Model\Service;

use Magento\Framework\App\Area as AppArea;
use Magento\Framework\App\State as AppState;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;
use Qunity\Base\Api\Data\CustomUrlInterface;
use Qunity\Base\Api\Data\CustomUrlInterfaceFactory;
use Qunity\Base\Api\Service\GetCustomUrlListInterface;

class GetCustomUrlList implements GetCustomUrlListInterface
{
    /**
     * Lists of PHP objects containing info about custom URL list
     * @var CustomUrlInterface[][]
     */
    private array $items;

    /**
     * @param AppState $appState
     * @param UrlInterface $urlBuilder
     * @param CustomUrlInterfaceFactory $customUrlFactory
     * @param array $customUrlList
     */
    public function __construct(
        private readonly AppState $appState,
        private readonly UrlInterface $urlBuilder,
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
            $areaCode = $this->getCurrentAreaCode();
        }

        if (isset($this->items[$areaCode])) {
            return $this->items[$areaCode];
        }

        $this->items[$areaCode] = $this->getCustomUrlList($areaCode);

        return $this->items[$areaCode];
    }

    /**
     * Get current area code
     *
     * @return string
     */
    private function getCurrentAreaCode(): string
    {
        try {
            return $this->appState->getAreaCode();
        } catch (LocalizedException) {
            return AppArea::AREA_GLOBAL;
        }
    }

    /**
     * Get registered custom URL list by area code
     *
     * @param string $areaCode
     * @return CustomUrlInterface[]
     */
    private function getCustomUrlList(string $areaCode): array
    {
        $result = [];
        foreach ($this->customUrlList as $code => $item) {
            $item[CustomUrlInterface::AREA_CODE] = $item[CustomUrlInterface::AREA_CODE] ?? AppArea::AREA_GLOBAL;
            if ($areaCode != $item[CustomUrlInterface::AREA_CODE]) {
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
