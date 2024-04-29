<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function index()
    {
        // Fetch all brands from the database
        $brands = Brand::all();
        // Return a view and pass the fetched brands to it
        return view('brands.index', ['brands' => $brands]);
    }

    public function create(Request $request)
    {
        $lang = $request->query('lang', 'en');
        app()->setLocale($lang);
        return view('brands.create');   
    }

    public function store(Request $request)
    {
        $brandsDirectory = public_path('images/brands');
        if (!File::exists($brandsDirectory)) {
            File::makeDirectory($brandsDirectory, 0777, true);
        }
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        // Create a new brand instance
        $brand = new Brand();
        $takeback = $request->input('takeback_type', []);
        $preferred_shipping = $request->input('preferred_shipping', []);
        $parent_categories = $request->input('parent_categories', []);
        
        if ($request->hasFile('logo_image')) {
            $image = $request->file('logo_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move($brandsDirectory, $imageName); // Move the image to the brands directory
            $brand->logo_image = 'images/brands/' . $imageName;
        }

        // Save the brand to the database
        $brand::create([
        'takeback_type' => json_encode($takeback),
        'preferred_shipping' => json_encode($preferred_shipping),
        'parent_categories' => json_encode($parent_categories),
        'name' => $request->name,
        'contact_person' => $request->contact_person,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'address' => $request->address,
        'city' => $request->city,
        'state' => $request->state,
        'have_sub_brands' => $request->have_sub_brands?$request->have_sub_brands:0,
        'logo_image' => 'images/brands/' . $imageName
    ]);
        // Redirect back to the index page with a success message
        return redirect()->back()->with('success', 'Brand created successfully!');
    }
}
