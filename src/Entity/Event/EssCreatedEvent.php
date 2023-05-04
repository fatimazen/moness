<?php

namespace App\Event;

use App\Entity\Ess;
use App\Entity\Users;
use Symfony\Contracts\EventDispatcher\Event;

class EssCreatedEvent extends Event
{
    public const NAME = 'user.created';

    public function __construct(
        protected Ess $ess,
    ) {
    }

    public function getUser(): Ess
    {
        return $this->ess;
    }
}