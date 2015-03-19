<?php 
include_once("arc2-master/ARC2.php");

$config = array(
  /* db */
  'db_name' => 'sundlproduction',
  'db_user' => 'root',
  'db_pwd' => '',
  /* store */
  'store_name' => 'arc_tests',
  /* stop after 100 errors */
  'max_errors' => 100,
);

$store = ARC2::getStore($config);

/* LOAD will call the Web reader, which will call the
format detector, which in turn triggers the inclusion of an
appropriate parser, etc. until the triples end up in the store. */
$store->query('LOAD <http://dbpedia.org/page/Sweetgrass_(film)>');


if (!$store->isSetUp()) {
  $store->setUp();
}

/* list names */
$query = '
  PREFIX foaf: <http://xmlns.com/foaf/0.1/> .

PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX foaf: <http://xmlns.com/foaf/0.1/>
PREFIX dc: <http://purl.org/dc/elements/1.1/>
PREFIX : <http://dbpedia.org/resource/>
PREFIX dbpedia2: <http://dbpedia.org/property/>
PREFIX dbpedia: <http://dbpedia.org/>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX category: <http://dbpedia.org/resource/Category:>

SELECT DISTINCT str(?lang) str(?desc) str(?filmn) str(?datum) str(?autor)
WHERE  {?x dbpedia-owl:abstract ?desc . FILTER (langMatches(lang(?desc),"en")) . 
  ?x dbpprop:language ?lang . FILTER (langMatches(lang(?lang), "en")) . 
  ?x dbpprop:name ?filmn . FILTER (langMatches(lang(?filmn), "en")) . 
  ?x dbpedia-owl:releaseDate ?datum . FILTER ( ?datum >= "1000"^^xsd:date  ) . 
  ?x dbpprop:producer ?autor . FILTER (langMatches(lang(?autor), "en")) .
  {?x dcterms:subject category:American_films} 
  UNION {?x dcterms:subject category:English-language_films}  
}

';
/*$film = new Film();
$film->beschreibung = '?desc';
$film->sprache = '?lang';
$film->titel ='?filmn';
$film->producer = '?autor';
$film->datum ='?datum';
$film->save(); */
$result = $store->query($query);
$rows = $result["result"]["rows"];
if ($rows) {
print "<table border='1'>\n";
print "<tr><th>Properties currently in use in the triple store</th></tr>\n";
foreach ($rows as $row) {
$item = $row["property"];
if (strpos($item, "http://www.w3.org/1999/02/22-rdf-syntax-ns#_") !== 0) {
print "<tr><td>" . htmlspecialchars($item) . "</td></tr>\n";
}
}
print "</table>\n";
} else {
print "<strong>The ARC2 triple store is currently empty.\n";
print "Please load some data first.</strong>";
}
?>

<html>
<head>
</head>
<body>
  <form action="/tidbit/public/tidbit/login" method='post'>
    <label>Login</label>
    <input type="text" name="user" />
    <input type="password" name="passwort" />
    <input type="submit" value="login" />
</form>
@if(Auth::user())
User: {{Auth::user()->username}}

<form action="/tidbit/public/logout">
    <input type="submit" value="logout">
</form>
@endif
</body>
</html>