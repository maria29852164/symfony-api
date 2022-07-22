<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends BaseController
{
    protected $itemRepository;
    public function __construct(EntityManagerInterface $entityManager,ItemRepository $itemRepository)
    {
        parent::__construct($entityManager);
        $this->itemRepository = $itemRepository;
    }

    #[Route('/api/v1/items',methods: 'GET')]

    public function index(Request $request){
        $orderBy = $this->validateOrderByRequest($request);
        $type = $this->validateOrderByRequest($request);

        $items = $this->entityManager->getRepository(Item::class)->findAll();
        return $this->json($items,Response::HTTP_OK);

    }
    #[Route('/api/v1/store/item',methods: 'POST')]


    public function addItem(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $title = $data[Item::TITLE];
        $price = (float) $data[Item::PRICE];
        $description = $data[Item::DESCRIPTION];
        $image = $data[Item::IMAGE];

        if (empty($title) || empty($price) || empty($description) || empty($image)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

       $item= $this->itemRepository->saveItem($title,$description,$image,$price);

        return $this->json($item,Response::HTTP_CREATED);
    }

    #[Route('/api/v1/update/item/{id}',methods: 'PUT')]


    public function updateItem($id,Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $item = $this->itemRepository->find($id);
        if(!empty($item)){
            $title = $data[Item::TITLE];
            $price = (float) $data[Item::PRICE];
            $description = $data[Item::DESCRIPTION];
            $image = $data[Item::IMAGE];

            if (empty($title) || empty($price) || empty($description) || empty($image)) {
                throw new NotFoundHttpException('Expecting mandatory parameters!');
            }

            $item= $this->itemRepository->updateItem($item,$title,$description,$image,$price);

        }
        return $this->json($item,Response::HTTP_OK);



    }

    #[Route('/api/v1/delete/item/{id}',methods: 'PUT')]


    public function delete($id): JsonResponse
    {
        $item = $this->itemRepository->findOneBy(['id' => $id]);

        $this->itemRepository->remove($item);


        return $this->json($item,Response::HTTP_OK);
    }

}