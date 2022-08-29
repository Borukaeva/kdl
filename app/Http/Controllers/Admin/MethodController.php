<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMethodRequest;
use App\Http\Requests\Admin\UpdateMethodRequest;
use App\Models\Method;

class MethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $elements = Method::query()->orderByDesc('id')->paginate(50)->withPath(route('method.index'));
        return response()->view('admin.method.index', ['elements' => $elements]);
    }

    public function listAjax()
    {
        $elements = Method::query()->orderByDesc('id')->paginate(50)->withPath(route('method.index'));
        return response()->view('admin.method.ajax', ['elements' => $elements, 'ajax' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.method.ajax', ['ajax' => 'add']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreMethodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMethodRequest $request)
    {
        $element = new Method;
        $element->name = $request->input('name');
        $element->template = $request->input('template');
        $element->save();
        return response()->view('admin.method.ajax', ['element' => $element, 'ajax' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function show(Method $method)
    {
        return response()->view('admin.method.ajax', ['element' => $method, 'ajax' => 'show']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function edit(Method $method)
    {
        return response()->view('admin.method.ajax', ['element' => $method, 'ajax' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateMethodRequest  $request
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMethodRequest $request, Method $method)
    {
        $method->name = $request->input('name');
        $method->template = $request->input('template');
        $method->save();
        return response()->view('admin.method.ajax', ['element' => $method, 'ajax' => 'show']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function destroy(Method $method)
    {
        $method->delete();
    }
}
