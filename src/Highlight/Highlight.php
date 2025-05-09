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
namespace ONGR\ElasticsearchDSL\Highlight;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Data holder for highlight api.
 */
class Highlight implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var array Holds fields for highlight.
     */
    private array $fields = [];

    private ?array $tags = null;

    /**
     * @param string $name Field name to highlight.
     *
     * @return $this
     */
    public function addField($name, array $params = []): static
    {
        $this->fields[$name] = $params;

        return $this;
    }

    /**
     * Sets html tag and its class used in highlighting.
     *
     * @return $this
     */
    public function setTags(array $preTags, array $postTags): static
    {
        $this->tags['pre_tags'] = $preTags;
        $this->tags['post_tags'] = $postTags;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'highlight';
    }

    /**
     * {@inheritdoc}
     * @return mixed[]
     */
    public function toArray(): array
    {
        $output = [];

        if (is_array($this->tags)) {
            $output = $this->tags;
        }

        $output = $this->processArray($output);

        foreach ($this->fields as $field => $params) {
            $output['fields'][$field] = count($params) > 0 ? $params : new \stdClass();
        }

        return $output;
    }
}
