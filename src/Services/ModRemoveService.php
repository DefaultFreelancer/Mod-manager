<?php


namespace ItVision\ModManager\Services;


use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\ConnectionInterface;
use ItVision\ModManager\models\ModModel;
use ItVision\ModManager\Providers\ServerRepositoryProvider;
use Pterodactyl\Contracts\Repository\Daemon\ServerRepositoryInterface as DaemonServerRepositoryInterface;
use Pterodactyl\Contracts\Repository\ServerRepositoryInterface;
use Pterodactyl\Exceptions\Http\Connection\DaemonConnectionException;

class ModRemoveService
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
     * ModRemoveService constructor.
     * @param ConnectionInterface $database
     * @param DaemonServerRepositoryInterface $daemonServerRepository
     * @param ServerRepositoryInterface $repository
     */
    public function __construct(
        ConnectionInterface $database,
        ServerRepositoryProvider $daemonServerRepository,
        ServerRepositoryInterface $repository
    ) {
        $this->daemonServerRepository = $daemonServerRepository;
        $this->database = $database;
        $this->repository = $repository;

    }

    /**
     * @param $server
     * @throws DaemonConnectionException
     */
    public function remove($server, ModModel $mod){

        try {
            $this->daemonServerRepository->setServer($server)->removeMod([
                'modName' => $mod->name,
                'pathToInstall' => $mod->path,
                'uriOfMod' => $mod->link,
                'modId' => $mod->id,
                'foldername' => $mod->foldername
            ]);

        } catch (RequestException $exception) {
            throw new DaemonConnectionException($exception);
        }
    }

}
