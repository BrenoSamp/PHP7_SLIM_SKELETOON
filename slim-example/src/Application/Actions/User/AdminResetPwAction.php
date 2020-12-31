<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\Admin;
use App\Infrastructure\Persistence\User\DatabaseAdminRepository;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;

class AdminResetPwAction extends AdminAction
{
    protected function action(): Response
    {

        $recoveryId = (int) $this->resolveArg('idrecovery');
        $newPassword = $this->request->getParsedBody();
        $user = $this->databaseAdminRepository->validForgotDecrypt($recoveryId);
        $this->databaseAdminRepository->setForgotUser($user['idrecovery']);
        $this->databaseAdminRepository->setPassword($newPassword['password'], $user['iduser']);
        return $this->respondWithData($user);
    }
}
