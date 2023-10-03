<?php

namespace App\Services;

use App\Repositories\UserRepository;

class CheckoutService
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getCarts()
    {
        return session()->get('cart');
    }

    public function getUser()
    {
        return $this->userRepository->getUser();
    }

    public function getInfoUser()
    {
        return $this->userRepository->getInfoUser();
    }
}
