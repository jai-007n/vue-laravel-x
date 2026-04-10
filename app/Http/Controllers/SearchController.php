<?php

namespace App\Http\Controllers;

use App\Services\ElasticsearchService;

class SearchController extends Controller
{
    protected $es;

    public function __construct(ElasticsearchService $es)
    {
        $this->es = $es;
    }

    public function index()
    {
        $this->es->index('posts', 2, [
            'title' => 'ZLaravel second Elasticsearch',
            'content' => 'This is a test second document'
        ]);
        $this->es->refreshIndices('posts');
        return "Indexed!";
    }

    public function search()
    {
        $results = $this->es->search('posts', [
            'title' => 'Laravel'
        ]);
        // dd($results['hits']['hits']);
        return response()->json($results['hits']);
    }
    public function searchPaginated()
    {
        $results = $this->es->searchPaginated('posts', '*Laravel*', 1, 5);
        // dd($results['hits']['hits']);
        return response()->json($results);
    }
}
