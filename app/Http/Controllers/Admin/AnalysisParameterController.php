<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAnalysisParameterRequest;
use App\Http\Requests\Admin\UpdateAnalysisParameterRequest;
use App\Models\Analysis;
use App\Models\AnalysisParameter;
use App\Models\Unit;
use App\Models\Type;
use Illuminate\Http\Request;

class AnalysisParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $elements = AnalysisParameter::query()->orderByDesc('id')->get();
        $units = Unit::query()->orderByDesc('id')->get();
        $types = Type::query()->orderByDesc('id')->get();
        return response()->view('admin.analysis_parameter.index', ['elements' => $elements, 'units' => $units, 'types' => $types]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Analysis $analysis
     * @param AnalysisParameter $parameter
     * @return Response
     */
    public function listAjax(Analysis $analysis, AnalysisParameter $parameter)
    {
        $units = Unit::query()->orderByDesc('id')->get();
        $types = Type::query()->orderByDesc('id')->get();
        return response()->view('admin.analysis_parameter.ajax', ['element' => $analysis, 'units' => $units, 'types' => $types, 'ajax' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        return response()->view('admin.analysis_parameter.ajax', ['ajax' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAnalysisParameterRequest $request
     * @return Response
     */
    public function store(StoreAnalysisParameterRequest $request)
    {
        $element = new AnalysisParameter;
        $element->name = $request->input('name');
        $element->analysis_id = $request->input('analysis_id');
        $element->unit_id = $request->input('unit_id');
        $element->type_id = $request->input('type_id');
        $element->norm1 = $request->input('norm1');
        $element->norm2 = $request->input('norm2');
        $element->save();
        return response()->view('admin.analysis_parameter.ajax', ['element' => $element, 'ajax' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $element = AnalysisParameter::query()->findOrFail($id);
        return response()->view('admin.analysis_parameter.ajax', ['element' => $element, 'ajax' => 'show']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Analysis $analysi
     * @param AnalysisParameter $parameter
     * @return Response
     */
    public function edit(Analysis $analysi, AnalysisParameter $parameter)
    {
        $units = Unit::query()->orderByDesc('id')->get();
        $types = Type::query()->orderByDesc('id')->get();
        return response()->view('admin.analysis_parameter.ajax', ['element' => $parameter, 'units' => $units, 'types' => $types, 'ajax' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnalysisParameterRequest $request
     * @param Analysis $analysi
     * @param AnalysisParameter $parameter
     * @return Response
     */
    public function update(UpdateAnalysisParameterRequest $request, Analysis $analysi, AnalysisParameter $parameter)
    {
        $parameter->name = $request->input('name');
        $parameter->analysis_id = $request->input('analysis_id');
        $parameter->unit_id = $request->input('unit_id');
        $parameter->type_id = $request->input('type_id');
        $parameter->norm1 = $request->input('norm1');
        $parameter->norm2 = $request->input('norm2');
        $parameter->save();
        return response()->view('admin.analysis_parameter.ajax', ['element' => $parameter, 'ajax' => 'item']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Analysis $analysi
     * @param AnalysisParameter $parameter
     * @return Response
     */
    public function destroy(Analysis $analysi, AnalysisParameter $parameter)
    {
        $parameter->delete();
    }
}
