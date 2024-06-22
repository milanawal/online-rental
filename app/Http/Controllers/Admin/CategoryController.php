<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Flasher\Laravel\Facade\Flasher;


class CategoryController extends Controller
{
    public function index()
    {
        // Get All locations order by id decending
        $categories = Category::orderBy('id','desc')->paginate(5);
        return view('dashboards.admin.Category.index')->with('categories', $categories);
    }


    public function create()
    {
        return view('dashboards.admin.Category.create');
    }


    public function store(Request $request)
    {
        $request->validate([
          'name'  => ['required', 'max:255']
        ]);

        $data = $request->only('name');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['status'] = 1;

        Category::create($data);

        // Flasher::addSuccess('Category Added');  // Flasher

        return redirect()->route('admin-category.index')->with('status','Category Data Added Successfully'); // Redirect with success message
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        // Get location by id
       $category = Category::findorFail($id);
       return view('dashboards.admin.Category.edit')->with('category', $category);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => ['required', 'max:255']
        ]);

        Category::findorFail($id)->update($request->only('name'));

        // Flasher::addSuccess('Category Updated');   // Flasher

        return redirect()->route('admin-category.index');     // Redirect with success message
    }


    public function destroy($id)
    {
        Category::findorFail($id)->delete();

        Flasher::addSuccess('Category Removed');    // Flasher

        return redirect()->back();   // Redirect with success message
    }

    public function deleteCategory(Request $request, $id)
    {
        $Category=Category::find($id);
 
        $Category->status = 2;

        //Status 1 is active user
        // Status 2 is the user present in the recycle bin (inactive_User)
        $Category->update();
        return redirect()->back()->with('status', 'Category Moved to Recycle Bin');

   
    }
}
