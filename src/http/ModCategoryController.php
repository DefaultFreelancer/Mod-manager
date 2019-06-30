<?php


namespace ItVision\ModManager\http\admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ItVision\ModManager\models\ModCategoryModel;
use Pterodactyl\Http\Controllers\Controller;

class ModCategoryController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ModCategoryModel::all();
        return view('modManager.categoryIndex', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modManager.categoryCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'bail|required|min:5|max:255',
            'description' => 'bail|required|min:5|max:255',
        ]);

        ModCategoryModel::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect()->route('modManager.categoryIndex');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(ModCategoryModel $category)
    {
        return view('modManager.categoryEdit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModCategoryModel $category)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'bail|required|min:5|max:255',
            'description' => 'bail|required|min:5|max:255',
        ]);

        $category->title = $request->title;
        $category->description = $request->description;
        $category->update();
        return redirect()->route('modManager.categoryIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ModCategoryModel $category)
    {
        $category->delete();

        return back();
    }


}
