<?php

namespace App\Traits;

use App\Traits\Helpers\OrderByEnum;
use Symfony\Component\HttpFoundation\Request;

trait HandleRequest
{
    public function validatePerPageRequest(Request $request){
        return $request->get(OrderByEnum::PER_PAGE) != null ? $request->get(OrderByEnum::PER_PAGE): OrderByEnum::VALUE_DEFAULT_PER_PAGE;
    }

    public function validateCurrentPageRequest(Request $request){
        return $request->get(OrderByEnum::CURRENT_PAGE) != null ? $request->get(OrderByEnum::CURRENT_PAGE): OrderByEnum::CURRENT_PAGE_DEFAULT;
    }
    public function validateOrderByRequest(Request $request){
        return $request->get(OrderByEnum::ORDER_BY) != null ? $request->get(OrderByEnum::ORDER_BY): OrderByEnum::ORDER_DEFAULT;

    }
    public function validateTypeRequest(Request $request){
        return $request->get(OrderByEnum::TYPE) != null ? $request->get(OrderByEnum::TYPE): OrderByEnum::TYPE_DEFAULT;
    }
    public function validateSearchRequest(Request $request){
        return $request->get(OrderByEnum::SEARCH
        ) != null ? $request->get(OrderByEnum::SEARCH
        ): '';

    }


}