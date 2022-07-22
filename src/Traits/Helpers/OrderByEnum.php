<?php

namespace App\Traits\Helpers;

interface OrderByEnum
{
    const PER_PAGE = 'perPage';
    const VALUE_DEFAULT_PER_PAGE = 5;
    const ORDER_BY  = 'orderBy';
    const TYPE = 'type';
    const TYPE_DEFAULT = 'DESC';
    const ORDER_DEFAULT = 'id';
    const SEARCH = 'search';
    const CURRENT_PAGE =    'page';
    const CURRENT_PAGE_DEFAULT = 1;

}