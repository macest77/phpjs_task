<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript">
        var usersArr = [
                {username: 'Jan Kowalski', birthYear: 1983, salary: 4200},
                {username: 'Anna Nowak', birthYear: 1994, salary: 7500},
                {username: 'Jakub Jakubowski', birthYear: 1985, salary: 18000},
                {username: 'Piotr Kozak', birthYear: 2000, salary: 4999},
                {username: 'Marek Sinica', birthYear: 1989, salary: 7200},
                {username: 'Kamila Wiśniewska', birthYear: 1972, salary: 6800},
            ];
        var messagesSalary = [
                [15000, 'Witaj, prezesie!'],
                [5000, '<name>, szykuj się na podwyżkę!'],
            ];
        var messagesBirth = [
                'Witaj, <name>! W tym roku kończysz <obliczony_wiek_rocznikowy> lat!',
                '<name>, jesteś zwolniony!',
        ];
        function checkSalaryOrBirth(userArray, kind)
        {
            if (checkStructure(userArray)) { 
                if (kind == 'salary') {
                    if (userArray.salary > messagesSalary[0][0]){
                        console.log(messagesSalary[0][1].replace('<name>', userArray.username));
                        return true;
                    } else if (userArray.salary < messagesSalary[1][0]) {
                        console.log(messagesSalary[1][1].replace('<name>', userArray.username));
                        return true;
                    }
                } else {
                    var currentYear = new Date().getFullYear();
                    var age = currentYear - userArray.birthYear;
                    var birthModulo = age % 2;
                    var message = messagesBirth[birthModulo].replace('<name>', userArray.username);
                    message = message.replace('<obliczony_wiek_rocznikowy>', age);

                    console.log(message);
                    return true;
                }
            } else {
                console.log(userArray);
            }
            return false;
        }
        function checkStructure(array)
        {
            return (array.username && array.birthYear && array.salary);
        }
        function welcomeUsers(array)
        {
            if (Array.isArray(array)) {
                array.forEach(subarray => {
                    if (checkSalaryOrBirth(subarray, 'salary')) {}
                    else if (checkSalaryOrBirth(subarray, 'birth')) {}
                    else {
                        console.log('Wystąpił błąd');
                    }
                });
            } else {
                console.log('Podano błędne zmienne');
            }
        }
        function exampleUsers()
        {
            welcomeUsers(usersArr);
        }
    </script>
</head>
<body>
<form method="post">
<input type="text" name="conversion" />
<input type="submit" value="Sprawdź" />
</form>

<hr />
<button onclick="exampleUsers();">Uruchom przyładową strukturę welcomeUsers</button>

<?php

class PhoneKeyboardConverter
{
    private $_matrix = [0=>' ', 2=>['A','B','C'],
            ['D','E','F'], ['G','H','I'], ['J','K','L'],
            ['M','N','O'], ['P','Q','R'], ['S','T','U'],
            ['V','W','Y','Z']];

    public function convertToNumeric(string $string_to_convert) : string
    {
        $return_string = '';
        $new_string_array = str_split(strtoupper($string_to_convert));

        foreach($new_string_array as $key => $char) {
            $return_string .= $this->searchMatrixForLetter($char);
            if (isset($new_string_array[($key+1)]))
                $return_string .= ',';
        }

        return $return_string;
    }

    public function convertToString(string $string_to_convert) : string
    {
        $return_string = '';
        $new_numbers_array = explode(',', $string_to_convert);

        foreach($new_numbers_array as $number) {
            $return_string .= strtolower($this->findLetterByNumbers($number));
        }

        return $return_string;
    }

    private function findLetterByNumbers(string $numbers) : string
    {
        return $this->_matrix[substr($numbers,0,1)][(strlen($numbers)-1)];
    }

    private function searchMatrixForLetter(string $char) : string
    {
        $return_string = '';

        foreach($this->_matrix as $number => $chars) {
            if (is_array($chars)) {
                if (in_array($char, $chars)) {
                    for($i = 0; $i < (array_search($char, $chars)+1); $i++) {
                        $return_string .= $number;
                    }
                    return $return_string;
                }
            } elseif ($chars === $char)
                return $number;
        }
        return $return_string;
    }
}

if (isset($_POST['conversion'])) {
    $PhoneKeyboardConverter = new PhoneKeyboardConverter();

    $conversion = strip_tags($_POST['conversion']);

    if (strstr($conversion, ' ')) {
        $converted = $PhoneKeyboardConverter->convertToNumeric($conversion);
    } else {
        $converted = $PhoneKeyboardConverter->convertToString($conversion);
    }

    echo "<p>Oryginalny tekst: $conversion<br />Tekst zmieniony: $converted";
}
?>

</body>
</html>