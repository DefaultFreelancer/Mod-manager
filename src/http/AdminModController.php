<?php


namespace ItVision\ModManager\http\admin;

use Illuminate\Http\Request;
use ItVision\ModManager\models\GameModRelation;
use ItVision\ModManager\models\ModCategoryModel;
use ItVision\ModManager\models\ModModel;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Models\Custom\Category;
use Pterodactyl\Contracts\Repository\NestRepositoryInterface;
use Pterodactyl\Models\Egg;

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
        $mods = ModModel::all();

        return view('modManager::mod.modAdminIndex', compact('mods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ModCategoryModel::all();
        $eggs = Egg::get();

        return view('modManager::mod.modAdminCreate', ['categories' => $categories, 'eggs' => $eggs]);
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
            'category_id' => 'exists:mod_categories,id',
            'author' => 'required',
            'games' => 'required',
            'foldername' => 'required'
        ]);

        $mod = ModModel::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'version' => $request->input('version'),
            'link' => $request->input('link'),
            'path' => $request->input('path'),
            'category_id' => $request->input('category_id'),
            'author' => $request->input('author'),
            'foldername' => $request->input('foldername')
        ]);

        foreach ($request['games'] as $game)
        {
            GameModRelation::create([
                'mod_id' => $mod->id,
                'egg_id' => $game
            ]);
        }

        return redirect('admin/mod');
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
        return view('modManager::mod.modAdminView', compact('mod', 'nests'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Pterodactyl\models\custom\mod  $mod
     * @return \Illuminate\Http\Response
     */
    public function edit(ModModel $mod)
    {
        $categories = ModCategoryModel::all();
        $eggs = Egg::get();
        $relation = GameModRelation::where(['mod_id' => $mod->id])->get();
        $relations = [];
        foreach ($relation as $item)
        {
            array_push($relations, $item->egg_id);
        }

        return view('modManager::mod.modAdminEdit', compact('mod', 'categories','eggs','relations'));
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
            'name'          => 'required',
            'description'   => 'required',
            'version'       => 'required',
            'link'          => 'required',
            'path'          => 'required',
            'category_id'   => 'exists:mod_categories,id',
            'author'        => 'required',
            'games'         => 'required',
            'foldername'    => 'required'
        ]);

        $mod->name = $request->input('name');
        $mod->description = $request->input('description');
        $mod->version = $request->input('version');
        $mod->link = $request->input('link');
        $mod->path = $request->input('path');
        $mod->category_id = $request->input('category_id');
        $mod->author = $request->input('author');
        $mod->foldername = $request->input('foldername');

        $mod->updateRelations($request);
        $mod->update();

        return redirect('admin/mod');
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
        GameModRelation::where(['mod_id' => $mod->id])->delete();
        $mod->delete();
        return  redirect('admin/mod');
    }

}
