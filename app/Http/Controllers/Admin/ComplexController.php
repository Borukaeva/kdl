<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreComplexRequest;
use App\Http\Requests\Admin\UpdateComplexRequest;
use App\Models\Complex;
use App\Models\ComplexAnalysis;
use Illuminate\Http\Request;

class ComplexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $elements = Complex::whereNull('parent_id')
            ->with('childComplexes')
            ->orderByDesc('name')
            ->get();
        return response()->view('admin.complex.index', ['elements' => $elements]);
    }

    public function listAjax()
    {
        $elements = Complex::query()
            ->where('parent_id', null)
            ->orderByDesc('name')
            ->get();
        return response()->view('admin.complex.ajax', ['elements' => $elements, 'ajax' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreComplexRequest $request
     * @return Response
     */
    public function store(StoreComplexRequest $request)
    {
        $element = new Complex;
        $element->name = $request->input('name');
        $element->parent_id = $request->input('parent_id');
        $element->active = $request->input('active') ? $request->input('active') : 0;
        $element->save();
        return response()->view('admin.complex.ajax', ['element' => $element, 'ajax' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param Complex $complex
     * @return Response
     */
    public function show(Complex $complex)
    {
        return response()->view('admin.complex.ajax', ['element' => $complex, 'ajax' => 'show']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Complex $complex
     * @return Response
     */
    public function edit(Complex $complex)
    {
        return response()->view('admin.complex.ajax', ['element' => $complex, 'ajax' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateComplexRequest $request
     * @param Complex $complex
     * @return Response
     */
    public function update(UpdateComplexRequest $request, Complex $complex)
    {
        $complex->name = $request->input('name');
        $complex->parent_id = $request->input('parent_id');
        $complex->active = $request->input('active') ? $request->input('active') : 0;
        $complex->save();
        return response()->view('admin.complex.ajax', ['element' => $complex, 'ajax' => 'item']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Complex $complex
     * @return array
     */
    public function destroy(Complex $complex)
    {
        $elements_ids = $this->child($complex);
        foreach ($elements_ids as $element_id) {
            ComplexAnalysis::where('complexes_id', $element_id)
                ->delete();
            Complex::where('id', $element_id)
                ->delete();
        }
    }

    /**
     * Получение массива id дочерних комплексов
     *
     * @param Complex $complex
     * @return array
     */
    private function child(Complex $complex)
    {
        $ids = [];
        if (count($complex->complexes)) {
            foreach ($complex->complexes as $child) {
                $ids = array_merge($ids, $this->child($child));
            }
        }
        $ids[] = $complex->id;
        return $ids;
    }
}
