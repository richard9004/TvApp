<?php
// WeekdayFormatter.php (Create this file)
class WeekdayFormatter {
    private $weekDays;

    public function __construct(array $weekDays = null) {
        $this->weekDays = $weekDays ?? [
            1 => "Sunday",
            2 => "Monday",
            3 => "Tuesday",
            4 => "Wednesday",
            5 => "Thursday",
            6 => "Friday",
            7 => "Saturday"
        ];
    }

    public function getWeekdayName(int $weekdayNumber): string {
        if (isset($this->weekDays[$weekdayNumber])) {
            return $this->weekDays[$weekdayNumber];
        } 
    }

    
}
