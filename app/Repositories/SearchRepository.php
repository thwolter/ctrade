<?php


namespace App\Repositories;



class SearchRepository
{

    public function search($entity, $query)
    {
        return resolve($entity)
            ->where('name', 'like', $query.'%')->get();
    }


    public function lookup($entity, $id)
    {
        $item = resolve($entity)->find($id);

        $prices = [];
        foreach ($item->datasources as $datasource)
        {
            $data = new DataRepository($datasource);
            $prices[] = [
                'exchange'=> $datasource->exchange->code,
                'price' => $data->price(),
                'datasourceId' => $datasource->id];
        };

        return ['item' => $item->toArray(), 'prices' => $prices];

    }
}