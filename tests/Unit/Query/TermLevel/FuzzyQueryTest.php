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
namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use ONGR\ElasticsearchDSL\Query\TermLevel\FuzzyQuery;
use PHPUnit\Framework\TestCase;

final class FuzzyQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new FuzzyQuery('user', 'ki', ['boost' => 1.2]);
        $expected = [
            'fuzzy' => [
                'user' => [
                    'value' => 'ki',
                    'boost' => 1.2,
                ],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
