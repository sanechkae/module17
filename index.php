<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

////////////////////////////////////////////////////////////////////////////////////////
$randkey = array_rand ($example_persons_array);
$fullname =$example_persons_array [$randkey]['fullname'];
$keys = ['surname', 'name', 'patronomyc'];

function getPartsFromFullname($fullname, $keys){
    $result = array_combine($keys, explode(' ', $fullname));
    return $result ;
}
var_dump(getPartsFromFullname($fullname, $keys));
$partsFromFullname = getPartsFromFullname($fullname, $keys);

echo "<br>";
echo "<br>";
echo "<br>";

function getFullnameFromParts($partsFromFullname) {
    $result = implode(" ", array_values($partsFromFullname));
    return $result;
}
$fullnameFromParts = getFullnameFromParts($partsFromFullname);
var_dump(getFullnameFromParts($partsFromFullname));

echo "<br>";
echo "<br>";
echo "<br>";

////////////////////////////////////////////////////////////////////////////////////////

function  getShortName ($partsFromFullname) {
    $fioname = $partsFromFullname['name'];
    $fiosurname = mb_convert_case( mb_substr($partsFromFullname['surname'],0,1,'UTF-8'), MB_CASE_UPPER);
    $fio = $fioname.' '.$fiosurname.'.';
    return $fio;
}

$shortName = getShortName ($partsFromFullname);
var_dump(getShortName ($partsFromFullname));

echo "<br>";
echo "<br>";
echo "<br>";

//////////////////////////////////////////////////////////////////////////////////////

function getGenderFromName ($partsFromFullname) {
    $defaultGender = 0;
    
    if (mb_substr($partsFromFullname['surname'],-2, 2,'UTF-8') == 'ва'){
        $defaultGender--;
    } elseif(mb_substr($partsFromFullname['surname'],-1, 1,'UTF-8') == 'в') {
        $defaultGender++;
    } elseif(mb_substr($partsFromFullname['patronomyc'],-3, 3,'UTF-8') == 'вна'){
        $defaultGender--;
    } elseif(mb_substr($partsFromFullname['patronomyc'],-2, 2,'UTF-8') == 'ич') {
        $defaultGender++;
    } elseif (mb_substr($partsFromFullname['name'],-1, 1,'UTF-8') == 'а'){
        $defaultGender--;
    } elseif(mb_substr($partsFromFullname['name'],-1, 1,'UTF-8') == 'й' || mb_substr($partsFromFullname['name'],-1, 1,'UTF-8') == 'н') {
        $defaultGender++;
    } else {
        $defaultGender = 0;
    }
    
    
    
    if ($defaultGender > 0 ){
        $defaultGender = 1;
    }elseif ($defaultGender<0){
        $defaultGender = -1;
    } else {
        $defaultGender = 0;
    }
    
    return $defaultGender;

}

var_dump(getGenderFromName ($partsFromFullname));
$gender = getGenderFromName ($partsFromFullname);

echo "<br>";
echo "<br>";
echo "<br>";


///////////////////////////////////////////////////////////////////////////////////////

function getGenderDescription ($example_persons_array, $gender, $partsFromFullname) {

    $girlarr = [];
    $boyarr = [];
    $anotherarr = [];
    $key = ['surname', 'name', 'patronomyc'];

    foreach ($example_persons_array as $value) {
        $partsFromFullname = getPartsFromFullname($value['fullname'], $key);
        $gender = getGenderFromName($partsFromFullname);

        if ($gender<0){
            $girlarr[] = $value;
        } elseif ($gender>0){
            $boyarr[] = $value;
        } else {
            $anotherarr[] = $value;
        }
    }
    
    $girls = round((count($girlarr) *100)/count($example_persons_array), 1);
    $boys = round((count($boyarr) *100)/count($example_persons_array), 1);
    $another = round((count($anotherarr) *100)/count($example_persons_array), 1);
    $result = [$girls, $boys, $another];
    
    return $result;

}

$GenderDescription = getGenderDescription ($example_persons_array, $gender, $partsFromFullname);

echo <<<HEREDOCLETTER
Гендерный состав аудитории: <br>
--------------------------- <br>
Мужчины - $GenderDescription[1]% <br>
Женщины - $GenderDescription[0]% <br>
Не удалось определить - $GenderDescription[2]% <br>
HEREDOCLETTER;


echo "<br>";
echo "<br>";
echo "<br>";

function getPerfectPartner( $example_persons_array) {
    $randomNumber = round(mt_rand(5000, 10000), 2)/100;
    $key = ['surname', 'name', 'patronomyc'];
    $randomone = array_rand ($example_persons_array);
    $nameone = $example_persons_array[$randomone]['fullname'];
    $randomtwo = array_rand ($example_persons_array);
    $nametwo = $example_persons_array[$randomtwo]['fullname'];

    $partsFromFullnameOne = getPartsFromFullname($nameone, $key);
    $genderone = getGenderFromName ($partsFromFullnameOne);
    
    while ($genderone == 0) {
        $randomone = array_rand ($example_persons_array);
        $nameone = $example_persons_array[$randomone]['fullname'];
        $partsFromFullnameOne = getPartsFromFullname($nameone, $key);
        $genderone = getGenderFromName ($partsFromFullnameOne);
    }

    $partsFromFullnameTwo = getPartsFromFullname($nametwo, $key);
    $gendertwo = getGenderFromName ($partsFromFullnameTwo);

    while ($genderone == $gendertwo) {
        $randomtwo = array_rand ($example_persons_array);
        $nametwo = $example_persons_array[$randomtwo]['fullname'];
        $partsFromFullnameTwo = getPartsFromFullname($nametwo, $key);
        $gendertwo = getGenderFromName ($partsFromFullnameTwo);
    }

    $shortNameone = getShortName ($partsFromFullnameOne);
    $shortNametwo = getShortName ($partsFromFullnameTwo);
    

    $couple = [$shortNameone, $shortNametwo, $randomNumber]; 
    
    return $couple;   
}

$perfectPartner = getPerfectPartner( $example_persons_array);

echo <<<HEREDOCLETTER
$perfectPartner[0] + $perfectPartner[1] = <br>
♡Идеально на $perfectPartner[2]%♡
HEREDOCLETTER;
