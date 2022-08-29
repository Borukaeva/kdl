<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUnitRequest;
use App\Http\Requests\Admin\UpdateUnitRequest;
use App\Models\Unit;
use App\Models\Type;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $elements = Unit::query()->orderByDesc('id')->paginate(50)->withPath(route('unit.index'));
        return response()->view('admin.unit.index', ['elements' => $elements]);
    }

    public function listAjax()
    {
        $elements = Unit::query()->orderByDesc('id')->paginate(50)->withPath(route('unit.index'));
        return response()->view('admin.unit.ajax', ['elements' => $elements, 'ajax' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.unit.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Admin\StoreUnitRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnitRequest $request)
    {
        $element = new Unit;
        $element->name = $request->input('name');
        $element->save();
        return response()->view('admin.unit.ajax', ['element' => $element, 'ajax' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param Unit $unit
     * @return Response
     */
    public function show(Unit $unit)
    {
        return response()->view('admin.unit.ajax', ['element' => $unit, 'ajax' => 'show']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        return response()->view('admin.unit.ajax', ['element' => $unit, 'ajax' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\UpdateUnitRequest $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        $unit->name = $request->input('name');
        $unit->save();
        return response()->view('admin.unit.ajax', ['element' => $unit, 'ajax' => 'show']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
    }
}
