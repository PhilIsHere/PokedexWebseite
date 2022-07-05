<?php
namespace App\traits;
trait ArrayTraits{

    /**
     * @param array $vergleichArray $vergleichArray ist der Array dessen Werte verglichen werden sollen. Wenn [0] != [x] ist wird immer ein False ausgegeben.
     * @return bool wenn alle Werte übereinstimmen wird ein true ausgegeben.
     * ToDo: Richtig machen lol
     */
    public static function arrayEqualValues(array $vergleichArray) : bool{
        $temp = $vergleichArray[0];
        foreach ($vergleichArray as $key){
            if ($temp != $vergleichArray[($key+1)]){
                echo 'false';
                return false;
            }else{
                $temp = $key+1;
                var_dump($temp);
            }
        }
        echo 'true';
        return true;
    }

}