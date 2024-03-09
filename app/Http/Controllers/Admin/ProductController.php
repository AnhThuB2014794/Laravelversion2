<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $category;
    protected $product;
    protected $productDetail;

    public function __construct(Product $product, Category $category, ProductDetail $productDetail){
        $this->product = $product;
        $this->category = $category;
        $this->productDetail = $productDetail;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->product->latest('id')->paginate(5);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->category->get(['id', 'name']);
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $dataCreate = $request->all();
        // $product = Product::create($dataCreate);

        $product = Product::create($dataCreate);
        $dataCreate['image'] = $this->product->saveImage($request);

        $product->images()->create(['url' => $dataCreate['image']]);
        
        // $sizeArray = [];
        // foreach($sizes as $size){
        //     $sizeArray[] = ['size' => $size->size, 'quantity' => $size->quantity, 'product_id' => $product->id];
        //     // $sizeArray[] = ['size' => $size[size], 'quantity' => $size[quantity], 'product_id' => $product->id];
        // }
        // // $this->productDetail->insert($sizeArray);
        //  $product->details()->insert($sizeArray);
         $validatedData = $request->validate([
            
           
            'sizes' => 'required|string',
            'quantities' => 'required|string',
            
        ]);

        // Process sizes and quantities
        $sizes = explode(',', $validatedData['sizes']);
        $quantities = explode(',', $validatedData['quantities']);

        // Create product details for each size and quantity
        foreach ($sizes as $key => $size) {
            $product->details()->create([
                'size' => trim($size),
                'quantity' => trim($quantities[$key]),
            ]);
        }
        $product->assignCategory($dataCreate['category_ids']);
        return redirect()->route('products.index')->with(['message' => 'Tạo sản phẩm thành công']);

    }
    // public function store(Request $request)
    // {
    //     $dataCreate = $request->all();
    //     $product = Product::create($dataCreate);
    //     $dataCreate['image'] = $this->product->saveImage($request);
    //     $product->images()->create(['url' => $dataCreate['image']]);
    //     // Validate the form data
    //     $validatedData = $request->validate([
            
           
    //         'sizes' => 'required|string',
    //         'quantities' => 'required|string',
            
    //     ]);

    //     // Create the product
        

    //     // Process sizes and quantities
    //     $sizes = explode(',', $validatedData['sizes']);
    //     $quantities = explode(',', $validatedData['quantities']);

    //     // Create product details for each size and quantity
    //     foreach ($sizes as $key => $size) {
    //         $product->details()->create([
    //             'size' => trim($size),
    //             'quantity' => trim($quantities[$key]),
    //         ]);
    //     }
    //     $product->assignCategory($dataCreate['category_ids']);

    //     return redirect()->route('products.index')->with('success','Thêm sản phẩm thành công');
    // }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->product->with(['details', 'categories'])->findOrFail($id);
        
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->product->with(['details', 'categories'])->findOrFail($id);
        $categories = $this->category->get(['id', 'name']);
         $sizes = $product->details->pluck('size')->toArray();
        $quantities = $product->details->pluck('quantity')->toArray();
        return view('admin.products.edit', compact('categories', 'product','sizes', 'quantities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $dataUpdate = $request->except('sizes');
         $validatedData = $request->validate([
            'sizes' => 'required|string',
            'quantities' => 'required|string',
        ]);
        $product = $this->product->findOrFail($id);
        $currentImage = $product->images ? $product->images->first()->url : '';
        $dataUpdate['image'] = $this->product->updateImage($request, $currentImage);
        $product->images()->create(['url' => $dataUpdate['image']]);
        $product->update($dataUpdate);

        $product->assignCategory($dataUpdate['category_ids']);
        $sizes = explode(',', $validatedData['sizes']);
        $quantities = explode(',', $validatedData['quantities']);
        $product->details()->delete();
        foreach ($sizes as $key => $size) {
            $product->details()->create([
                'size' => trim($size),
                'quantity' => trim($quantities[$key]),
            ]);
        }
        return redirect()->route('products.index')->with(['message' => 'Cập nhật sản phẩm thành công']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->product->findOrFail($id);
        $product->delete();
        $product->details()->delete();
        $imageName = $product->images->count() > 0 ? $product->images->first()->url : '';
        $this->product->deleteImage($imageName);
        return redirect()->route('products.index')->with(['message' => 'Xoá sản phẩm thành công']);
    }
}