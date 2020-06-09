<?php


class filterInput
{
    public function filter($datas){
        $newData = [];
        foreach ($datas as $key=>$data){
            trim($data);
            $newData[$key] = htmlentities($data);
        }
        return $newData;
    }

}