/* example form using purecss. */

<h3>Article Search</h3>
<div class="viewArtNormForm">
  <form class="pure-form" method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?link=searchArtNorm'; ?>">
    <input id="searchTerm" name="searchTerm" type="text" class="pure-input-rounded pure-input-1-3"" placeholder="e.g. Nanoparticles">
    <button type="submit" class="pure-button pure-button-primary">Search</button>
  </form>
</div>
<p style="text-align: justify;">The search is based on <a href="http://search.labs.crossref.org" target="_blank">CrossRef API</a>. Some articles/books may not show. I have not included pagination yet. Therefore, only the first 20 articles show while there can be well over 4000.</p>
<?php

if(!empty($_POST['searchTerm'])) {
	$searchTerm = str_replace(" ", "+", $_POST['searchTerm']); 
	
	// header=true provides extra data such as total records found so that you can include pagination
	// will add a pagination example in future
	$url = "http://search.labs.crossref.org/dois?q=".$searchTerm."&header=true";
	
	// curl downloads html there are alternative ways this requires curl to be enabled in php.ini		
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_REFERER, "jessequinn.info");
	$body = curl_exec($ch);
	curl_close($ch);
		
	$json = json_decode($body);
	//var_dump($json);
	
	$totalResults = $json->totalResults;
	//echo $totalResults;
	foreach($json->items as $article) {
		echo '<p style="text-align: justify;"><a href="'.$article->doi.'" target="_blank">'.$article->fullCitation.'</a></p>';
	}
}

?>
