<?php
class SeriesController {
    private SeriesRepository $seriesRepository;

    public function __construct(SeriesRepository $seriesRepository) {
        $this->seriesRepository = $seriesRepository;
    }

    public function getNextAiringSeries(Request $request): string {
        
        $rules = [
            'datetime' => ['datetime'],  
            'title' => ['string', 'max:255', 'alphanumeric'] 
        ];
        
        $errors = Validator::validate(['datetime' => $request->datetime, 'title' => $request->title], $rules);
        if (!empty($errors)) {
            $errors = json_encode($errors);
            return $errors;
        }


        if (empty($datetime)) {
            $datetime = date('Y-m-d H:i:s'); 
        } else {
            $date = new DateTime($datetime);
            $datetime = $date->format('Y-m-d H:i:s');
        }
        $series = $this->seriesRepository->getNextAiringSeries($request->datetime, $request->title);
       
        if (empty($series)) {
            return "No series found";
        }else{
            return json_encode($series);
        }


    }

    
}

?>