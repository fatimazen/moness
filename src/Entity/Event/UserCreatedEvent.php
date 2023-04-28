<?php

namespace App\Event;

use App\Entity\Users;
use Symfony\Contracts\EventDispatcher\Event;



class  UsersCreatedEvent extends Event
{
    public const NAME = 'user.created';

    public function __construct(
        protected Users $user,
    ) {
    }

    public function getUser(): Users
    {
        return $this->user;
    }
}