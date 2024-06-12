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
     * @return \Qunity\Base\Api\Data\CustomUrlInterface[]
     */
    public function execute(): array;
}
