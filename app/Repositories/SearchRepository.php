<?php


namespace App\Repositories;



class SearchRepository
{

    public function search($entity, $query)
    {
        return resolve($entity)->search($query)->get();
    }


    public function lookup($entity, $id)
    {
        $item = resolve($entity)->find($id);

        $prices = [];
        foreach ($item->datasources as $datasource)
        {
            $data = new DataRepository($datasource);
            $prices[] = ['exchange'=> $datasource->exchange->code, 'price' => $data->price()];
        };

        return ['item' => $item->toArray(), 'prices' => $prices];

    }
}