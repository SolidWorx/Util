<?php

declare(strict_types=1);

/*
 * This file is part of the SolidWorx Util package.
 *
 * (c) SolidWorx <open-source@solidworx.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SolidWorx\Util;

use Symfony\Component\PropertyAccess\PropertyAccess;

class ArrayUtil
{
    /**
     * Returns a specific column from an array.
     *
     * @param array|\Traversable $array
     * @param string             $column
     * @param bool               $filter To filter out empty values
     *
     * @return array
     *
     * @throws \Exception
     */
    public static function column($array, string $column, bool $filter = true): array
    {
        if (!is_array($array) && !$array instanceof \Traversable) {
            throw new \Exception(sprintf('Array or instance of Traversable expected, "%s" given', gettype($array)));
        }

        $filterFunc = function (array $result) use ($filter) {
            return $filter ? array_filter($result, function ($item): bool {
                return null !== $item;
            }) : $result;
        };

        if (is_array($array)) {
            reset($array);

            if (is_array($array[key($array)])) {
                return $filterFunc(array_column($array, $column));
            }
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        $result = [];

        foreach ($array as $item) {
            $check = $column;
            if ((is_array($item) || $item instanceof \ArrayAccess) && '[' !== $column[0]) {
                $check = '['.$column.']';
            }

            $result[] = $accessor->getValue($item, $check);
        }

        return $filterFunc($result);
    }
}
