<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDiscountRequest;
use App\Http\Requests\Admin\UpdateDiscountRequest;
use App\Models\Discount;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $elements = Discount::query()->orderByDesc('id')->paginate(50)->withPath(route('discount.index'));
        return response()->view('admin.discount.index', ['elements' => $elements]);
    }

    public function listAjax()
    {
        $elements = Discount::query()->orderByDesc('id')->paginate(50)->withPath(route('discount.index'));
        return response()->view('admin.discount.ajax', ['elements' => $elements, 'ajax' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->view('admin.discount.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreDiscountRequest  $request
     * @return Response
     */
    public function store(StoreDiscountRequest $request)
    {
        $element = new Discount;
        $element->percent = $request->input('percent');
        $element->save();
        return response()->view('admin.discount.ajax', ['element' => $element, 'ajax' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Discount  $discount
     * @return Response
     */
    public function show(Discount $discount)
    {
        return response()->view('admin.discount.ajax', ['element' => $discount, 'ajax' => 'show']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Discount  $discount
     * @return Response
     */
    public function edit(Discount $discount)
    {
        return response()->view('admin.discount.ajax', ['element' => $discount, 'ajax' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateDiscountRequest  $request
     * @param  Discount  $discount
     * @return Response
     */
    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        $discount->percent = $request->input('percent');
        $discount->save();
        return response()->view('admin.discount.ajax', ['element' => $discount, 'ajax' => 'item']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Discount  $discount
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
    }
}
