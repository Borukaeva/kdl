<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePriceRequest;
use App\Http\Requests\Admin\UpdatePriceRequest;
use App\Models\AnalysisBiomaterial;
use App\Models\AnalysisBiomaterialPrice;
use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $elements = Price::query()->orderByDesc('id')->paginate(50)->withPath(route('price.index'));
        return response()->view('admin.price.index', ['elements' => $elements]);
    }

    public function listAjax()
    {
        $elements = Price::query()->orderByDesc('id')->paginate(50)->withPath(route('price.index'));
        return response()->view('admin.price.ajax', ['elements' => $elements, 'ajax' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->view('admin.price.card');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePriceRequest $request
     * @return Response
     */
    public function store(StorePriceRequest $request)
    {
        $element = new Price();
        $element->name = $request->input('name');
        $element->save();
        $analysis_biomaterials = AnalysisBiomaterial::query()->orderByDesc('id')->get();
        return response()->view('admin.price.card', ['element' => $element, 'analysis_biomaterials' => $analysis_biomaterials]);
    }

    /**
     * Display the specified resource.
     *
     * @param Price $price
     * @return Response
     */
    public function show(Price $price)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Price $price
     * @return Response
     */
    public function edit(Price $price)
    {
        $analysis_biomaterials = AnalysisBiomaterial::where('hide_in_price', false)->orderByDesc('id')->get();
        return response()->view('admin.price.card', ['element' => $price, 'analysis_biomaterials' => $analysis_biomaterials]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePriceRequest $request
     * @param Price $price
     * @return Response
     */
    public function update(UpdatePriceRequest $request, Price $price)
    {
        $price->name = $request->input('name');
        $price->save();
        $analysis_biomaterials = AnalysisBiomaterial::where('hide_in_price', false)->orderByDesc('id')->get();
        return response()->view('admin.price.card', ['element' => $price, 'analysis_biomaterials' => $analysis_biomaterials, 'ajax' => 'edit']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Price $price
     * @return Response
     */
    public function destroy(Price $price)
    {
        AnalysisBiomaterialPrice::where('price_id', $price->id)->delete();
        $price->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Price $price
     * @param AnalysisBiomaterial $analysis_biomaterial
     * @return Response
     */
    public function analysisBiomaterial(Request $request, Price $price, AnalysisBiomaterial $analysis_biomaterial)
    {
        $empty = (is_null($request->input('price1')) || floatval($request->input('price1')) == 0) && (is_null($request->input('price2')) || floatval($request->input('price2')) == 0);
        // если значения пустые
        if ($empty) {
            // и связь существует
            if ($price->analysisBiomaterial->contains($analysis_biomaterial->id)) {
                // удаляем связь
                $price->analysisBiomaterial()->detach($analysis_biomaterial->id);
            }
        } else {
            // если связь не существует
            if (!$price->analysisBiomaterial->contains($analysis_biomaterial->id)) {
                // то создаём
                $price->analysisBiomaterial()->attach($analysis_biomaterial->id);
            }
            $pivot = $price->analysisBiomaterialPivot($analysis_biomaterial);
            $pivot->price1 = $request->input('price1');
            $pivot->price2 = $request->input('price2');
            $pivot->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Price $price
     * @param AnalysisBiomaterial $analysis_biomaterial
     * @return Response
     */
    public function test(Request $request, Price $price, AnalysisBiomaterial $analysis_biomaterial)
    {
//        if (!in_array($analysis_biomaterial->id, $price->analysisBiomaterial->pluck('id')->toArray()))
//            $price->analysisBiomaterial()->attach($analysis_biomaterial->id);
//        $echo = $price->analysisBiomaterial()->where('analysis_biomaterial.id', $analysis_biomaterial->id)->first()->pivot->price1;
//        $echo = $price->analysisBiomaterialPivot($analysis_biomaterial)->price1;
//        $echo = $price->analysisBiomaterialPivot($analysis_biomaterial);
//        $echo = $price->analysisBiomaterial->contains($analysis_biomaterial->id);
        $echo = $request->input('price2');
        return response()->view('admin.price.ajax', ['echo' => $echo, 'ajax' => 'test']);
    }
}
