<?php

declare(strict_types=1);

/*
 * This file is part of the SolidWoex Util package.
 *
 * (c) SolidWorx <open-source@solidworx.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SolidWorx\Tests\Util;

use PHPUnit\Framework\TestCase;
use SolidWorx\Util\ArrayUtil;

class ArrayUtilTest extends TestCase
{
    /**
     * @dataProvider columnProvider
     */
    public function testColumn(array $expected, array $actual, $flag = true)
    {
        $this->assertSame($expected, ArrayUtil::column($actual, 'test', $flag));
    }

    public function columnProvider()
    {
        yield [
            [
                1,
                2,
                3,
            ],
            [
                ['test' => 1],
                ['test' => 2],
                ['test' => 3],
            ],
        ];

        $object1 = new ObjectProperty;
        $object1->test = 4;
        $object2 = new ObjectProperty;
        $object2->test = 5;
        $object3 = new ObjectProperty;
        $object3->test = 6;

        yield [
            [
                4,
                5,
                6,
            ],
            [
                $object1,
                $object2,
                $object3,
            ],
        ];

        yield [
            [
                7,
                8,
                9,
            ],
            [
                new ObjectMethod(7),
                new ObjectMethod(8),
                new ObjectMethod(9),
            ],
        ];

        yield [
            [
                10,
                11,
                12,
            ],
            [
                new ObjectGetter(10),
                new ObjectGetter(11),
                new ObjectGetter(12),
            ],
        ];

        // Test filter

        yield [
            [
                13,
                14,
                15,
            ],
            [
                new ObjectGetter(13),
                new ObjectGetter(14),
                new ObjectGetter(15),
                new ObjectGetter(null),
            ],
            true,
        ];

        yield [
            [
                16,
                17,
                18,
                null,
            ],
            [
                new ObjectGetter(16),
                new ObjectGetter(17),
                new ObjectGetter(18),
                new ObjectGetter(null),
            ],
            false,
        ];

        yield [
            [
                19,
                20,
                21,
            ],
            [
                ['test' => 19],
                ['test' => 20],
                ['test' => 21],
                ['test' => null],
            ],
            true,
        ];

        yield [
            [
                22,
                23,
                24,
                null,
            ],
            [
                ['test' => 22],
                ['test' => 23],
                ['test' => 24],
                ['test' => null],
            ],
            false,
        ];

        // Test combination of values

        $object25 = new ObjectProperty;
        $object25->test = 25;

        yield [
            [
                25,
                26,
                27,
                28,
            ],
            [
                $object25,
                new ObjectMethod(26),
                new ObjectGetter(27),
                ['test' => 28],
            ],
        ];
    }
}

class ObjectProperty
{
    public $test;
}

class ObjectMethod
{
    private $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    public function test()
    {
        return $this->test;
    }
}

class ObjectGetter
{
    private $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    public function getTest()
    {
        return $this->test;
    }
}
