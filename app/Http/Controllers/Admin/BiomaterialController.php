<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBiomaterialRequest;
use App\Http\Requests\Admin\UpdateBiomaterialRequest;
use App\Models\Biomaterial;
use Illuminate\Http\Request;

class BiomaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $elements = Biomaterial::query()->orderByDesc('id')->paginate(50)->withPath(route('biomaterials.index'));
        return response()->view('admin.biomaterial.index', ['elements' => $elements]);
    }

    public function listAjax()
    {
        $elements = Biomaterial::query()->orderByDesc('id')->paginate(50)->withPath(route('biomaterials.index'));
        return response()->view('admin.biomaterial.ajax', ['elements' => $elements, 'ajax' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->view('admin.biomaterial.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBiomaterialRequest $request
     * @return Response
     */
    public function store(StoreBiomaterialRequest $request)
    {
        $element = new Biomaterial;
        $element->name = $request->input('name');
        $element->save();
        return response()->view('admin.biomaterial.ajax', ['element' => $element, 'ajax' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param Biomaterial $biomaterial
     * @param int $id
     * @return Response
     */
    public function show(Biomaterial $biomaterial)
    {
        return response()->view('admin.biomaterial.ajax', ['element' => $biomaterial, 'ajax' => 'show']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Biomaterial $biomaterial
     * @return Response
     */
    public function edit(Biomaterial $biomaterial)
    {
        return response()->view('admin.biomaterial.ajax', ['element' => $biomaterial, 'ajax' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBiomaterialRequest $request
     * @param Biomaterial $biomaterial
     * @return Response
     */
    public function update(UpdateBiomaterialRequest $request, Biomaterial $biomaterial)
    {
        $biomaterial->name = $request->input('name');
        $biomaterial->save();
        return response()->view('admin.biomaterial.ajax', ['element' => $biomaterial, 'ajax' => 'item']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Biomaterial $biomaterial
     * @return Response
     */
    public function destroy(Biomaterial $biomaterial)
    {
        $biomaterial->delete();
    }
}
