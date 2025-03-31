<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use ONGR\ElasticsearchDSL\Query\TermLevel\RangeQuery;
use PHPUnit\Framework\TestCase;

class RangeQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new RangeQuery('age', ['gte' => 10, 'lte' => 20]);
        $expected = [
            'range' => [
                'age' => [
                    'gte' => 10,
                    'lte' => 20,
                ],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
