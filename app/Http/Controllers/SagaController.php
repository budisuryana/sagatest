<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SagaController extends Controller
{
    public function process(Request $request)
    {
        return response()->json($this->getResponses($request));
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

    private function listKills($request)
    {
        $listAge = $request->input('age_of_death');
        $listYear = $request->input('year_of_death');
        $listKills = [];
        if(!empty($listAge) && !empty($listYear)) {
            foreach ($listAge as $key => $value) {
                $year = isset($listYear[$key]) ? $listYear[$key] : 0;
                $age = isset($listAge[$key]) ? $listAge[$key] : 0;
                $kill = $year - $age;
                $listKills[] = $kill;
            }
        }
        return $listKills;
    }

    private function getResponses($request)
    {
        $listPerson = $request->input('person_name');
        $listAge = $request->input('age_of_death');
        $listYear = $request->input('year_of_death');

        $results = $listCountKilled = [];
        $totalKilled = 0;
        $responses = [
            'results' => [],
            'averages' => '',
        ];

        $listAngka = $this->listAngka();
        $listKills = $this->listKills($request);
        
        if(!empty($listKills)) {
            foreach ($listKills as $key => $value) {
                if(isset($listAngka[$value])) {
                    $person = isset($listPerson[$key]) ? $listPerson[$key] : 'Anonymous ' . $key+1;
                    $age = isset($listAge[$key]) ? $listAge[$key] : 0;
                    $year = isset($listYear[$key]) ? $listYear[$key] : 0;
                    $selisih = $year - $age;
                    $killed = $listAngka[$value+$key];
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
        }

        return $responses;
    }
}
