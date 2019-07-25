<?php

namespace App\Repositories;

class BaseRepository
{
    /**
     * Get sort info function
     * @param $value
     * @return array
     */
    public function parseSortString($value){
        $result = [];
        if ($value) {
            $explode = array_filter(array_map('trim', explode(',', $value)));
            foreach ($explode as $item) {
                $firstChar = substr($item, 0, 1);
                if($firstChar != '-') {
                    $remainPart = ltrim($item,'+');
                    $result[$remainPart] = 'asc';
                }else{
                    $remainPart = ltrim($item,'-');
                    $result[$remainPart] = 'desc';
                }
            }
        }

        return $result;
    }
}