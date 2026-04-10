<?php

namespace App\Services;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearchService
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['https://localhost:9200'])
            ->setBasicAuthentication('elastic', 'ZoNKr4CLM7FdDASFuDCF')
            ->setSSLVerification(false)
            ->build();
    }

    public function index($index, $id, $data)
    {

        return $this->client->index([
            'index' => $index,
            'id'    => $id,
            'body'  => $data
        ]);
    }

    public function refreshIndices($indexName)
    {
        $this->client->indices()->refresh(['index' => $indexName]);
    }

    public function search($index, $query)
    {

        return $this->client->search([
            'index' => $index,
            'body'  => [
                'query' => [
                    'match' => $query
                ]
            ]
        ]);
    }

    public function searchPaginated($index, $value, $page = 1, $perPage = 2)
    {
        $from = ($page - 1) * $perPage;

        // $response = $this->client->search([
        //     'index' => $index,
        //     'body' => [
        //         'from' => $from,
        //         'size' => $perPage,
        //         'query' => [
        //             'multi_match' => [
        //                 'query' => $value,
        //                 'fields' => ['title', 'content']
        //             ]
        //         ]
        //     ]
        // ]);


        // wildcard type query

        $response = $this->client->search([
            'index' => $index,
            'body' => [
                'from' => $from,
                'size' => $perPage,
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'multi_match' => [
                                    'query' => $value,
                                    'fields' => ['title^2', 'content']
                                ]
                            ],
                            [
                                'wildcard' => [
                                    'title.keyword' => [
                                        'value' => '*' . $value . '*',
                                        'boost' => 1
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        return [
            'data' => collect($response['hits']['hits'])->pluck('_source'),
            'total' => $response['hits']['total']['value'],
            'page' => $page,
            'per_page' => $perPage,
        ];
    }
}
