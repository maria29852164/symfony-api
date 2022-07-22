<?php

namespace App\Controller\Task;

use App\Controller\BaseController;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends BaseController
{


    #[Route('/api/v1/tasks', methods: ['GET'])]
    public function index (Request $request,EntityManagerInterface $entityManager):Response{
        $perPage = $this->validatePerPageRequest($request);
        $orderBy = $this->validateOrderByRequest($request);
        $type = $this->validatePerPageRequest($request);
        $search = $this->validateSearchRequest($request);
        $current_page = $this->validateCurrentPageRequest($request);
        $tasks = $entityManager->getRepository(Task::class)->findAll();



        return $this->json($tasks);
    }
}