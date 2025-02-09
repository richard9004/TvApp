<?php

class Response  {
    public function __construct(
        public int $id,
        public string $title,
        public string $airingTime,
        public string $channel,
        public string $weekDay
    ) {}

    

  
}
?>
