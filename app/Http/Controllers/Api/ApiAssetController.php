<?php

namespace App\Http\Controllers\Api;

use App\Entities\Asset;
use App\Repositories\DatasourceRepository;
use App\Repositories\SearchRepository;
use Illuminate\Http\Request;

class ApiAssetController extends ApiBaseController
{

    /**
     * @var DatasourceRepository
     */
    protected $repo;


    public function __construct(DatasourceRepository $repo)
    {
        $this->repo = $repo;
    }


    public function fetch(Request $request)
    {
        $this->validate($request, [
            'assetId' => 'required|exists:assets,id'
        ]);

        $asset = Asset::find($request->assetId);

        return [
            'instrument'        => $asset->positionable->toArray(),
            'portfolioId'       => $asset->portfolio->id,
            'prices'            => $this->repo->collectHistories($asset->positionable->datasources),
            'amount'            => $asset->amount(),
            'cash'              => $asset->portfolio->cash(),
        ];
    }
}
