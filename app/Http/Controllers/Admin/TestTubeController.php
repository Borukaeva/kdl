<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTestTubeRequest;
use App\Http\Requests\Admin\UpdateTestTubeRequest;
use App\Models\TestTube;
use Illuminate\Http\Request;

class TestTubeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $elements = TestTube::query()->orderByDesc('id')->paginate(50)->withPath(route('test_tubes.index'));
        return response()->view('admin.test_tube.index', ['elements' => $elements]);
    }

    public function listAjax()
    {
        $elements = TestTube::query()->orderByDesc('id')->paginate(50)->withPath(route('test_tubes.index'));
        return response()->view('admin.test_tube.ajax', ['elements' => $elements, 'ajax' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->view('admin.test_tube.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreTestTubeRequest $request)
    {
        TestTube::create($request->all());
        $element = new TestTube;
        $element->name = $request->input('name');
        $element->save();
        if ($request->hasfile('img')) {
            $img = $request->file('img');
            $path = $img->storeAs('img/testtubes', 'testtube_' . $element->id . '.' . $img->getClientOriginalExtension(), 'public');
            $element->img = $path;
        }
        $element->save();
        return response()->view('admin.test_tube.ajax', ['element' => $element, 'ajax' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param TestTube $test_tube
     * @return Response
     */
    public function show(TestTube $test_tube)
    {
        return response()->view('admin.test_tube.ajax', ['element' => $test_tube, 'ajax' => 'show']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TestTube $test_tube
     * @return Response
     */
    public function edit(TestTube $test_tube)
    {
        return response()->view('admin.test_tube.ajax', ['element' => $test_tube, 'ajax' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTestTubeRequest  $request
     * @param TestTube $test_tube
     * @return Response
     */
    public function update(UpdateTestTubeRequest $request, TestTube $test_tube)
    {
        $test_tube->name = $request->input('name');
        $test_tube->save();
        if ($request->hasfile('img')) {
            $img = $request->file('img');
            $path = $img->storeAs('img/testtubes', 'testtube_' . $test_tube->id . '.' . $img->getClientOriginalExtension(), 'public');
            $test_tube->img = $path;
        }
        $test_tube->save();
        return response()->view('admin.test_tube.ajax', ['element' => $test_tube, 'ajax' => 'item']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TestTube $test_tube
     * @return Response
     */
    public function destroy(TestTube $test_tube)
    {
        $test_tube->delete();
    }
}
