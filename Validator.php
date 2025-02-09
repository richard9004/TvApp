<?php
class Validator {
    public static function validate(array $data, array $rules): array {
        $errors = []; 

         foreach ($rules as $key => $value) {
            if (!isset($data[$key]) || empty($data[$key])) {
                continue; 
            }

           
                foreach ($value as $rule) {
                    if ($rule == 'datetime') {
                        if (!strtotime($data[$key])) {
                            $errors[$key] = 'Invalid datetime';
                        }
                    } elseif ($rule == 'string') {
                        if (!is_string($data[$key])) {
                            $errors[$key] = 'Invalid string format';
                        }
                    } elseif ($rule == 'max:255') {
                        if (strlen($data[$key]) > 255) {
                            $errors[$key] = 'String is too long';
                        }
                    } elseif ($rule == 'alphanumeric') {
                        if (!ctype_alnum($data[$key])) {
                            $errors[$key] = 'String is not alphanumeric';
                        }
                    }
                }
            
          
    }

    return $errors;

  
}


}
?>
