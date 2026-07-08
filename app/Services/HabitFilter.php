<?php

namespace App\Services;

use \Illuminate\Http\Request;

class HabitFilter {

    protected $allowedOperators = [
        'title' => ['like'],
        'description' => ['like'],
        'frequency' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'current_streak' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'longest_streak'=> ['eq', 'gt', 'gte', 'lt', 'lte']
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
        $eloQuery =[];

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