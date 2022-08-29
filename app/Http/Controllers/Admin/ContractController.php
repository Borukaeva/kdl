<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreContractRequest;
use App\Http\Requests\Admin\UpdateContractRequest;
use App\Models\Contract;
use App\Models\Partner;
use App\Models\Price;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $elements = Contract::query()->orderByDesc('id')->get();
        $prices = Price::query()->orderByDesc('id')->get();
        return response()->view('admin.contract.index', ['elements' => $elements, 'prices' => $prices]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Partner $partner
     * @param Contract $contract
     * @return Response
     */
    public function listAjax(Partner $partner, Contract $contract)
    {
        $prices = Price::query()->orderByDesc('id')->get();
        return response()->view('admin.contract.ajax', ['element' => $partner, 'prices' => $prices, 'ajax' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->view('admin.contract.ajax', ['ajax' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreContractRequest $request
     * @return Response
     */
    public function store(StoreContractRequest $request)
    {
        $element = new Contract();
        $element->name = $request->input('name');
        $element->sum = $request->input('sum');
        $element->partner_id = $request->input('partner_id');
        $element->price_id = $request->input('price_id');
        $element->save();
        return response()->view('admin.contract.ajax', ['element' => $element, 'ajax' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param Contract $contract
     * @return Response
     */
    public function show(Contract $contract)
    {
        return response()->view('admin.contract.ajax', ['element' => $contract, 'ajax' => 'show']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Partner $partner
     * @param Contract $contract
     * @return Response
     */
    public function edit(Partner $partner, Contract $contract)
    {
        $prices = Price::query()->orderByDesc('id')->get();
        return response()->view('admin.contract.ajax', ['element' => $contract, 'prices' => $prices, 'ajax' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateContractRequest $request
     * @param Partner $partner
     * @param Contract $contract
     * @return Response
     */
    public function update(UpdateContractRequest $request, Partner $partner, Contract $contract)
    {
        $contract->name = $request->input('name');
        $contract->sum = $request->input('sum');
        $contract->partner_id = $partner->id;
        $contract->price_id = $request->input('price_id');
        $contract->save();
        return response()->view('admin.contract.ajax', ['element' => $contract, 'ajax' => 'item']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Partner $partner
     * @param Contract $contract
     * @return Response
     */
    public function destroy(Partner $partner, Contract $contract)
    {
        $contract->delete();
    }
}
