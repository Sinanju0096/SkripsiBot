<?php

require "C:/Apache24/htdocs/GMBOT/vendor/autoload.php";
use League\Csv\Reader;
use League\Csv\Statement;

//load the CSV document from a stream
$stream = fopen('pertanyaan.csv', 'r');
$csv = Reader::createFromStream($stream);
$csv->setDelimiter(';');
$csv->setHeaderOffset(0);

//build a statement
$stmt = new Statement()
    ->select('pertanyaan', 'jawaban')
    //->andWhere('firstname', 'starts with', 'A')
    ->orderByAsc('pertanyaan');
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