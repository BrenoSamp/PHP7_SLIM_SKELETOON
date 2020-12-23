<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\Admin;
use App\Infrastructure\Persistence\User\DatabaseAdminRepository;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;

class AdminAction extends Action
{
    /**
     * @var DatabaseAdminRepository
     */
    protected $databaseAdminRepository;

    /**
     * @param LoggerInterface $logger
     * @param DatabaseAdminRepository  $PersonAction
     */
    public function __construct(LoggerInterface $logger, DatabaseAdminRepository $databaseAdminRepository)
    {
        parent::__construct($logger);
        $this->databaseAdminRepository = $databaseAdminRepository;
    }

    protected function action(): Response
    {
        $admin = $this->request->getParsedBody();
        $adminData = $this->databaseAdminRepository->login((string) $admin['deslogin'],(string) $admin['despassword']);
        return $this->respondWithData($adminData);
    }
}
