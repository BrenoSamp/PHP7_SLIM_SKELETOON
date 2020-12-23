<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ViewAdminAction extends AdminAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $iduser = (int) $this->resolveArg('iduser');

        $admin = $this->databaseAdminRepository->findUserOfId($iduser);

        $this->respondWithData($admin);

        $this->logger->info("Users list was viewed.");

        $adminResponse = $this->request->getParsedBody();

        $adminUpdate = $this->databaseAdminRepository->update($adminResponse,$iduser);

        return $this->respondWithData($adminUpdate);
    }
}
