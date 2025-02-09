<?php

class SeriesController {
    private SeriesRepository $seriesRepository;

    public function __construct(SeriesRepository $seriesRepository) {
        $this->seriesRepository = $seriesRepository;
    }

    public function getNextAiringSeries(Request $request) {

    //   /  echo "<pre>";print_r($request);exit;
       
        $rules = [
            'timedate' => ['datetime'],  
            'title' => ['string', 'max:255', 'alphanumeric'] 
        ];

        $data = [
            'timedate' => $request->timedate,
            'title' => $request->title
        ];

        $errors = Validator::validate($data, $rules);
        if (!empty($errors)) {
            return [
                'status' => 'error',
                'errors' => $errors
            ];
        }
        
       // $timedate = $request->timedate;
        if (empty($request->timedate)) {
            $timedate = date('Y-m-d H:i:s'); 
        }else{
            $timedate = date('Y-m-d H:i:s', strtotime($request->timedate));
        }
      //  echo $timedate;
       
        $series = $this->seriesRepository->getNextAiringSeries($timedate, $request->title);
        return [
            'status' => 'success',
            'data' => $series
        ];


    }

    
}

?>