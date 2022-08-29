<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAnalysisBiomaterialRequest;
use App\Http\Requests\Admin\UpdateAnalysisBiomaterialRequest;
use App\Models\Analysis;
use App\Models\AnalysisBiomaterial;
use App\Models\Biomaterial;
use App\Models\TestTube;
use Illuminate\Http\Request;
use Validator;

class AnalysisBiomaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $elements = AnalysisBiomaterial::query()->orderByDesc('id')->get();
        $biomaterials = Biomaterial::query()->orderByDesc('id')->get();
        $testtubes = TestTube::query()->orderByDesc('id')->get();
        return response()->view('admin.analysis_biomaterial.index', ['elements' => $elements, 'biomaterials' => $biomaterials, 'testtubes' => $testtubes]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Analysis $analysis
     * @param AnalysisBiomaterial $biomaterial
     * @return Response
     */
    public function listAjax(Analysis $analysis, AnalysisBiomaterial $biomaterial)
    {
        $biomaterials = Biomaterial::query()->orderByDesc('id')->get();
        $testtubes = TestTube::query()->orderByDesc('id')->get();
        return response()->view('admin.analysis_biomaterial.ajax', ['element' => $analysis, 'biomaterials' => $biomaterials, 'testtubes' => $testtubes, 'ajax' => 'list']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Analysis $analysis
     * @param AnalysisBiomaterial $biomaterial
     * @return Response
     */
    public function listPriceAjax(Analysis $analysis, AnalysisBiomaterial $biomaterial)
    {
        $biomaterials = Biomaterial::query()->orderByDesc('id')->get();
        $testtubes = TestTube::query()->orderByDesc('id')->get();
        return response()->view('admin.analysis_biomaterial.price', ['element' => $analysis, 'biomaterials' => $biomaterials, 'testtubes' => $testtubes, 'ajax' => 'index']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->view('admin.analysis_biomaterial.ajax', ['ajax' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAnalysisBiomaterialRequest $request
     * @return Response
     */
    public function store(StoreAnalysisBiomaterialRequest $request)
    {
        $element = new AnalysisBiomaterial;
        $element->analysis_id = $request->input('analysis_id');
        $element->biomaterials_id = $request->input('biomaterials_id');
        $element->test_tubes_id = $request->input('test_tubes_id');
        $element->hide_in_price = $request->input('hide_in_price') == 1;
        $element->result_type = 10;
        $element->save();
        $biomaterials = Biomaterial::query()->orderByDesc('id')->get();
        $testtubes = TestTube::query()->orderByDesc('id')->get();
        return response()->view('admin.analysis_biomaterial.ajax', ['element' => $element, 'biomaterials' => $biomaterials, 'testtubes' => $testtubes, 'ajax' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $element = AnalysisBiomaterial::query()->findOrFail($id);
        return response()->view('admin.analysis_biomaterial.ajax', ['element' => $element, 'ajax' => 'show']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Analysis $analysi
     * @param AnalysisBiomaterial $biomaterial
     * @return Response
     */
    public function edit(Analysis $analysi, AnalysisBiomaterial $biomaterial)
    {
        $biomaterials = Biomaterial::query()->orderByDesc('id')->get();
        $testtubes = TestTube::query()->orderByDesc('id')->get();
        return response()->view('admin.analysis_biomaterial.ajax', ['element' => $biomaterial, 'biomaterials' => $biomaterials, 'testtubes' => $testtubes, 'ajax' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnalysisBiomaterialRequest $request
     * @param Analysis $analysi
     * @param AnalysisBiomaterial $biomaterial
     * @return Response
     */
    public function update(UpdateAnalysisBiomaterialRequest $request, Analysis $analysi, AnalysisBiomaterial $biomaterial)
    {
        $biomaterial->analysis_id = $request->input('analysis_id');
        $biomaterial->biomaterials_id = $request->input('biomaterials_id');
        $biomaterial->test_tubes_id = $request->input('test_tubes_id');
        $biomaterial->hide_in_price = $request->input('hide_in_price') == 1;
        if ($request->input('hide_in_price') == 0) $biomaterial->price()->detach();
        $biomaterial->result_type = 10;
        $biomaterial->save();
        $biomaterials = Biomaterial::query()->orderByDesc('id')->get();
        $testtubes = TestTube::query()->orderByDesc('id')->get();
        return response()->view('admin.analysis_biomaterial.ajax', ['element' => $biomaterial, 'biomaterials' => $biomaterials, 'testtubes' => $testtubes, 'ajax' => 'item']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Analysis $analysi
     * @param AnalysisBiomaterial $biomaterial
     * @return Response
     */
    public function destroy(Analysis $analysi, AnalysisBiomaterial $biomaterial)
    {
        $biomaterial->delete();
    }
}
