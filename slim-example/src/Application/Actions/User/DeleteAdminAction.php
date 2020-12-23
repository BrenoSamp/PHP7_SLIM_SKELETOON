<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteAdminAction extends AdminAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $iduser = (int) $this->resolveArg('iduser');

        $adminUpdate = $this->databaseAdminRepository->delete($iduser);

        return $this->respondWithData($adminUpdate);
    }
}
