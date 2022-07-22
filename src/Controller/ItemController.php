<?php

namespace App\Controller;

use App\Entity\Item;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends BaseController
{
    #[Route('/api/v1/items',methods: 'GET')]

    public function index(Request $request){
        $orderBy = $this->validateOrderByRequest($request);
        $type = $this->validateOrderByRequest($request);

        $items = $this->entityManager->getRepository(Item::class)->findAll();
        return $this->json($items);

    }

}