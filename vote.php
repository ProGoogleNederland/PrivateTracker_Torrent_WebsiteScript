
<script>
function getIPFromAmazon() {
  fetch("https://checkip.amazonaws.com/").then(res => res.text()).then(data => console.log(data))
}
</script>


<?php
$curl = curl_init();
$ip = "<script type=\"text/javascript\">getIPFromAmazon();</script>";
$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,/;q=0.5";
$header[] = "Cache-Control: max-age=0";
$header[] = "Connection: keep-alive";
$header[] = "Keep-Alive: 300";
$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
$header[] = "Accept-Language: en-us,en;q=0.5";
$header[] = "Pragma: ";
curl_setopt($curl, CURLOPT_URL, "https://torrenttop100.com/go-click/264");
curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36");
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_REFERER, "https://torrenttop100.com/go-in/264/eBjBNvXk6CvZFcDUuhCVowubWpvbkSBS3cE3r1HqDHrZOvAejPkAta8BLgNouTHvOQ5pYp88s6e");
curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate");
curl_setopt($curl, CURLOPT_AUTOREFERER, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_TIMEOUT, 30);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);

$html = curl_exec($curl);
//echo 'Curl error: '. curl_error($curl);
curl_close($curl);

echo $html;
?>