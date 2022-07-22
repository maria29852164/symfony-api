<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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

    public function index(Request $request, PaginatorInterface $paginator){
        $orderBy = $this->validateOrderByRequest($request);
        $type = $this->validateTypeRequest($request);
        $current_page = $this->validateCurrentPageRequest($request);
        $perPage = $this->validatePerPageRequest($request);

        $query = $this->itemRepository->getItems($orderBy,$type);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $current_page,
            $perPage
        );

        return $this->json($pagination,Response::HTTP_OK);

    }
    #[Route('/api/v1/store/item',methods: 'POST')]


    public function addItem(Request $request,FileUploader $fileUploader): JsonResponse
    {

        $title = $request->get(Item::TITLE);
        $price = (float) $request->get(Item::PRICE);
        $description = $request->get(Item::DESCRIPTION);
        $image = $request->files->get('image');
        $urlImage =  $fileUploader->upload($image);

        if (empty($title) || empty($price) || empty($description) || empty($urlImage)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

       $item= $this->itemRepository->saveItem($title,$description,$urlImage,$price);

        return $this->json($item,Response::HTTP_CREATED);
    }

    #[Route('/api/v1/update/item/{id}',methods: 'PUT')]


    public function updateItem($id,Request $request,FileUploader $fileUploader): JsonResponse
    {
        $item = $this->itemRepository->find($id);
        if(!empty($item)){
            $title = $request->get(Item::TITLE);
            $price = (float) $request->get(Item::PRICE);
            $description = $request->get(Item::DESCRIPTION);
            $image = $request->files->get('image');
            $urlImage =  $fileUploader->upload($image);

            if (empty($title) || empty($price) || empty($description) || empty($image)) {
                throw new NotFoundHttpException('Expecting mandatory parameters!');
            }

            $item= $this->itemRepository->updateItem($item,$title,$description,$urlImage,$price);

        }
        return $this->json($item,Response::HTTP_OK);



    }

    #[Route('/api/v1/delete/item/{id}',methods: 'DELETE')]


    public function delete($id): JsonResponse
    {
        $item = $this->itemRepository->findOneBy(['id' => $id]);

        $this->itemRepository->remove($item);


        return $this->json($item,Response::HTTP_OK);
    }

}