<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Models\Brand;
use App\Models\ProductSize;
use App\Models\Size;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

// use Livewire\WithPagination;

class ProductController extends Controller
{
    // use WithPagination;
    // protected $paginationTheme = 'bootstrap';

    public $pageName = 'product';

    function get_all_category()
    {
        return Category::all();
    }

    function get_all_brand()
    {
        return Brand::all();
    }

    function get_all_color()
    {
        return Color::all();
    }

    function get_all_color_where_status_0()
    {
        return Color::where('status', '0')->get();
    }

    function get_all_size_where_status_0()
    {
        return Size::where('status', '0')->get();
    }


    public function index()
    {
        $entities = Product::all();
        return view('admin.product.index', [
            'pageName' => $this->pageName,
            'entities' => $entities
        ]);
    }

    public function create()
    {
        $categories = $this->get_all_category();
//        $brands = $this->get_all_brand();
        $colors = $this->get_all_color_where_status_0();
        $sizes = $this->get_all_size_where_status_0();
        return view('admin.product.create', [
            'categories' => $categories,
//            'brands' => $brands,
            'colors' => $colors,
            'sizes' => $sizes,
            'pageName' => $this->pageName
        ]);
    }

    public function store(ProductFormRequest $request)
    {
        $validatedData = $request->validated();
        $category_id = $validatedData['category_id'];
        $category = Category::findOrFail($category_id);

        $product = $category->products()->create([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['slug']),
//            'brand' => $validatedData['brand'],
            'small_description' => $validatedData['small_description'],
            'description' => $validatedData['description'],
            'original_price' => $validatedData['original_price'],
            'selling_price' => $validatedData['selling_price'],
            'quantity' => $validatedData['quantity'],
            'trending' => $request->trending == true ? '1' : '0',
            'status' => $request->status == true ? '1' : '0',
            'meta_title' => $validatedData['meta_title'],
            'meta_keyword' => $validatedData['meta_keyword'],
            'meta_description' => $validatedData['meta_description'],
        ]);

        if ($request->hasFile('image')) {
            $uploadPath = 'uploads/products/';
            $i = 1;
            $file = $request->image;

            foreach ($file as $imageFile) {
                $filename = time() . $i++ . '.' . $imageFile->extension();
                $imageFile->move(public_path($uploadPath), $filename);
                $finalImagePathName = $uploadPath . $filename;

                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalImagePathName,
                ]);
            }
        }

        if ($request->colors) {
            foreach ($request->colors as $key => $color) {
                $product->productColors()->create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                    'quantity' => $request->colorquantity[$key] ?? 0
                ]);
            }
        }

        if ($request->sizes) {
            foreach ($request->sizes as $key => $size) {
                $product->productSizes()->create([
                    'product_id' => $product->id,
                    'size_id' => $size,
                    'quantity' => $request->sizequantity[$key] ?? 0
                ]);
            }
        }

        return redirect()->route('products.index')->with('message', 'product has been created successfully');
    }

    public function edit(int $product_id)
    {

        $product = Product::findOrFail($product_id);
        $product_color = $product->productColors->pluck('color_id')->toArray();
        $product_size = $product->productSizes->pluck('size_id')->toArray();
        $colors = Color::whereNotIn('id', $product_color)->get();
        $sizes = Size::whereNotIn('id', $product_size)->get();

        $categories = $this->get_all_category();
//        $brands = $this->get_all_brand();

        return view('admin.product.edit', [
            'entity' => $product,
            'colors' => $colors,
            'sizes' => $sizes,
            'pageName' => $this->pageName,
            'categories' => $categories,
//            'brands' => $brands,
        ]);
    }

    public function update(ProductFormRequest $request, int $product_id)
    {
        $validatedData = $request->validated();
        $product = Category::findOrFail($validatedData['category_id'])
            ->products()->where('id', $product_id)->first();

        if ($product) {
            $product->update([
                'category_id' => $validatedData['category_id'],
                'name' => $validatedData['name'],
                'slug' => Str::slug($validatedData['slug']),
//                'brand' => $validatedData['brand'],
                'small_description' => $validatedData['small_description'],
                'description' => $validatedData['description'],
                'original_price' => $validatedData['original_price'],
                'selling_price' => $validatedData['selling_price'],
                'quantity' => $validatedData['quantity'],
                'trending' => $request->trending == true ? '1' : '0',
                'status' => $request->status == true ? '1' : '0',
                'meta_title' => $validatedData['meta_title'],
                'meta_keyword' => $validatedData['meta_keyword'],
                'meta_description' => $validatedData['meta_description'],
            ]);

            if ($request->hasFile('image')) {
                $uploadPath = 'uploads/products/';
                $i = 1;
                $file = $request->image;

                foreach ($file as $imageFile) {
                    $filename = time() . $i++ . '.' . $imageFile->extension();
                    $imageFile->move(public_path($uploadPath), $filename);
                    $finalImagePathName = $uploadPath . $filename;

                    $product->productImages()->create([
                        'product_id' => $product->id,
                        'image' => $finalImagePathName,
                    ]);
                }
            }

            if ($request->colors) {
                foreach ($request->colors as $key => $color) {
                    $product->productColors()->create([
                        'product_id' => $product->id,
                        'color_id' => $color,
                        'quantity' => $request->colorquantity[$key] ?? 0
                    ]);
                }
            }

            if ($request->sizes) {
                foreach ($request->sizes as $key => $size) {
                    $product->productSizes()->create([
                        'product_id' => $product->id,
                        'size_id' => $size,
                        'quantity' => $request->sizequantity[$key] ?? 0
                    ]);
                }
            }

            return redirect()->route('products.index')->with('message', 'product has been Updated successfully');
        } else {
            return redirect()->route('products.index')->with('message', 'No Such Product Id Found');
        }
    }

    public function destroyImage(int $product_image_id)
    {
        $productImage = ProductImage::findOrFail($product_image_id);
        if (File::exists($productImage->image)) {
            File::delete($productImage->image);
        }
        $productImage->delete();
        return redirect()->back()->with('message', 'Product Image Deleted');
    }


    public function destroy(int $product_id)
    {
        $product = Product::findOrFail($product_id);
        if ($product->productImages) {
            foreach ($product->productImages as $myImage) {
                if (File::exists($myImage->image)) {
                    File::delete($myImage->image);
                }
            }
        }

        $product->delete();
        return redirect()->route('products.index')->with('message', 'Product Deleted');
    }

    public function updateProdColorQty(Request $request, $prod_color_id)
    {
        $productColorData = Product::findOrFail($request->product_id)
            ->productColors()->where('id', $prod_color_id)->first();
        $productColorData->update([
            'quantity' => $request->qty
        ]);
        return response()->json(['message' => 'Product Color Qty updated']);
    }

    public function deleteProdColorQty($prod_color_id)
    {
        $prodColor = ProductColor::findOrFail($prod_color_id);
        $prodColor->delete();

        return response()->json(['message' => 'Product Color Deleted']);
    }

    public function updateProdSizeQty(Request $request, $prod_size_id)
    {
        $productSizeData = Product::findOrFail($request->product_id)
            ->productSizes()->where('id', $prod_size_id)->first();
        $productSizeData->update([
            'quantity' => $request->qty
        ]);
        return response()->json(['message' => 'Product Size Qty updated']);
    }

    public function deleteProdSizeQty($prod_size_id)
    {
        $prodSize = ProductSize::findOrFail($prod_size_id);
        $prodSize->delete();

        return response()->json(['message' => 'Product Size Deleted']);
    }
}
