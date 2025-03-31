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
namespace ONGR\ElasticsearchDSL\Aggregation\Pipeline;

use ONGR\ElasticsearchDSL\Sort\FieldSort;

/**
 * Class representing Bucket Script Pipeline Aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-bucket-sort-aggregation.html
 */
class BucketSortAggregation extends AbstractPipelineAggregation
{
    /**
     * @var array
     */
    private $sort = [];

    /**
     * @param string $name
     * @param string $bucketsPath
     */
    public function __construct($name, $bucketsPath = null)
    {
        parent::__construct($name, $bucketsPath);
    }

    /**
     * @return array
     */
    public function getSort()
    {
        return $this->sort;
    }

    public function addSort(FieldSort $sort): void
    {
        $this->sort[] = $sort->toArray();
    }

    /**
     * @param string $sort
     *
     * @return $this
     */
    public function setSort($sort): static
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'bucket_sort';
    }

    /**
     * {@inheritdoc}
     * @return mixed[]
     */
    public function getArray(): array
    {
        return array_filter(
            [
                'buckets_path' => $this->getBucketsPath(),
                'sort'         => $this->getSort(),
            ]
        );
    }
}
