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
namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Compound;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Query\Compound\DisMaxQuery;
use PHPUnit\Framework\TestCase;

final class DisMaxQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $mock = $this->getMockBuilder(BuilderInterface::class)->getMock();
        $mock
            ->expects($this->any())
            ->method('toArray')
            ->willReturn(['term' => ['foo' => 'bar']]);

        $query = new DisMaxQuery(['boost' => 1.2]);
        $query->addQuery($mock);
        $query->addQuery($mock);
        $expected = [
            'dis_max' => [
                'queries' => [
                    ['term' => ['foo' => 'bar']],
                    ['term' => ['foo' => 'bar']],
                ],
                'boost' => 1.2,
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
