<?php 

class SeriesRepository {
    private PDO $pdo;

    public function __construct(PDO $connection) {
        $this->pdo = $connection;
    }

    public function getNextAiringSeries(string $timedate, ?string $title = null): ?Response { 
        $query = "SELECT ts.id, ts.title, ts.channel, tsi.week_day, tsi.show_time 
FROM tv_series ts
JOIN tv_series_intervals tsi ON ts.id = tsi.id_tv_series
WHERE 1=1
  AND (
    (tsi.week_day > DAYOFWEEK(:timedate)) 
    OR (tsi.week_day = DAYOFWEEK(:timedate) AND tsi.show_time > TIME(:timedate))
    OR (tsi.week_day < DAYOFWEEK(:timedate))
  )"; 

        if (!empty($title)) {
            $query .= " AND ts.title = :title";
        }

        $query .= "
ORDER BY 
  CASE 
    WHEN (tsi.week_day > DAYOFWEEK(:timedate)) OR (tsi.week_day = DAYOFWEEK(:timedate) AND tsi.show_time > TIME(:timedate)) 
    THEN 0 
    ELSE 1 
  END ASC,
  tsi.week_day ASC,
  tsi.show_time ASC
LIMIT 1;";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(":timedate", $timedate); 
            $stmt->bindParam(":title", $title);
            
       // $finalSQL = str_replace([":timedate", ":title"], ["'$timedate'", $title ? "'$title'" : "NULL"], $query);
       // echo "<pre>SQL Query: \n$finalSQL</pre>";
        

            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
           //echo "<pre>";print_r($data);exit;
            if (!$data) {
                return null; 
            }

            return new Response( 
                id: $data['id'],
                title: $data['title'],
                airingTime: $data['show_time'],
                channel: $data['channel'],
                weekDay: $data['week_day']
            );

        } catch (PDOException $e) {
           
            error_log($e->getMessage());
            throw new Exception("Database error: " . $e->getMessage()); 
        }
    }
}