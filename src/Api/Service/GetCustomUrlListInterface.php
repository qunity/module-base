<?php

/**
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

declare(strict_types=1);

namespace Qunity\Base\Api\Service;

interface GetCustomUrlListInterface
{
    /**
     * Get registered custom URL list
     *
     * @param string|null $areaCode
     * @return \Qunity\Base\Api\Data\CustomUrlInterface[]
     */
    public function execute(string $areaCode = null): array;
}
