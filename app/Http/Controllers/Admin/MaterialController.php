<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImportMaterial;
use App\Models\Product;
use App\Models\ProductDetail;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;


class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $importmaterial;
    protected $product;
    public function __construct(ImportMaterial $importmaterial,Product $product)
    {
        $this->importmaterial = $importmaterial;
        $this->product = $product;
    }
    public function index()
    {
        $importMaterials =  $this->importmaterial->latest('id')->paginate(5);
        return view('admin.materials.index', compact('importMaterials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = $this->product->get(['id','name']);
        return view('admin.materials.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'product_id' => 'required',
        //     'import_quantity' => 'required|numeric',
        //     'import_price' => 'required|numeric',
        // ]);
   
        $validator = FacadesValidator::make($request->all(), [
            'import_quantity' => 'required|numeric',
        ]);
        // Lấy tổng số lượng từ bảng product_detail
        $validator->after(function ($validator) use ($request) {
            $productId = $request->product_id;
            $totalQuantity = ProductDetail::where('product_id', $productId)->sum('quantity');
            if ($request->import_quantity != $totalQuantity) {
                $validator->errors()->add('import_quantity', 'Số lượng nhập vào không khớp với tổng số lượng sản phẩm.');
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else
        {
            ImportMaterial::create([
                'product_id' => $request->product_id,
                'import_quantity' => $request->import_quantity,
                'import_price' => $request->import_price,
                'import_date' => $request->import_date
            ]);
        return redirect()->route('materials.index')->with(['message' => 'Tạo sản phẩm nhập vào thành công']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $importMaterial = $this->importmaterial->with(['product'])->findOrFail($id);
        $products = Product::all();
       
        return view('admin.materials.edit', compact('importMaterial','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = FacadesValidator::make($request->all(), [
            'import_quantity' => 'required|numeric',
        ]);
        // Lấy tổng số lượng từ bảng product_detail
        
        $validator->after(function ($validator) use ($request) {
            $productId = $request->product_id;
            $totalQuantity = ProductDetail::where('product_id', $productId)->sum('quantity');
            if ($request->import_quantity != $totalQuantity) {
                $validator->errors()->add('import_quantity', 'Số lượng nhập vào không khớp với tổng số lượng sản phẩm.');
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
        $importMaterial = ImportMaterial::findOrFail($id);
        $importMaterial->product_id = $request->input('product_id');
        $importMaterial->import_price = $request->input('import_price');
        $importMaterial->import_quantity = $request->input('import_quantity');
        $importMaterial->import_date = $request->input('import_date');
        
        $importMaterial->save();
        return redirect()->route('materials.index')->with(['message' => 'Cập nhật sản phẩm nhập vào thành công']);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $importMaterial = $this->importmaterial->findOrFail($id);
        $importMaterial->delete();

        return redirect()->route('materials.index')->with(['message' => 'Xóa thành công']);
    }
}
