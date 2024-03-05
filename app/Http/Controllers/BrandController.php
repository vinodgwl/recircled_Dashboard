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

    public function create()
    {
        // Return a view for creating a new brand
        return view('brands.create');   
    }

    public function store(Request $request)
    {
         // Ensure the existence of the brands directory inside public
        $brandsDirectory = public_path('images/brands');
        if (!File::exists($brandsDirectory)) {
            File::makeDirectory($brandsDirectory, 0777, true);
        }
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            // 'contact_person' => 'nullable|string|max:255',
            // 'email' => 'nullable|email|max:255',
            // 'phone_number' => 'nullable|string|max:20',
            // 'address' => 'nullable|string|max:255',
            // 'city' => 'nullable|string|max:100',
            // 'state' => 'nullable|string|max:100',
            // 'have_sub_brands' => 'boolean',
            // 'parent_categories' => 'nullable|string',
            // 'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Add validation rules for other fields if needed
        ]);
        // Create a new brand instance
        $brand = new Brand();
        // $brand->name = $request->name;
        // $brand->contact_person = $request->contact_person;
        $takeback = $request->input('takeback_type', []);
        $preferred_shipping = $request->input('preferred_shipping', []);
        $parent_categories = $request->input('parent_categories', []);

        // $serializedValues = json_encode($takeback);
        // echo $serializedValues;
        
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
        // other fields
    ]);
        // $brand->save();

        // Redirect back to the index page with a success message
        // return redirect()->route('brands.create')->with('success', 'Brand created successfully!');
        return redirect()->back()->with('success', 'Brand created successfully!');
    }

    // Add other controller methods as needed (e.g., show, edit, update, delete)
}
