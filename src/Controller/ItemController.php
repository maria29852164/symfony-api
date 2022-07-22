<?php

namespace App\Controller;

use App\Entity\Item;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends BaseController
{
    #[Route('/api/v1/items',methods: 'GET')]

    public function index(){
        $items = $this->entityManager->getRepository(Item::class)->findAll();
        return $this->json($items);

    }

}