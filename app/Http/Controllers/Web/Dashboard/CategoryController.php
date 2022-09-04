<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Restaurant_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($category) {
                    $btn = '<a  href="' . route('categories.showRestaurants', $category) . '" href="javascript:void(0)" class="btn btn-info btn-sm"><i class="fas fa-building"></i></a>';
                    $btn .= '<a  href="' . route('categories.showProducts', $category) . '" href="javascript:void(0)" class="btn btn-info btn-sm"><i class="fab fa-product-hunt"></i></a>';
                    $btn .= '<a href="' . route('categories.show', $category) . '" href="javascript:void(0)" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>';
                    $btn .= '<a href="' . route('categories.edit', $category) . '" href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
                    $btn .= '
                    <form style="display:inline" action="' . route('categories.destroy', $category->id) . '" method="POST">
                    ' . csrf_field() . '
                    ' . method_field("DELETE") . '
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are You Sure Want to Delete?\')">
                      <i class="fas fa-trash-alt"></i>
                       </button>
                   </form>
                ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Layouts.Layout.Category.index');

    }

    public function create()
    {
        return view('Layouts.Layout.Category.create');

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|unique:categories',
            'description' => 'required|string|min:5',
            'active' => 'required|numeric|in:0,1',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        Category::create($validator->validated());
        return redirect()->route('categories.index');

    }

    public function show(Category $category)
    {
        return view('Layouts.Layout.Category.show', compact('category'));

    }

    public function edit(Category $category)
    {
        return view('Layouts.Layout.Category.edit', compact('category'));

    }

    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|unique:categories,title,' . $category->id,
            'description' => 'required|string|min:5',
            'active' => 'required|numeric|in:0,1',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $category->update($validator->validated());
        return redirect()->route('categories.index');

    }

    public function destroy($id)
    {
        Category::destroy($id);
//category_resturant
        return back()->with('message', 'Restaurant deleted.');
    }

    public function showRestaurants(Request $request, $id)
    {

        $restID = Restaurant_Category::where('category_id', $id)->pluck('restaurant_id');
        $data = Restaurant::whereIn('id', $restID)->get();
        Session::put('Category_Restaurant', $data);
        return redirect()->route('restaurants.index');

    }


    public function showProducts(Request $request, $id)
    {

        $product = Product::where('category_id', $id)->get();
        Session::put('Category_Products', $product);
        return redirect()->route('products.index');

    }

}
