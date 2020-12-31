<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\Admin;
use App\Infrastructure\Persistence\User\DatabaseAdminRepository;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;

class AdminForgotAction extends Action
{
    /**
     * @var DatabaseAdminRepository
     */
    protected $databaseAdminRepository;

    /**
     * @param LoggerInterface $logger
     * @param DatabaseAdminRepository  
     */
    public function __construct(LoggerInterface $logger, DatabaseAdminRepository $databaseAdminRepository)
    {
        parent::__construct($logger);
        $this->databaseAdminRepository = $databaseAdminRepository;
    }

    protected function action(): Response
    {
        $params = $this->request->getParsedBody();
        $ipAddress = $this->request->getHeader('True-Client-IP')[0];
        $emailSend = $this->databaseAdminRepository->getForgot($params['email'], $ipAddress);
        return $this->respondWithData($emailSend);
    }
}
