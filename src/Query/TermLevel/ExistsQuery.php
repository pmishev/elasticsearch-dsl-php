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
namespace ONGR\ElasticsearchDSL\Query\TermLevel;

use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Represents Elasticsearch "exists" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-exists-query.html
 */
class ExistsQuery implements BuilderInterface
{
    /**
     * Constructor.
     *
     * @param string $field Field value
     */
    public function __construct(private $field)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'exists';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            $this->getType() => [
                'field' => $this->field,
            ],
        ];
    }
}
