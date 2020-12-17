<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ViewPersonAction extends PersonAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $personId = (int) $this->resolveArg('id');
        $person = $this->databasePeopleRepository->findUserOfId($personId);

        $this->logger->info("User of id `${personId}` was viewed.");

        return $this->respondWithData($person);
    }
}

