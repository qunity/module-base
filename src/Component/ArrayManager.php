<?php

declare(strict_types=1);

namespace Qunity\Base\Component;

use Magento\Framework\Stdlib\ArrayManager as MagentoArrayManager;

class ArrayManager
{
    /**
     * @var MagentoArrayManager
     */
    private MagentoArrayManager $arrayManager;

    /**
     * @param MagentoArrayManager $arrayManager
     */
    public function __construct(MagentoArrayManager $arrayManager)
    {
        $this->arrayManager = $arrayManager;
    }

    /**
     * Set value into inputted array
     *
     * @param array|string $path
     * @param array $array
     * @param mixed $value
     *
     * @return void
     */
    public function set(array|string $path, array &$array, mixed $value): void
    {
        $array = $this->arrayManager->set($this->getPath($path, $array), $array, $value);
    }

    /**
     * Get value from inputted array
     *
     * @param array|string $path
     * @param array $array
     *
     * @return mixed
     */
    public function get(array|string $path, array $array): mixed
    {
        return $this->arrayManager->get($this->getPath($path, $array), $array);
    }

    /**
     * Remove value from inputted array
     *
     * @param array|string $path
     * @param array $array
     *
     * @return void
     */
    public function remove(array|string $path, array &$array): void
    {
        $array = $this->arrayManager->remove($this->getPath($path, $array), $array);
    }

    /**
     * Get path of array value
     *
     * @param array|string $path
     * @param array $array
     *
     * @return string
     */
    private function getPath(array|string $path, array $array): string
    {
        $path = (array) $path;
        $extraPath = (array) ($path['*'] ?? []);
        unset($path['*']);

        $path = $this->arrayManager->findPath($path, $array);
        if ($extraPath) {
            array_unshift($extraPath, '');
            $path .= implode(MagentoArrayManager::DEFAULT_PATH_DELIMITER, $extraPath);
        }

        return $path;
    }
}
