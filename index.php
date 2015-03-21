<?php

/**
 * Define the teams and their number
 * of entries into the draft raffle.
 */
$teams = [
	'Team 1' => 12, // Team 1 has 12 of the 42 entries, or a 28% chance of the 1st pick
	'Team 2' => 12,
	'Team 3' => 10,
	'Team 4' => 8
];

/**
 * Calculate the odds for the draft
 *
 * @param $entries
 */
function getDraftOdds( $entries )
{
	// Calculate the total number of entries
	$total = 0;
	foreach ( $entries as $key => $value ) {
		$total += $value;
	}

	// Calculate and output the odds for each user
	foreach ( $entries as $key => $value ) {
		$percent = ( $value / $total ) * 100;
		echo '<tr><td>' . round( $percent, 2 ) . '%</td><td>' . $key . '</td></tr>';
	}
}

/**
 * Output the list of teams and odds
 *
 * @param $entries
 *
 * @return int|string
 */
function generateDraftOrder( $entries )
{
	// Calculate the total number of entries
	$total = 0;
	foreach ( $entries as $key => $value ) {
		$total += $value;
	}

	// Get the number range for each potential winner
	$entry = 0;
	$pot   = [ ];
	foreach ( $entries as $key => $value ) {
		$entry += $value;
		$pot[ $key ] = $entry;
	}

	// Generate a random number that falls in this range
	$winner = rand( 1, $total );

	// Choose the winner from the entries
	foreach ( $pot as $key => $value ) {
		if ( $winner <= $value ) {
			return $key;
		}
	}
}

?>
<html>
<head>
	<title>Fantasy Football Draft Lottery</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>

<body>
<div class="container">
	<h1><?= date( 'Y' ) ?> Fantasy Draft Lottery Results</h1>
	<table class="table table-bordered table-striped ">
		<thead>
		<tr>
			<th>Odds for 1st pick</th>
			<th>Name</th>
		</tr>
		</thead>
		<tbody>
		<?= getDraftOdds( $teams ); ?>
		</tbody>
	</table>

	<div class="well">
		<h3>The Results:</h3>
		<ol>
			<?php
			foreach ( range( 1, count( $teams ) ) as $team ) {
				$spot = generateDraftOrder( $teams );
				echo '<li>' . $spot . '</li>';
				unset( $teams[ $spot ] );
			}
			?>
		</ol>
	</div>
</div>
</body>
</html>