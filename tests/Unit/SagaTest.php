<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SagaTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $listAge = [
            0 => 10,
            1 => 12,
        ];
        $listYear = [
            0 => 13,
            1 => 17,
        ];
        $listPerson = [
            0 => 'Budi',
            1 => 'Asep'
        ];

        $results = $listCountKilled = [];
        $totalKilled = 0;

        $listAngka = $this->listAngka();
        if(empty($listAngka)) {
            $this->assertTrue(false);
        }

        $listKills = $this->listKills($listAge, $listYear);
        if(empty($listKills)) {
            $this->assertTrue(false);
        }

        foreach ($listKills as $key => $value) {
            $keys = $value+$key;
            $person = isset($listPerson[$key]) ? $listPerson[$key] : 'Anonymous ' . $key+1;
            $killed = isset($listAngka[$keys]) ? $listAngka[$keys] : -1;
            $year = $this->getYear($key, $listYear);
            $age = $this->getAge($key, $listAge);
            $killed = ($age <= 0 || !is_numeric($age) || $year <= 0 || !is_numeric($year)) ? -1 : $killed;
            $selisih = $year - $age;
            $listCountKilled[] = $killed;
            $totalKilled += $killed;
            $results[] = [
                'person' => $person,
                'age' => $age,
                'year' => $year,
                'selisih' => $selisih,
                'killed' => $killed
            ];
        }

        $output = implode(' + ', array_map(
            function ($v, $k) { 
                return $v; 
            },
            $listCountKilled,
            array_keys($listCountKilled)
        ));
        $averages = '( '.$output.' )/' . 2 .' = ' .$totalKilled / 2;
        $responses = [
            'results' => $results,
            'averages' => $averages,
        ];

        $this->assertTrue(true);
    }

    private function listAngka()
    {
        $listAngka = [];
        $max = 100;
        for($j=1; $j<= $max; $j++){
            $n1 = $j;	
            $flag = 0;
            for($i=2; $i<= ($n1/2); $i++){
                if($n1 % $i == 0 ){
                    $flag = 1;
                    break;
                }
            }
            
            if($flag == 0){
                array_push($listAngka, $n1);
            }	
        }
        array_unshift($listAngka, '');
        unset($listAngka[0]);

        $newListAngka = [];
        for($jj=1; $jj<= $max; $jj++) {
            $newListAngka[$jj] = isset($listAngka[$jj]) ? $listAngka[$jj] : 0;
        }

        return $newListAngka;
    }

    private function listKills($listAge, $listYear)
    {
        $listKills = [];
        if(!empty($listAge) && !empty($listYear)) {
            foreach ($listAge as $key => $value) {
                $year = $this->getYear($key, $listYear);
                $age = $this->getAge($key, $listAge);
                $kill = ($age <= 0 || !is_numeric($age) || $year <= 0 || !is_numeric($year)) ? -1 : $year - $age;
                $listKills[] = $kill;
            }
        }
        return $listKills;
    }

    private function getAge($age, $listAge)
    {
        $ages = isset($listAge[$age]) ? $listAge[$age] : 0;
        return ($ages <= 0 || !is_numeric($ages)) ? -1 : $ages;
    }

    private function getYear($year, $listYear)
    {
        $years = isset($listYear[$year]) ? $listYear[$year] : 0;
        return ($years <= 0 || !is_numeric($years)) ? -1 : $years;
    }
}
