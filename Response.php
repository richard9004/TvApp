<?php

class Response  {
    public function __construct(
        private int $id,
        private string $title,
        private string $airing_time,
        private int $episode,
        private int $season,
        private string $channel
    ) {}

  
}
?>
