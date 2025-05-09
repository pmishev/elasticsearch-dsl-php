<?php

declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\Ipv4RangeAggregation;
use PHPUnit\Framework\TestCase;

final class Ipv4RangeAggregationTest extends TestCase
{
    /**
     * Test exception when field and range are not set.
     */
    public function testIfExceptionIsThrownWhenFieldAndRangeAreNotSet(): void
    {
        $this->expectException(\LogicException::class);
        $agg = new Ipv4RangeAggregation('foo');
        $agg->toArray();
    }

    /**
     * Tests if field and range  can be passed to constructor.
     */
    public function testConstructorFilter(): void
    {
        $aggregation = new Ipv4RangeAggregation('test', 'fieldName', [['from' => 'fromValue']]);
        $this->assertSame(
            [
                'ip_range' => [
                    'field'  => 'fieldName',
                    'ranges' => [['from' => 'fromValue']],
                ],
            ],
            $aggregation->toArray()
        );

        $aggregation = new Ipv4RangeAggregation('test', 'fieldName', ['maskValue']);
        $this->assertSame(
            [
                'ip_range' => [
                    'field'  => 'fieldName',
                    'ranges' => [['mask' => 'maskValue']],
                ],
            ],
            $aggregation->toArray()
        );
    }
}
