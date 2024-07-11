<?php

declare(strict_types=1);

namespace Qunity\Base\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Qunity\Base\Api\Data\CustomUrlInterface;
use Qunity\Base\Api\Service\GetCustomUrlListInterface;

class BackendUrl extends Template
{
    private const JS_COMPONENT_NAME = 'backendUrl';
    private const JS_PROPERTY_URLS_NAME = 'urls';

    /**
     * Custom URL list for current area
     * @var CustomUrlInterface[]
     */
    private array $customUrlList;

    /**
     * @param ArrayManager $arrayManager
     * @param SerializerInterface $serializer
     * @param GetCustomUrlListInterface $getCustomUrlList
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        private readonly ArrayManager $arrayManager,
        private readonly SerializerInterface $serializer,
        private readonly GetCustomUrlListInterface $getCustomUrlList,
        Template\Context $context,
        array $data = [],
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @inheritDoc
     */
    public function getJsLayout(): string
    {
        $registeredUrls = [];
        foreach ($this->getCustomUrlList() as $code => $customUrl) {
            $registeredUrls[$code] = $customUrl->getUrl();
        }

        $this->updateJsLayout($registeredUrls);

        return $this->serializer->serialize($this->jsLayout);
    }

    /**
     * Check if exist custom URL list
     *
     * @return bool
     */
    public function hasCustomUrlList(): bool
    {
        return !empty($this->getCustomUrlList());
    }

    /**
     * Get custom URL list for current area
     *
     * @return CustomUrlInterface[]
     */
    public function getCustomUrlList(): array
    {
        if (!isset($this->customUrlList)) {
            $this->customUrlList = $this->getCustomUrlList->execute();
        }

        return $this->customUrlList;
    }

    /**
     * Update JS layout data to match new custom URL list
     *
     * @param array $urls
     * @return void
     */
    private function updateJsLayout(array $urls): void
    {
        $delimiter = ArrayManager::DEFAULT_PATH_DELIMITER;
        $path = implode($delimiter, ['components', self::JS_COMPONENT_NAME]);
        $data = ['config' => [self::JS_PROPERTY_URLS_NAME => $urls]];

        $this->jsLayout = $this->arrayManager->remove("$path{$delimiter}config", $this->jsLayout);
        $this->jsLayout = $this->arrayManager->merge($path, $this->jsLayout, $data);
    }
}
