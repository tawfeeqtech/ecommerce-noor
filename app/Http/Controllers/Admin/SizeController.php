<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SizeFormRequest;
use App\Models\Size;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SizeController extends Controller
{
    public $pageName = 'sizes';

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $entities = Size::all();
        return view('admin.size.index', [
            'pageName' => $this->pageName,
            'entities' => $entities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.size.create', [
            'pageName' => $this->pageName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SizeFormRequest $request
     * @return RedirectResponse
     */
    public function store(SizeFormRequest $request)
    {
        // $validatedData = $request->validated();
        // $category = new Size;
        // $category->name = $validatedData['name'];
        // $category->code = $validatedData['code'];
        // $category->status =  $request->status == true ? '1' : '0';
        // $category->save();


        $validatedData = $request->validated();
        $validatedData['status'] = $request->status == true ? '1' : '0';
        Size::create($validatedData);

        return redirect()->route('sizes.index')->with('message', 'Size Added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Size $size
     * @return Factory|View
     */
    public function edit(Size $size)
    {
        return view('admin.size.edit', [
            'entity' => $size,
            'pageName' => $this->pageName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SizeFormRequest $request
     * @param $size_id
     * @return RedirectResponse
     */
    public function update(SizeFormRequest $request, $size_id)
    {
        $validatedData = $request->validated();
        $validatedData['status'] = $request->status == true ? '1' : '0';
        Size::find($size_id)->update($validatedData);

        return redirect()->route('sizes.index')->with('message', 'Size Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $size_id
     * @return RedirectResponse
     */
    public function destroy($size_id)
    {
        $size = Size::findOrFail($size_id);
        $size->delete();
        return redirect()->route('sizes.index')->with('message', 'Size deleted successfully');
    }
}
