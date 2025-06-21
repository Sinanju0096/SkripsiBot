<?php 

require "C:/Apache24/htdocs/GMBOT/vendor/autoload.php"; //untuk memanggil library sastrawi menggunakan composer
require 'Tfidf.php';
require 'readdata.php';

function pre_process($str){
    $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
    $stemmer = $stemmerFactory->createStemmer();

    $stopWordRemoverFactory = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
    $stopword = $stopWordRemoverFactory->createStopWordRemover();

    $str = strtolower($str); //huruf kecil
    $str = $stemmer->stem($str); //kata dasar 
    $str = $stopword->remove($str); //tanda baca seperti . ; ? ; !

    return $str;
}

function cosSimilarity($weight) {
    $cossim = array();
    $i = 1;
    $n = count($weight);
    $last = end($weight);
    //echo "Question: <br>";
    $normlast = 0;
    foreach($last as $w) {
        //echo "$w <br />";
        $normlast = $normlast + $w * $w;  
    }
    $normlast = sqrt($normlast); //echo 'norm Q:'.$normlast."<br>"; panjang vektor 
    foreach($weight as $ww) {
        if($i == $n) break;
    //for($i = 1; $i < $n; $i++) {
        // echo "Dokumen ke-$i : <br /><br />";
        //$j=1;
        $cossim[$i] = 0.0;
        //for($j = 0; $j < count($weight[$i]); $j++) {
        $normdoc = 0;
        foreach($ww as $key=>$w) {
            //echo $w.'x'.$last[$key].'<br>';
            $cossim[$i] = $cossim[$i] + $w * $last[$key];
            $normdoc = $normdoc + $w * $w;
        }
        $normdoc = sqrt($normdoc); 
        $cossim[$i] = $cossim[$i] / ($normdoc * $normlast); //cosine similarity = perkalian dot product/ panjang vektor masing-masing
        //foreach($ww as $w) {
            //$cossim[$i] = $cossim[$i] + $w * $weight[$n][$j];
            //echo "$w <br />";
            //$j = $j + 1;
        //}
        $i = $i + 1;
    }
    return $cossim;
}

$question = $_POST['text']; 
$playstation = array();
$desc = array();
$i = 1;
foreach ($records as $record) {
    //do something here
    $playstation[$i] = $record['pertanyaan'];
    $desc[$i] = $record['jawaban'];
    //echo $record['topik'],'<br>';
    $i = $i + 1;
}
/*
$playstation[1] = "Hotel Modern yang Terjangkau";
$playstation[2] = "Akomodasi modern, nyaman, dan tenang";
$playstation[3] = "Hotel bintang 3 yang mewah namun dengan harga yang terjangkau";
*/

foreach($playstation as $key=>$item){
    $playstation[$key] = pre_process($item);
}
$playstation[count($playstation)+1] = pre_process($question);

$dw = new Tfidf();
$dw->create_index($playstation);
$dw->idf();
$w = $dw->weight(); 

$dp = cosSimilarity($w);

// print '<pre>';
// print_r($w);
// print_r($dp);
// print '</pre>';

$maxSim = max($dp);
$maxKey = array_search($maxSim, $dp); 
//echo "TF-IDF = ", $dp[$maxKey] ;
//if($maxSim > 0) echo $desc[$maxKey];// "TF-IDF = ", $dp[$maxKey] ; //aktifkan ketika demo. ini asli
if($maxSim > 0.6) echo $desc[$maxKey]; //, "TF-IDF = ", $dp[$maxKey] ; //ambil deskripsi dengan similarity paling tinggi//
else echo "Maaf, tidak ada jawaban untuk pertanyaan itu.
            Mohon untuk memberikan rincian yang lebih jelas untuk pertanyaan yang sebelumnya. 
            Thank you.";
//echo "Q: ", $question, "<br> A: ", $desc[$key];
//echo $playstation[count($playstation)];

?>