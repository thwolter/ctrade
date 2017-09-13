<?php


namespace App\Repositories;



class SearchRepository
{

    protected $repo;

    public function __construct(DatasourceRepository $repo)
    {
        $this->repo = $repo;
    }


    public function search($entity, $query)
    {
        return $query ? resolve($entity)->where('name', 'like', $query.'%')->get() : [];
    }


    public function lookup($entity, $id)
    {
        $item = resolve($entity)->find($id);

        $prices = $this->repo->collectHistories($item->datasources);

        return ['item' => $item->toArray(), 'prices' => $prices];

    }
}