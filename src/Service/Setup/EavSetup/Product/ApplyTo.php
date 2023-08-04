<?php

declare(strict_types=1);

namespace Qunity\Base\Service\Setup\EavSetup\Product;

use Magento\Catalog\Api\Data\EavAttributeInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetup;

class ApplyTo
{
    /**
     * Execute service
     *
     * @param EavSetup $eavSetup
     * @param array|string $field
     * @param array|string $typeCode
     *
     * @return void
     */
    public function execute(EavSetup $eavSetup, array|string $field, array|string $typeCode): void
    {
        $fieldList = (array) $field;
        $typeCode = (array) $typeCode;

        foreach ($fieldList as $field) {
            $applyTo = explode(',', $eavSetup->getAttribute(
                Product::ENTITY,
                $field,
                EavAttributeInterface::APPLY_TO
            ) ?: '');

            if (array_diff($typeCode, $applyTo)) {
                // @phpcs:ignore Magento2.Performance.ForeachArrayMerge.ForeachArrayMerge
                $applyTo = implode(',', array_unique(array_merge($applyTo, $typeCode)));

                $eavSetup->updateAttribute(
                    Product::ENTITY,
                    $field,
                    EavAttributeInterface::APPLY_TO,
                    $applyTo
                );
            }
        }
    }
}
