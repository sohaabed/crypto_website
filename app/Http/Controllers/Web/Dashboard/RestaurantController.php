<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Restaurant_Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            if (Session::exists('Category_Restaurant')) {
                $data = Session::get('Category_Restaurant');


            } else {

                $data = Restaurant::all();
            }
            Session::forget('Category_Restaurant');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('logo', function ($rest) {
                    $url = asset($rest->logo);
                    return '<img src="' . $url . '" border="0" width="100" align="center" class="rounded" />';
                })
                ->addColumn('action', function ($rest) {
                    $btn = '<a  href="' . route('restaurants.showProduct', $rest) . '" href="javascript:void(0)" class="btn btn-info btn-sm"><i class="fab fa-product-hunt"></i></a>';
                    $btn .= '<a  href="' . route('restaurants.showOwner', $rest) . '" href="javascript:void(0)" class="btn btn-info btn-sm"><i class="fas fa-user"></i></a>';
                    $btn .= '<a href="' . route('restaurants.show', $rest) . '" href="javascript:void(0)" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>';
                    $btn .= '<a href="' . route('restaurants.edit', $rest) . '" href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
                    $btn .= '
                    <form style="display:inline" action="' . route('restaurants.destroy', $rest->id) . '" method="POST">
                    ' . csrf_field() . '
                    ' . method_field("DELETE") . '
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are You Sure Want to Delete?\')">
                      <i class="fas fa-trash-alt"></i>
                       </button>
                   </form>
                ';
                    return $btn;
                })
                ->rawColumns(['logo', 'action'])
                ->make(true);
        }
        return view('Layouts.Layout.Restaurant.index');

    }

    public function create()
    {

        $allUsers = User::whereNotIn('name', ['admin'])->select('id', 'name')->get();
        $allCategory = Category::select('id', 'title', 'description')->get();
        return view('Layouts.Layout.Restaurant.create')->with(compact('allCategory', 'allUsers'));

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|String|min:4',
            'file' => 'required|mimes:png,jpg,jpeg,gif',
            'description' => 'required|string|min:10',
            'phoneNumber' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'start_at' => 'required|date_format:H:i',
            'end_at' => 'required|date_format:H:i',
//            'address' => 'required|String|min:5',
            'latitude' => 'required|numeric|max:90|min:-90',
            'longitude' => 'required|numeric|max:180|min:-180',
            'category_id' => 'required|array|min:1|exists:categories,id',
            'owner_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        /*
              if (isset($request['lat']) && isset($request['lng'])) {
                    $lat = $request['latitude'];
                    $long = $request['longitude'];
                    $address = File::get("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&key=AIzaSyCwhQwIluhpiVtcTppI7o-iBWCz_FnmRpc");
                    $json_data = json_decode($address);
                    $full_address = $json_data->results[0]->formatted_address;
                }*/
        $path = "";
        if ($request->hasFile('file')) {
            $logo = $request->file;
            $fileName = date('Y-m-d') . $request->name . '-' . $logo->getClientOriginalName();

            $path = $request->file->storeAs('restaurant_image', $fileName, 'public');

        }


        $restaurant = Restaurant::create(array_merge(
            $validator->validated(),
            [
                'logo' => 'storage/' . $path,
                'address' => 'null',
                'rating' => 0.0,
                'start_at' => Carbon::parse($request->start_at)->format('h:i A'),
                'end_at' => Carbon::parse($request->end_at)->format('h:i A'),
            ]
        ));

        foreach ($request['category_id'] as $item) {


            $data = Restaurant_Category::create(array_merge(
                [
                    'restaurant_id' => $restaurant['id'],
                    'category_id' => $item,

                ]
            ));
        }

        return redirect()->route('restaurants.index')->with('success', 'Restaurant created successfully');;

    }

    public function show(Restaurant $restaurant)
    {
        $category = Restaurant_Category::where('restaurant_id', $restaurant->id)->pluck('category_id');
        $allCategory = Category::whereIn('id', $category)->select('id', 'title', 'description')->get();

        return view('Layouts.Layout.Restaurant.show', compact('restaurant'))->with('allCategory', $allCategory);
    }

    public function edit(Restaurant $restaurant)
    {
        $allUsers = User::whereNotIn('name', ['admin'])->select('id', 'name')->get();
        $Rest_Category = Restaurant_Category::where('restaurant_id', $restaurant->id)->pluck('category_id');
        $allCategory = Category::whereNotIn('id', $Rest_Category)->select('id', 'title', 'description')->get();

        return view('Layouts.Layout.Restaurant.edit')->with(compact('allCategory', 'allUsers', 'restaurant', 'Rest_Category'));

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|String|min:4',
            'file' => 'required|mimes:png,jpg,jpeg,gif',
            'description' => 'required|string|min:10',
            'phoneNumber' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'start_at' => 'required|date_format:H:i',
            'end_at' => 'required|date_format:H:i',
//            'address' => 'required|String|min:5',
            'latitude' => 'required|numeric|max:90|min:-90',
            'longitude' => 'required|numeric|max:180|min:-180',
            'category_id' => 'required|array|min:1|exists:categories,id',
            'owner_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $rest = Restaurant::find($id);
        if ($rest) {

            if ($request->hasFile('logo')) {
                if ($rest->logo) {
                    $old_path = public_path($rest->logo);
                    if (File::exists($old_path)) {
                        File::delete($old_path);
                    }
                }
                $logo = $request->logo;
                $fileName = date('Y-m-d') . $rest->name . '-' . $logo->getClientOriginalName();
                $path = $request->logo->storeAs('restaurant_image', $fileName, 'public');
                $rest['logo'] = 'storage/' . $path;
            } else {
                $rest['logo'] = $rest->logo;
            }
///edit category-restaurant table
            $data = Restaurant_Category::where(['restaurant_id' => $rest['id']])->first()->update(['category_id' => $request->category_id]);

            $rest->update(
                $request->except(['category_id']),
                [
                    'logo' => 'storage/' . $path,
                    'address' => 'null',
                    'rating' => 0.0,
                    'start_at' => Carbon::parse($request->start_at)->format('h:i A'),
                    'end_at' => Carbon::parse($request->end_at)->format('h:i A'),
                ]
            );
        }
        return redirect()->route('restaurants.index')->with('success', 'Restaurant updated successfully');;

    }

    public function destroy($id)
    {

        Restaurant::destroy($id);

        return back()->with('message', 'Restaurant deleted.');

    }

    public function showProducts(Restaurant $restaurant)
    {
        $product = Product::where('restaurant_id', $restaurant->id)->get();
        return view('Layouts.Layout.Product.index', compact('product'));

    }

    public function showOwner(Restaurant $restaurant)
    {
        $user = User::find($restaurant->owner_id);
        return view('Layouts.Admin.users.show', compact('user'));
    }


}
