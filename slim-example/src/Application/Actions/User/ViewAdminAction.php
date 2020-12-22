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
        
        $admin = $this->request->getParsedBody();
        $adminData = $this->databaseAdminRepository->save($admin);
        return $this->respondWithData($adminData);
    }
}
