<?php


namespace ItVision\ModManager\http;


use Illuminate\Http\Request;
use ItVision\ModManager\models\ModModel;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Models\Custom\Category;
use Pterodactyl\Repositories\Daemon\ServerRepository;
use Pterodactyl\Services\Servers\ModInstallService;
use Pterodactyl\Services\Servers\ModRemoveService;
use Pterodactyl\Traits\Controllers\JavascriptInjection;

class ModController extends Controller
{
    use JavascriptInjection;
    protected $alert;
    protected $ModInstall;
    protected $ModRemove;

    /**
     * ModController constructor.
     * @param AlertsMessageBag $alert
     * @param ServerRepository $serverRepository
     * @param ModInstallService $ModInstall
     * @param ModRemoveService $ModRemove
     */
    public function __construct(
        AlertsMessageBag $alert,
        ServerRepository $serverRepository,
        ModInstallService $ModInstall,
        ModRemoveService $ModRemove
    )
    {
        $this->serverRepository = $serverRepository;
        $this->alert = $alert;
        $this->ModInstall = $ModInstall;
        $this->ModRemove = $ModRemove;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $server = $request->attributes->get('server');
//        $this->authorize('view-modmanager', $server);
        $this->setRequest($request)->injectJavascript();

        $categories = Category::all();


        return view('modManager.index', compact('categories'));
    }

    /**
     * Install Mod.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Pterodactyl\Exceptions\Http\Connection\DaemonConnectionException
     */
    public function install(Request $request, $server, ModModel $mod) {

        $server = $request->attributes->get('server');
        $this->ModInstall->install($server, $mod);
        $this->alert->success('Mod was installed successfully.')->flash();

        return redirect()->route('modManager.index', $server->uuidShort)->with('installed', 'Mod Installed');
    }

    /**
     * Remove Mod.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Pterodactyl\Exceptions\Http\Connection\DaemonConnectionException
     */
    public function remove(Request $request, $server, ModModel $mod) {

        $server = $request->attributes->get('server');
        $this->ModRemove->remove($server, $mod);
        $this->alert->success('Mod was uninstalled successfully.')->flash();

        return redirect()->route('modManager.index', $server->uuidShort)->with('removed', 'Mod Removed');
    }
}
