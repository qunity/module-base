<?php

/**
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

declare(strict_types=1);

namespace Qunity\Base\Api\Service\LayoutHandle;

interface GetCustomUrlListInterface
{
    /**
     * Get registered custom URL list by area code
     *
     * @param string|null $areaCode
     * @return \Qunity\Base\Api\Data\LayoutHandle\CustomUrlInterface[]
     */
    public function execute(string $areaCode = null): array;
}
