<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderFormRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public $pageName = 'sliders';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entities = Slider::all();
        return view('admin.slider.index', [
            'pageName' => $this->pageName,
            'entities' => $entities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create', [
            'pageName' => $this->pageName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderFormRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $uploadPath = 'uploads/slider/';

            $file = $request->image;

            $filename = time() . '.' . $file->extension();

            $file->move(public_path($uploadPath), $filename);
            $img = $uploadPath . $filename;
            $validatedData['image'] = $img;
        }

        $validatedData['status'] = $request->status == true ? '1' : '0';
        Slider::create($validatedData);

        return redirect()->route('sliders.index')->with('message', 'Slider Added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', [
            'entity' => $slider,
            'pageName' => $this->pageName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(SliderFormRequest $request, Slider $slider)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $uploadPath = 'uploads/slider/';

            $destination = $slider->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }


            $file = $request->image;
            $filename = time() . '.' . $file->extension();

            $file->move(public_path($uploadPath), $filename);
            $img = $uploadPath . $filename;
            $validatedData['image'] = $img;
        } else {
            $validatedData['image'] = $validatedData['image'] ?? $slider->image;
        }

        $validatedData['status'] = $request->status == true ? '1' : '0';
        Slider::where('id', $slider->id)->update($validatedData);

        return redirect()->route('sliders.index')->with('message', 'Slider Added successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        if ($slider->count() > 0) {
            $destination = $slider->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $slider->delete();
            return redirect()->route('sliders.index')->with('message', 'Slider deleted successfully');
        }
    }
}
