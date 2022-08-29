<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAnalysisRequest;
use App\Http\Requests\Admin\UpdateAnalysisRequest;
use App\Models\Analysis;
use App\Models\Biomaterial;
use App\Models\Complex;
use App\Models\Method;
use App\Models\TestTube;
use App\Models\Unit;
use App\Models\Type;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $elements = Analysis::query()->orderByDesc('id')->paginate(50)->withPath(route('analysis.index'));
        return response()->view('admin.analysis.index', ['elements' => $elements]);
    }

    public function listAjax()
    {
        $elements = Analysis::query()->orderByDesc('id')->paginate(50)->withPath(route('analysis.index'));
        return response()->view('admin.analysis.ajax', ['elements' => $elements, 'ajax' => 'list']);
    }

    /**
     * Change active status
     *
     * @param Request $request
     * @param Analysis $analysis
     * @return mixed
     */
    public function status(Request $request, Analysis $analysis)
    {
        $analysis->active = $request->input('active') == 'true' ? 1 : 0;
        $analysis->save();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $methods = Method::query()->orderByDesc('id')->get();
        return response()->view('admin.analysis.card', ['methods' => $methods]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAnalysisRequest $request
     * @return Response
     */
    public function store(StoreAnalysisRequest $request)
    {
        $element = new Analysis;
        $element->name = $request->input('name');
        $element->synonyms = $request->input('synonyms');
        $element->description = $request->input('description');
        $element->full_description = $request->input('full_description');
        $element->preparation = $request->input('preparation');
        $element->term = $request->input('term');
        $element->method_id = $request->input('method_id');
        $element->active = $request->input('active') ? $request->input('active') : 0;
        $element->save();
        $methods = Method::query()->orderByDesc('id')->get();
        $units = Unit::query()->orderByDesc('id')->get();
        $types = Type::query()->orderByDesc('id')->get();
        $biomaterials = Biomaterial::query()->orderByDesc('id')->get();
        $testtubes = TestTube::query()->orderByDesc('id')->get();
        $complexes = Complex::query()->orderByDesc('id')->get();
        return response()->view('admin.analysis.card', ['element' => $element, 'methods' => $methods, 'units' => $units, 'types' => $types, 'biomaterials' => $biomaterials, 'testtubes' => $testtubes, 'complexes' => $complexes]);
    }

    /**
     * Display the specified resource.
     *
     * @param Analysis $analysi
     * @return Response
     */
    public function show(Analysis $analysi)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Analysis $analysi
     * @return Response
     */
    public function edit(Analysis $analysi)
    {
        $methods = Method::query()->orderByDesc('id')->get();
        $units = Unit::query()->orderByDesc('id')->get();
        $types = Type::query()->orderByDesc('id')->get();
        $biomaterials = Biomaterial::query()->orderByDesc('id')->get();
        $testtubes = TestTube::query()->orderByDesc('id')->get();
        $complexes = Complex::query()->where('parent_id', null)->orderByDesc('id')->get();
        return response()->view('admin.analysis.card', ['element' => $analysi, 'methods' => $methods, 'units' => $units, 'types' => $types, 'biomaterials' => $biomaterials, 'testtubes' => $testtubes, 'complexes' => $complexes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnalysisRequest $request
     * @param Analysis $analysi
     * @return Response
     */
    public function update(UpdateAnalysisRequest $request, Analysis $analysi)
    {
        $analysi->name = $request->input('name');
        $analysi->synonyms = $request->input('synonyms');
        $analysi->description = $request->input('description');
        $analysi->full_description = $request->input('full_description');
        $analysi->preparation = $request->input('preparation');
        $analysi->term = $request->input('term');
        $analysi->method_id = $request->input('method_id');
        $analysi->active = $request->input('active') ? $request->input('active') : 0;
        $analysi->save();
        $methods = Method::query()->orderByDesc('id')->get();
        $units = Unit::query()->orderByDesc('id')->get();
        $types = Type::query()->orderByDesc('id')->get();
        $biomaterials = Biomaterial::query()->orderByDesc('id')->get();
        $testtubes = TestTube::query()->orderByDesc('id')->get();
        $complexes = Complex::query()->orderByDesc('id')->get();
        return response()->view('admin.analysis.card', ['element' => $analysi, 'methods' => $methods, 'units' => $units, 'types' => $types, 'biomaterials' => $biomaterials, 'testtubes' => $testtubes, 'complexes' => $complexes, 'ajax' => 'edit']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Analysis $analysi
     * @return Response
     */
    public function destroy(Analysis $analysi)
    {
        $analysi->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Analysis $analysis
     * @param Complex $complex
     * @return Response
     */
    public function complex(Request $request, Analysis $analysis, Complex $complex)
    {
        if ($request->input('complex') == 'true') {
            $analysis->complexList()->attach($complex->id);
        } else {
            $analysis->complexList()->detach($complex->id);
        }
        return $request->input('complex');
//        return $analysis->complexList();
    }
}
