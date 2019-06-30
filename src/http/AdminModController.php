<?php


namespace ItVision\ModManager\http\admin;

use Illuminate\Http\Request;
use ItVision\ModManager\models\ModModel;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Models\Custom\Category;
use Pterodactyl\Contracts\Repository\NestRepositoryInterface;

class AdminModController extends Controller
{

    protected $alert;
    protected $nestRepository;

    /**
     * ModController constructor.
     * @param AlertsMessageBag $alert
     * @param NestRepositoryInterface $nestRepository
     */
    public function __construct(AlertsMessageBag $alert, NestRepositoryInterface $nestRepository) {

        $this->alert = $alert;
        $this->nestRepository = $nestRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mods = Mod::all();

        return view('admin.modmanager.index', compact('mods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.modmanager.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'version' => 'required',
            'link' => 'required',
            'path' => 'required',
            'category_id' => 'exists:categories,id',
            'author' => 'required',
            'game' => 'required',
            'foldername' => 'required'
        ]);


        ModModel::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'version' => $request->input('version'),
            'link' => $request->input('link'),
            'path' => $request->input('path'),
            'category_id' => $request->input('category_id'),
            'game' => $request->input('game'),
            'author' => $request->input('author'),
            'foldername' => $request->input('foldername')
        ]);

        return redirect()->route('mod.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Pterodactyl\models\custom\mod $mod
     * @return \Illuminate\Http\Response
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function show(ModModel $mod)
    {

        $nests = $this->nestRepository->getWithCounts();
        return view('admin.modmanager.view', compact('mod', 'nests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Pterodactyl\models\custom\mod  $mod
     * @return \Illuminate\Http\Response
     */
    public function edit(ModModel $mod)
    {
        $categories = Category::all();
        return view('admin.modmanager.edit', compact('mod', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Pterodactyl\models\custom\mod  $mod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModModel $mod)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'version' => 'required',
            'link' => 'required',
            'path' => 'required',
            'category_id' => 'exists:categories,id',
            'author' => 'required',
            'game' => 'required',
            'foldername' => 'required'
        ]);


        $mod->name = $request->input('name');
        $mod->description = $request->input('description');
        $mod->version = $request->input('version');
        $mod->link = $request->input('link');
        $mod->path = $request->input('path');

        $mod->category_id = $request->input('category_id');

        $mod->game = $request->input('game');
        $mod->author = $request->input('author');
        $mod->foldername = $request->input('foldername');

        $mod->update();


        return redirect()->route('mod.show', $mod);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Pterodactyl\models\custom\mod $mod
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ModModel $mod)
    {
        $mod->delete();
        return  redirect()->route('mod.index');
    }

}
