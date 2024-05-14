<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class NotesFilter extends ApiFilter {

    protected $safeParms = [
        'title' => ['eq'],
        'category' => ['eq', 'ne'],
        'description' => ['eq'],
        'completed' => ['eq'],
        'createdAt' => ['eq', 'lt', 'gt', 'lte', 'gte', 'ne']
    ];

    protected $columnMap = [
        'createdAt' => 'created_at'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'ne' => '!='
    ];
}