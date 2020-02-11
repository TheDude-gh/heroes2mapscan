<?php
class VICTORY {
		const NONE = 0;
		const CAPTURETOWN = 1;
		const DEFEATHERO = 2;
		const ARTIFACT = 3;
		const ALLIED = 4;
		const GOLD = 5;
	}

	class LOSS {
		const NONE = 0;
		const TOWN = 1;
		const HERO = 2;
		const TIME = 3;
	}

	$VICTORY = [
		VICTORY::NONE => 'Standard',
		VICTORY::CAPTURETOWN => 'Capture a specific town',
		VICTORY::DEFEATHERO => 'Defeat a specific Hero',
		VICTORY::ARTIFACT => 'Acquire a specific artifact',
		VICTORY::ALLIED => 'Your side defeats the opposing side',
		VICTORY::GOLD => 'Accumulate gold',
	];

	$LOSS = [
		LOSS::NONE => 'None',
		LOSS::TOWN => 'Lose a specific town',
		LOSS::HERO => 'Lose a specific hero',
		LOSS::TIME => 'Time expire',
	];


?>
