<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Football teams gen</title>
        <link rel="stylesheet" href="assets/css/core.css">
        <link rel="author" href="humans.txt">
    </head>
    <body>
	<?php
		require_once('core/TeamMaker.php');
		require_once('fake-db.php');

		$players = [$alex, $ian, $dom, $ed, $rolf, $hunt, $aurelio, $ben, $sam, $patrick];
		
		shuffle($players);

		$teamMaker = new TeamMaker($players);
		$teams = $teamMaker->makeTeams();
	?>
	     <div class="pitch">
	     	<div class="team team1">
	     		<h2>Attack: <?=$teams[0]->level()['attack'];?> | Defence: <?=$teams[0]->level()['defence'];?> </h2>
	     		<ul>
	     		<?php
		     		foreach ($teams[0]->players as $player) {
						echo '<li>' . $player->name . '</li>';
					}
				?>
	     		</ul>
	     	</div>
	     	<div class="team team2">
	     		<h2>Attack: <?=$teams[1]->level()['attack'];?> | Defence: <?=$teams[1]->level()['defence'];?> </h2>
	     		<ul>
	     		<?php
		     		foreach ($teams[1]->players as $player) {
						echo '<li>' . $player->name . '</li>';
					}
				?>
	     		</ul>
	     	</div>
	     	<a class="reload-teams" href="javascript:location.reload()">Reload teams</a>
	     </div>
    </body>
</html>