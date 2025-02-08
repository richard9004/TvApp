<?php 
class SeriesRepository {
    private PDO $pdo;

    public function __construct(PDO $connection) {
        $this->pdo = $connection;
    }

    public function getNextAiringSeries(string $dateTime, ?string $title = null): ?Response {
        $query = "SELECT ts.title, ts.channel, tsi.week_day, tsi.show_time 
                  FROM tv_series ts
                  JOIN tv_series_intervals tsi ON ts.id = tsi.id_tv_series
                  WHERE (tsi.week_day > DAYOFWEEK(:dateTime) 
                  OR (tsi.week_day = DAYOFWEEK(:dateTime) AND tsi.show_time > TIME(:dateTime)))";

        if ($title) {
            $query .= " AND ts.title = :title";
        }

        $query .= " ORDER BY tsi.week_day ASC, tsi.show_time ASC LIMIT 1";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":dateTime", $dateTime);

        if ($title) {
            $stmt->bindParam(":title", $title);
        }

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        if (!$data) {
            return null;
        }

        return new Response(
            id: $data['id'],
            title: $data['title'],
            airing_time: $data['show_time'],
            episode: $data['episode'],
            season: $data['season'],
            channel: $data['channel']
        );
    }
}
