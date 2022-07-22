<?php

namespace App\Traits;

use App\Traits\Helpers\OrderByEnum;
use Symfony\Component\HttpFoundation\Request;

trait HandleRequest
{
    public function validatePerPageRequest(Request $request){
        return $request->query->get(OrderByEnum::PER_PAGE) != null ? $request->query->get(OrderByEnum::PER_PAGE): OrderByEnum::VALUE_DEFAULT_PER_PAGE;
    }

    public function validateCurrentPageRequest(Request $request){
        return $request->query->getInt('page') != null ? $request->query->getInt('page'): OrderByEnum::CURRENT_PAGE_DEFAULT;
    }
    public function validateOrderByRequest(Request $request){
        return $request->query->get(OrderByEnum::ORDER_BY) != null ? $request->query->get(OrderByEnum::ORDER_BY): OrderByEnum::ORDER_DEFAULT;

    }
    public function validateTypeRequest(Request $request){
        return $request->query->get(OrderByEnum::TYPE) != null ? $request->query->get(OrderByEnum::TYPE): OrderByEnum::TYPE_DEFAULT;
    }



}