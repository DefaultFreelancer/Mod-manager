<?php


namespace ItVision\ModManager\Services;


use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\ConnectionInterface;
use Pterodactyl\Contracts\Repository\Daemon\ServerRepositoryInterface as DaemonServerRepositoryInterface;
use Pterodactyl\Contracts\Repository\ServerRepositoryInterface;
use Pterodactyl\Exceptions\Http\Connection\DaemonConnectionException;

class ModInstallService
{

    /**
     * @var \Pterodactyl\Contracts\Repository\Daemon\ServerRepositoryInterface
     */
    protected $daemonServerRepository;

    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $database;

    /**
     * @var \Pterodactyl\Contracts\Repository\ServerRepositoryInterface
     */
    protected $repository;

    /**
     * ModInstallService constructor.
     * @param ConnectionInterface $database
     * @param DaemonServerRepositoryInterface $daemonServerRepository
     * @param ServerRepositoryInterface $repository
     */
    public function __construct(
        ConnectionInterface $database,
        DaemonServerRepositoryInterface $daemonServerRepository,
        ServerRepositoryInterface $repository
    ) {
        $this->daemonServerRepository = $daemonServerRepository;
        $this->database = $database;
        $this->repository = $repository;
    }

    /**
     * @param   $server
     * @param  \Pterodactyl\models\custom\mod $mod
     * @throws DaemonConnectionException
     */
    public function install($server, $mod)
    {
        try {
            $this->daemonServerRepository->setServer($server)->installMod([
                'modName' => $mod->name,
                'pathToInstall' => $mod->path,
                'uriOfMod' => $mod->link,
                'modId' => $mod->id,
                'modFolder' => $mod->foldername,
            ]);
        } catch (RequestException $exception) {
            throw new DaemonConnectionException($exception);
        }
    }

}
