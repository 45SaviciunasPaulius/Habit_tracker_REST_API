<?php

namespace App\Services;

use Illuminate\Http\Request;


class HabitLogFilter{

protected $allowedOperators = [
    'note' => ['like'],
    'date' => ['eq', 'gt', 'gte', 'lt', 'lte']
];

protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'like' => 'LIKE'
];


public function transform(Request $request){
    $eloQuery = [];

    foreach($this->allowedOperators as $column => $operators){
        $query = $request->query($column);

        if(!isset($query)){
            continue;
        }

        foreach($operators as $operator){

        if(isset($query[$operator])){
            $value = $query[$operator];

            if($operator == 'like'){
                $value = '%'.$query[$operator].'%';
            }

            $eloQuery[] = [$column, $this->operatorMap[$operator], $value];
        }
        }
    }

    return $eloQuery;
}

}