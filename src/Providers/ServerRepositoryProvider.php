<?php

namespace ItVision\ModManager\Providers;


use Pterodactyl\Repositories\Daemon\ServerRepository;
use Psr\Http\Message\ResponseInterface;

class ServerRepositoryProvider extends ServerRepository
{
    /**
     * @param array|null $data
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function installMod(array $data = null): ResponseInterface {
        return $this->getHttpClient()->request('POST', 'server/installmod', [ 'json' => $data ?? [] ]);
    }

    /**
     * @param array|null $data
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function removeMod(array $data = null): ResponseInterface {
        return $this->getHttpClient()->request('POST', 'server/removemod', [ 'json' => $data ?? [] ]);
    }


}
