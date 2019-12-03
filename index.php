<?php

if(!empty($_GET['ingredient'])){
	if(isset($_GET['ingredient'])){
		$ingredient = urlencode($_GET['ingredient']);
	}

	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => "https://yummly2.p.rapidapi.com/feeds/search?q=$ingredient&start=0&maxResult=18",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"x-rapidapi-host: yummly2.p.rapidapi.com",
		"x-rapidapi-key: f8c206af06mshb3edd74d202913bp19fd40jsn69e13e3e8069"
	),
));

$response = json_decode(curl_exec($curl),true);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
}

}

?>

<html>
	<head>
	<LINK href="style.css" rel="stylesheet" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href='https://fonts.googleapis.com/css?family=Playball' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<header>
			TadaRecipe
		</header>

		<form action="" method="get">
			<div>
				<label for="ingredient">INGREDIENT</label>
				<input type="text" id="ingredient" name="ingredient" required>
			</div>

			<div>
				<button type="submit" name="query" id="search">Search for Recipe</button>
			</div>
		</form>

		<?php if (isset($_GET['ingredient']) && empty($response['feed'])):?>
		<p class="no-recipe">We couldn't find any recipe for the query. Try again with fewer ingredients or different ingredients combination.</p>
		<?php elseif (empty($_GET['ingredient']) && empty($response['feed'])) :?>
		<p class="no-recipe">Find recipes with any ingredients you want to add.</p>
		<?php else :?>
		<?php foreach($response['feed'] as $recipe):?>
		<div class="meal-block">
			<h3 class="meal_name"><?php echo $recipe['display']['displayName'];?></h3>
			<img src="<?php echo $recipe['display']['images'][0];?>" alt=""><br>
			<h5>Ingredients</h5>
			<p class="ingredient">
				<?php foreach ($recipe['content']['ingredientLines'] as $ingredient):?>
					<?php echo $ingredient['wholeLine'];?><br><br>
				<?php endforeach ;?>
			</p>
			<h5>Steps:</h5>
			<p class="step">
				<?php foreach ($recipe['content']['preparationSteps'] as $step):?>
				-<?php echo $step;?><br><br>
				<?php endforeach ;?>
			</p>
			<hr>
		</div>
		<?php endforeach ;?>
		<?php endif ;?>
	</body>
</html>