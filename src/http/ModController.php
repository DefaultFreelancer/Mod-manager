<?php


namespace ItVision\ModManager\http;


use Illuminate\Http\Request;
use ItVision\ModManager\models\ModCategoryModel;
use ItVision\ModManager\models\ModModel;
use ItVision\ModManager\Services\ModInstallService;
use ItVision\ModManager\Services\ModRemoveService;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Models\Server;
use Pterodactyl\Repositories\Daemon\ServerRepository;
use Pterodactyl\Traits\Controllers\JavascriptInjection;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class ModController extends Controller
{
    use JavascriptInjection;
    protected $alert;
    protected $ModInstall;
    protected $ModRemove;
    protected $config;

    /**
     * ModController constructor.
     * @param ConfigRepository $config
     * @param AlertsMessageBag $alert
     * @param ServerRepository $serverRepository
     * @param ModInstallService $ModInstall
     * @param ModRemoveService $ModRemove
     */
    public function __construct
    (
        ConfigRepository $config,
        AlertsMessageBag $alert,
        ServerRepository $serverRepository,
        ModInstallService $ModInstall,
        ModRemoveService $ModRemove
    )
    {
        $this->config = $config;
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
        $this->setRequest($request)->injectJavascript([
            'server' => [
                'cpu' => $server->cpu,
            ],
            'meta' => [
                'saveFile' => route('server.files.save', $server->uuidShort),
                'csrfToken' => csrf_token(),
            ],
            'config' => [
                'console_count' => $this->config->get('pterodactyl.console.count'),
                'console_freq' => $this->config->get('pterodactyl.console.frequency'),
            ]
        ]);

        $categories = ModCategoryModel::all();
        return view('modManager::client.index', ['categories' => $categories, 'server' => $server, 'node' => $server->node]);
    }

    /**
     * Install Mod.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Pterodactyl\Exceptions\Http\Connection\DaemonConnectionException
     */
    public function install(Request $request, $server, ModModel $mod)
    {
        $server = Server::where(['uuidShort' => $server])->first();
        $this->ModInstall->install($server, $mod);
        $this->alert->success('Mod was installed successfully.')->flash();

        return redirect()->route('server.modmanager.index', $server->uuidShort)->with('installed', 'Mod Installed');
    }

    /**
     * Remove Mod.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Pterodactyl\Exceptions\Http\Connection\DaemonConnectionException
     */
    public function remove(Request $request, $server, ModModel $mod) {

        $server = Server::where(['uuidShort' => $server])->first();
        $this->ModRemove->remove($server, $mod);
        $this->alert->success('Mod was uninstalled successfully.')->flash();

        return redirect()->route('modManager.index', $server->uuidShort)->with('removed', 'Mod Removed');
    }
}
