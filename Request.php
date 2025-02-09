<?php 
class Request
{
    public function __construct(
        public ?string $title,
        public ?string $timedate,
    ) {}
}
?>