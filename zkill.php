<?php
include('lib/simple_html_dom.php');

$dom = file_get_html($argv[1]);
$data = array();

$data["link"] = $argv[1];

$data["character"] = $dom->find('a[href^=/character]')[1]->innertext;
$data["corporation"] = $dom->find('a[href^=/corporation]')[1]->innertext;
$data["alliance"] = $dom->find('a[href^=/alliance]')[1]->innertext;

$data["hull"] = $dom->find('a[href^=/ship]')[1]->innertext;
$data["type"] = $dom->find('a[href^=/group]')[1]->innertext;
$data["system"] = $dom->find('a[href^=/system]')[0]->innertext;
$data["security"] = $dom->find('span[style^=color: #]')[0]->innertext;
$data["region"] = $dom->find('a[href^=/region]')[0]->innertext;

$data["isk_dropped"] = $dom->find('td.item_dropped')[0]->innertext;
$data["isk_total"] = $dom->find('strong.item_dropped')[0]->innertext;

$tmptime = $dom->find('table[class=table table-condensed table-striped table-hover]')[0];

if($tmptime->find('tr')[2]->find('th')[0]->innertext == "System:")
	$data["date"] = $tmptime->find('tr')[3]->find('td')[0]->innertext;
else
	$data["date"] = $tmptime->find('tr')[2]->find('td')[0]->innertext;

ob_start();
include('template.tmp');
$rendered = ob_get_contents();
ob_end_clean();

echo "character: ".$data["character"]."\n";
echo "corporation: ".$data["corporation"]."\n";
echo "alliance: ".$data["alliance"]."\n";
echo "hull: ".$data["hull"]."\n";
echo "type: ".$data["type"]."\n";
echo "system: ".$data["system"]."\n";
echo "security: ".$data["security"]."\n";
echo "region: ".$data["region"]."\n";
echo "isk_dropped: ".$data["isk_dropped"]."\n";
echo "isk_total: ".$data["isk_total"]."\n";
echo "date: ".$data["date"]."\n\n\n";
echo "Saved html to last_html.txt";

file_put_contents('last_html.txt', $rendered);