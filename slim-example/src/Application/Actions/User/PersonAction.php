<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\DatabasePeopleRepository;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;


class PersonAction extends Action
{
    /**
     * @var DatabasePeopleRepository
     */
    protected $databasePeopleRepository;

    /**
     * @param LoggerInterface $logger
     * @param DatabasePeopleRepository  $PersonAction
     */
    public function __construct(LoggerInterface $logger, DatabasePeopleRepository $databasePeopleRepository)
    {
        parent::__construct($logger);
        $this->databasePeopleRepository = $databasePeopleRepository;
    }
    
    protected function action(): Response
    {
        $people = $this->databasePeopleRepository->findAll();

        return $this->respondWithData($people);
    }
    
}
