<?php

declare(strict_types=1);

namespace App\Filter;

use App\Entity\User;

final class BlogFilter
{
    private ?string $title = null;

    public function __construct(
        private ?User $user = null,
    ) {
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): BlogFilter
    {
        $this->user = $user;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): BlogFilter
    {
        $this->title = $title;

        return $this;
    }


}