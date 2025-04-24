<?php

require "C:/Apache24/htdocs/GMBOT/vendor/autoload.php";
use League\Csv\Reader;
use League\Csv\Statement;

//load the CSV document from a stream
$stream = fopen('gamedata.csv', 'r');
$csv = Reader::createFromStream($stream);
$csv->setDelimiter(';');
$csv->setHeaderOffset(0);

//build a statement
$stmt = new Statement()
    ->select('judulgame', 'sinopsis')
    //->andWhere('firstname', 'starts with', 'A')
    ->orderByAsc('judulgame');
    //->offset(10)
    //->limit(25);

//query your records from the document
$records = $stmt->process($csv);
/*
foreach ($records as $record) {
    //do something here
    echo $record['topik'],'<br>';
}
*/

?>