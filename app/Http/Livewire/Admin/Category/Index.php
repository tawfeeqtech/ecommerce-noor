<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithPagination;


class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $category_id;

    public function deleteCategory($category_id)
    {
        $this->category_id = $category_id;
    }

    public function destroyCategory()
    {
        $category = Category::find($this->category_id);

        $path = public_path('images/category/') . $category->image;

        if(File::exists($path)){
            File::delete($path);
        }
        $category->delete();

        session()->flash('message','Category Deleted');

        $this->dispatchBrowserEvent('close-modal');
    }


    public function render()
    {
        $entities = Category::latest()->paginate(5);
        return view('livewire.admin.category.index', compact('entities'));
    }
}
