<?php

namespace User\Presentation\Api\Admin\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/api/admin/users',
    methods: [Request::METHOD_POST],
)]
class CreateController extends AbstractController
{
    public function __construct()
    {
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'admin' => true,
        ]);
    }
}