<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDiscountCardRequest;
use App\Http\Requests\Admin\UpdateDiscountCardRequest;
use App\Models\DiscountCard;
use Illuminate\Http\Request;

class DiscountCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $elements = DiscountCard::query()->orderByDesc('id')->paginate(50)->withPath(route('discount_card.index'));
        return response()->view('admin.discount_card.index', ['elements' => $elements]);
    }

    public function listAjax()
    {
        $elements = DiscountCard::query()->orderByDesc('id')->paginate(50)->withPath(route('discount_card.index'));
        return response()->view('admin.discount_card.ajax', ['elements' => $elements, 'ajax' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->view('admin.discount_card.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDiscountCardRequest $request
     * @return Response
     */
    public function store(StoreDiscountCardRequest $request)
    {
        $element = new DiscountCard;
        $element->code = $request->input('code');
        $element->percent = $request->input('percent');
        $element->save();
        return response()->view('admin.discount_card.ajax', ['element' => $element, 'ajax' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param DiscountCard $discount_card
     * @return Response
     */
    public function show(DiscountCard $discount_card)
    {
        return response()->view('admin.discount_card.ajax', ['element' => $discount_card, 'ajax' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return Response
     */
    public function getDiscount(Request $request)
    {
        $code = $request->input("code");
        $discount = DiscountCard::where('code', $code)->first();
        return $discount ? $discount->percent : 0;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DiscountCard $discount_card
     * @return Response
     */
    public function edit(DiscountCard $discount_card)
    {
        return response()->view('admin.discount_card.ajax', ['element' => $discount_card, 'ajax' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDiscountCardRequest $request
     * @param DiscountCard $discount_card
     * @return Response
     */
    public function update(UpdateDiscountCardRequest $request, DiscountCard $discount_card)
    {
        $discount_card->code = $request->input('code');
        $discount_card->percent = $request->input('percent');
        $discount_card->save();
        return response()->view('admin.discount_card.ajax', ['element' => $discount_card, 'ajax' => 'item']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DiscountCard $discount_card
     */
    public function destroy(DiscountCard $discount_card)
    {
        $discount_card->delete();
    }
}
