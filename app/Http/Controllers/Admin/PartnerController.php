<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePartnerRequest;
use App\Http\Requests\Admin\UpdatePartnerRequest;
use App\Models\Partner;
use App\Models\Price;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $elements = Partner::query()->orderByDesc('id')->paginate(50)->withPath(route('partner.index'));
        return response()->view('admin.partner.index', ['elements' => $elements]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function listAjax()
    {
        $elements = Partner::query()->orderByDesc('id')->paginate(50)->withPath(route('partner.index'));
        return response()->view('admin.partner.ajax', ['elements' => $elements, 'ajax' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $prices = Price::query()->orderByDesc('id')->get();
        return response()->view('admin.partner.card', ['prices' => $prices]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePartnerRequest $request
     * @return Response
     */
    public function store(StorePartnerRequest $request)
    {
        $element = new Partner();
        $element->name = $request->input('name');
        $element->save();
        $prices = Price::query()->orderByDesc('id')->get();
        return response()->view('admin.partner.card', ['element' => $element, 'prices' => $prices]);
    }

    /**
     * Display the specified resource.
     *
     * @param Partner $partner
     * @return Response
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Partner $partner
     * @return Response
     */
    public function edit(Partner $partner)
    {
        $prices = Price::query()->orderByDesc('id')->get();
        return response()->view('admin.partner.card', ['element' => $partner, 'prices' => $prices]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePartnerRequest $request
     * @param Partner $partner
     * @return Response
     */
    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $partner->name = $request->input('name');
        $partner->save();
        $prices = Price::query()->orderByDesc('id')->get();
        return response()->view('admin.partner.card', ['element' => $partner, 'prices' => $prices, 'ajax' => 'edit']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Partner $partner
     * @return Response
     */
    public function destroy(Partner $partner)
    {
        $partner->contract()->delete();
        $partner->delete();
    }
}
