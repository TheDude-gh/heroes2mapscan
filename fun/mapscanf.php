<?php

class H2MAPSCAN {
	const IMGSIZE = 576;
	const H2O = 0x5c; //heroes 2 original
	const POL  = 0xff; //price of loyalty arbitrary value 0xff, actually the same 5C, POL depends on some other data and extension

	private $version = '';
	private $versionname = '';
	private $map_name = '';
	private $description = '';
	private $language = 0;
	private $map_diff = -1;     //difficulty
	private $map_diffname = ''; //difficulty name
	private $teamscount = 1;
	private $teams = array();
	private $victoryCond = array();
	private $lossCond = array();
	private $victoryInfo = '';
	private $lossInfo = '';

	private $rumors = array();
	private $events = array();

	private $objects = array();
	private $objects_unique = array();
	private $objectsX = array(); //objects tileindexes

		//object of interest lists
	private $artifacts_list = array();
	private $heroes_list = array();
	private $towns_list = array();
	private $mines_list = array();
	private $monsters_list = array();
	private $signs_list = array();
	private $events_list = array();
	private $sphinxs_list = array();

	//curent object being read and its coords
	private $curobj;
	private $curcoor;
	private $curowner;

	private $mapobjects = array(); //heroes, towns and monsters

	private $map_size = 0;
	private $map_sizename = '';
	private $terrain = array();
	private $special_access = 0; //draw special tiles on map image

	private $img;
	private $imgcolors = array();

	private $name = '';

	private $mapdata = '';
	private $mapfile = '';
	private $mapfilename = '';
	private $mapfileout = '';
	private $mapimage; //mapfile name for DB

	private $players = array();
	private $mapplayersnum = 0;
	private $mapplayershuman = 0;
	private $mapplayersai = 0;
	private $obeliskNum = 0;

	private $CS; //heroes constants class
	private $SC; //String Convert

	private $printoutput = false;
	private $webmode = true;
	private $buildMapImage = true;

	private $debug;

	private $pos = 0;
	private $length = 0;

	private $filemtime = '';
	private $filectime = '';
	private $filesize = 0;
	private $filebad = false;

	private $save = false; //save maps to db


	public function __construct($mapfile, $webmode) {
		$this->webmode = $webmode;
		$this->printoutput = $webmode;

		$this->mapfile = $mapfile;
		$path = pathinfo($this->mapfile);

		if(!file_exists($this->mapfile)) {
			echo $this->mapfile.' does not exists!'.ENVE;
			$this->filebad = true;
			return false;
		}

		$this->mapfilename = $path['filename'];
		$this->version = (strcasecmp($path['extension'], 'MP2') == 0) ? $this::H2O : $this::POL;

		$this->filesize  = filesize($this->mapfile);
		$this->filemtime = filemtime($this->mapfile);
		$this->filectime = filectime($this->mapfile);

		$this->mapdata = file_get_contents($this->mapfile);
		$this->length = strlen($this->mapdata);
	}

	public function SetSaveMap($value) {
		$this->save = $value;
	}

	public function SaveMap() {
		$mappi = pathinfo($this->mapfile);
		$mapfile = mes($mappi['basename']);


		$sql = "SELECT m.mapfile FROM heroes_maps AS m WHERE m.mapfile='$mapfile'";
		$mapdb = mgr($sql);
		if($mapdb) {
			return;
		}

		$mapdir = mes($mappi['dirname']);
		$mapname = mes($this->map_name);
		$mapdesc = mes($this->description);
		$mapimage = mes($this->mapimage);

		$sql = "INSERT INTO heroes2_maps (`mapfile`, `mapdir`, `mapname`, `mapdesc`, `version`, `size`, `sizename`, `diff`,
			`playersnum`, `playhuman`, `playai`, `teamnum`, `victory`, `loss`, `filecreate`, `filechanged`, `filesize`,
			`mapimage`) VALUES
			('$mapfile', '$mapdir/', '$mapname', '$mapdesc', '".$this->versionname."', ".$this->map_size.", '".$this->map_sizename."',
				'".$this->map_diffname."', ".$this->mapplayersnum.", ".$this->mapplayershuman.", ".$this->mapplayersai.",
				".$this->teamscount.", ".$this->victoryCond['type'].", ".$this->lossCond['type'].",
			FROM_UNIXTIME(".$this->filectime."), FROM_UNIXTIME(".$this->filemtime."), ".$this->filesize.", '".$mapimage."')";
		mq($sql);
	}

	public function PrintStateSet($enable, $mapbuild = true, $special = false) {
		$this->printoutput = $enable ? true : false;
		$this->buildMapImage = $mapbuild ? true : false;
		$this->special = $special ? true : false;
	}

	public function PrintMapInfo() {
		$this->ParseFinish();

		echo '<table>
				<tr><th></th><th>'.$this->mapfilename.'</th></tr>
				<tr><td>Name</td><td>'.$this->map_name.'</td></tr>
				<tr><td>Description</td><td>'.nl2br($this->description).'</td></tr>
				<tr><td>Version</td><td>'.$this->versionname.'</td></tr>
				<tr><td>Size</td><td>'.$this->map_sizename.'</td></tr>
				<tr><td>Difficulty</td><td>'.$this->map_diffname.'</td></tr>
				<tr><td>Victory</td><td>'.$this->victoryInfo.'</td></tr>
				<tr><td>Loss</td><td>'.$this->lossInfo.'</td></tr>
				<tr><td>Players count</td><td>'.$this->mapplayersnum.', '.$this->mapplayershuman.'/'.$this->mapplayersai.'</td></tr>
				<tr><td>Team count</td><td>'.$this->teamscount.'</td></tr>
			</table>';

			$this->DisplayMap();

			echo '<table class="smalltable">
				<tr>
					<th>Players</th>
					<th>Colour</th>
					<th>Human</th>
					<th>AI</th>
					<th>Team</th>
					<th>Town count</th>
					<th>Owned towns</th>
					<th>Random town</th>
					<th>Town coords</th>
					<th>Heroes count</th>
					<th>Heroes names</th>
				</tr>';


			foreach($this->players as $k => $player) {
				if(!$player['human'] && !$player['ai']) continue;

				$team = '';
				if($this->teamscount > 1) {
					$team = in_array($k, $this->teams[0]) ? 1 : 2;
				}

				echo '<tr>
						<td>'.($k + 1).'</td>
						<td>'.$this->CS->PlayersColours[$k + 1].'</td>
						<td class="ac">'.$player['human'].'</td>
						<td class="ac">'.$player['ai'].'</td>
						<td class="ac">'.$team.'</td>
						<td class="ar">'.$player['townsOwned'].'</td>
						<td>'.$player['towns_allowed'].'</td>
						<td class="ar">'.$player['IsRandomTown'].'</td>
						<td>'.$player['townpos']->GetCoords().'</td>
						<td class="ar">'.$player['HeroCount'].'</td>
						<td>'.implode($player['HeroName'], ', ').'</td>
					</tr>';
			}
			echo '</table>';

			//towns list
			usort($this->towns_list, 'ListSortByName');
			$n = 0;
			echo '
				<table class="smalltable">
					<tr><th>Castles</th><th>Name</th><th>Position</th><th>Owner</th><th>Type</th><th>Troops</th></tr>';
			foreach($this->towns_list as $town) {
				echo '<tr>
					<td>'.(++$n).'</td>
					<td>'.$town->name.'</td>
					<td>'.$town->mapcoor->GetCoords().'</td>
					<td>'.$town->owner.'</td>
					<td>'.$town->info.'</td>
					<td>'.$this->PrintTroops($town->count).'</td>
				</tr>';
			}
			echo '</table>';

			$n = 0;
			echo '
				<table class="smalltable">
					<tr><th>Heroes</th><th>Name</th><th>Position</th><th>Race</th><th>Owner</th><th>Experience</th>
					<th>Patrol</th><th>Artifacts</th><th>Troops</th></tr>';
			foreach($this->heroes_list as $hero) {
				$artifacts = array_key_exists('Artifacts', $hero['data']) ? implode($hero['data']['Artifacts'], ', ') : '';
				$troops = array_key_exists('troops', $hero['data']) ? $this->PrintTroops($hero['data']['troops']) : '';
				echo '<tr>
					<td>'.(++$n).'</td>
					<td>'.$hero['data']['name'].'</td>
					<td>'.$hero['coor']->GetCoords().'</td>
					<td>'.$hero['data']['race'].'</td>
					<td>'.$hero['data']['color'].'</td>
					<td>'.$hero['data']['exp'].'</td>
					<td>'.$hero['data']['patrol'].' : '.$hero['data']['radius'].'</td>
					<td>'.$artifacts.'</td>
					<td>'.$troops.'</td>
				</tr>';
			}
			echo '</table>';

			//mines list
			usort($this->mines_list, 'ListSortByName');
			$n = 0;
			echo '
				<table class="smalltable">
					<tr><th>Mines</th><th>Name</th><th>Position</th><th>Owner</th></tr>';
			foreach($this->mines_list as $mine) {
				$owner = $mine->owner;
				echo '<tr>
					<td>'.(++$n).'</td>
					<td>'.$mine->name.'</td>
					<td>'.$mine->mapcoor->GetCoords().'</td>
					<td>'.$owner.'</td>
				</tr>';
			}
			echo '</table>';

			//artifact list
			usort($this->artifacts_list, 'ListSortByName');
			$n = 0;
			echo '
				<table class="smalltable">
					<tr><th>Artifacts</th><th>Name</th><th>Position</th><th>Parent</th></tr>';
			foreach($this->artifacts_list as $art) {
				echo '<tr>
					<td>'.(++$n).'</td>
					<td>'.$art->name.'</td>
					<td>'.$art->mapcoor->GetCoords().'</td>
					<td>'.$art->parent.'</td>
				</tr>';
			}
			echo '</table>';


			//monster list
			usort($this->monsters_list, 'ListSortByName');
			$n = 0;
			echo '
				<table class="smalltable">
					<tr><th>Monsters</th><th>Name</th><th>Count</th><th>Position</th><th>Parent</th></tr>';
			foreach($this->monsters_list as $mon) {
				echo '<tr>
					<td>'.(++$n).'</td>
					<td>'.$mon->name.'</td>
					<td>'.$mon->count.'</td>
					<td>'.$mon->mapcoor->GetCoords().'</td>
					<td>'.$mon->parent.'</td>
				</tr>';
			}
			echo '</table>';


			//sphinx list
			$n = 0;
			echo '
				<table class="smalltable">
					<tr><th>Sphinx</th><th>Riddle</th><th>Answers</th><th>Position</th><th colspan="2">Reward</th></tr>';
			foreach($this->sphinxs_list as $sph) {
				echo '<tr>
					<td>'.(++$n).'</td>
					<td>'.$sph->parent.'</td>
					<td>'.$sph->owner.'</td>
					<td>'.$sph->mapcoor->GetCoords().'</td>
					<td>'.$sph->count.'</td>
					<td>'.$sph->info.'</td>
				</tr>';
			}
			echo '</table>';


			//signs, bottles
			$n = 0;
			echo '
				<table class="smalltable"><tr><th colspan="2">Signs and bottles</th><th>Text</th><th>Position</th></tr>';
			foreach($this->signs_list as $sign) {
				echo '<tr>
					<td>'.(++$n).'</td>
					<td>'.$sign->name.'</td>
					<td>'.$sign->parent.'</td>
					<td>'.$sign->mapcoor->GetCoords().'</td>
				</tr>';
			}
			echo '</table>';


			//rumors
			echo '
				<table class="smalltable">
					<tr><th colspan="2">Rumors</th></tr>';
			if(empty($this->rumors)) {
				echo '<tr><td colspan="2">None</td></tr>';
			}

			foreach($this->rumors as $k => $rumor) {
				echo '<tr>
					<td>'.($k+1).'</td>
					<td>'.$rumor.'</td>
				</tr>';
			}
			echo '</table>';

			usort($this->events, 'EventSortByDate');
			echo '
				<table class="smalltable">
					<tr><th>Events</th><th>AI</th><th>Players</th><th>First</th><th>Interval</th>
						<th>Resources</th><th>Message</th></tr>';
			foreach($this->events as $k => $event) {
				echo '<tr>
					<td>'.($k+1).'</td>
					<td>'.$event['aiAble'].'</td>
					<td>'.($event['players']).'</td>
					<td>'.$event['first'].'</td>
					<td>'.$event['interval'].'</td>
					<td>'.$this->PrintResources($event['resources']).'</td>
					<td>'.nl2br($event['message']).'</td>
				</tr>';
			}
			echo '</table>';

			echo '<br />Unique objects count: '.count($this->objects_unique);
			asort($this->objects_unique);
			$n = 0;
			echo '
				<table class="smalltable">
					<tr><th>Objects</th><th>ID</th><th>Name</th><th>Count</th></tr>';
			foreach($this->objects_unique as $objid => $obju) {
				echo '<tr>
					<td>'.(++$n).'</td>
					<td>'.$objid.'</td>
					<td>'.$obju['name'].'</td>
					<td>'.$obju['count'].'</td>
				</tr>';
			}
			echo '</table>';
	}

	public function ReadMap() {
		if($this->filebad) {
			return;
		}

		$this->SetPos(0);
		$this->CS = new HeroesConstants();
		$this->SC = new StringConvert();

		$version = $this->ReadUint32(); //all the same

		if($version != $this::H2O) {
			echo 'Invalid version, file is probably not a Heroes II map';
			$this->filebad = true;
			return;
		}

		$this->map_diff = $this->ReadUint16();

		$width = $this->ReadUint8();
		$height = $this->ReadUint8();

		$this->map_size = $width;

		$this->GetVersionName();
		$this->GetMapSize();
		$this->GetDifficulty();

		// kingdom color - blue, green, red, yellow, orange, purple
		for($i = 0; $i < PLAYERSNUM; $i++) {
			if($this->ReadUint8()) {
				$this->mapplayersnum++;
				$this->players[$i] = array();
			}
		}

		//players default data after we read what players are present
		foreach($this->players as $k => $player) {
			$this->players[$k]['human'] = 0;
			$this->players[$k]['ai'] = 0;
			$this->players[$k]['townsOwned'] = 0;
			$this->players[$k]['towns_allowed'] = 0;
			$this->players[$k]['IsRandomTown'] = 0;
			$this->players[$k]['townpos'] = new MapCoords();
			$this->players[$k]['HeroCount'] = 0;
			$this->players[$k]['HeroName'] = array();
		}

		for($i = 0; $i < PLAYERSNUM; $i++) {
			if($this->ReadUint8()) {
				$this->mapplayershuman++;
				$this->players[$i]['human'] = 1;
			}
		}

		for($i = 0; $i < PLAYERSNUM; $i++) {
			if($this->ReadUint8()) {
				$this->mapplayersai++;
				$this->players[$i]['ai'] = 1;
			}
		}

		// Special Victory Condition
		$this->VictoryCondition();
		// Special loss condition
		$this->LossCondition();

		// start with hero
		$this->SetPos(0x25);
		$with_heroes = ($this->ReadUint8() == 0);

		for($i = 0; $i < PLAYERSNUM; $i++) {
			$race = $this->ReadUint8();
			if(array_key_exists($i, $this->players)) {
				$this->players[$i]['towns_allowed'] = $this->CS->TownType[$race];
			}
		}

		// name
		$this->SetPos(0x3a);
		$this->map_name = $this->ReadString(LENGTHNAME);

		// description
		$this->SetPos(0x76);
		$this->description = $this->ReadString(LENGTHDESCRIPTION);

		$this->ReadTerrain();

		$this->ReadCastles();
		$this->Mines();

		$this->FinalBlocks();

		if($this->buildMapImage) {
			$this->BuildMap();
		}

		if($this->printoutput && $this->webmode) {
			$this->PrintMapInfo();
		}

		if($this->save == true){
			$this->SaveMap();
		}
	}

	private function ReadCastles() {
		// 72 x 3 byte (cx, cy, id)

		//we can get castle info from FinalBlocks function, so we can just skip this
		$this->SkipBytes(216);
		return;

		for($i = 0; $i < CASTLEBLOCK; $i++) {

			$cx = $this->ReadUint8();
			$cy = $this->ReadUint8();
			$id = $this->ReadUint8();

			// empty block
			if($cx == OWNNOONE && $cy == OWNNOONE) {
				continue;
			}

			$town = array();
			switch($id) {
				case 0x00: // tower: knight
				case 0x80: // castle: knight
					$town['type'] = TOWNTYPE::KNIGHT;
					break;

				case 0x01: // tower: barbarian
				case 0x81: // castle: barbarian
					$town['type'] = TOWNTYPE::BARBAR;
					break;

				case 0x02: // tower: sorceress
				case 0x82: // castle: sorceress
					$town['type'] = TOWNTYPE::SORCERESS;
					break;

				case 0x03: // tower: warlock
				case 0x83: // castle: warlock
					$town['type'] = TOWNTYPE::WARLOCK;
					break;

				case 0x04: // tower: wizard
				case 0x84: // castle: wizard
					$town['type'] = TOWNTYPE::WIZARD;
					break;

				case 0x05: // tower: necromancer
				case 0x85: // castle: necromancer
					$town['type'] = TOWNTYPE::NECROMANCER;
					break;

				case 0x06: // tower: random
				case 0x86: // castle: random
					$town['type'] = TOWNTYPE::RANDOM;
					break;

				default:
					continue;
			}

			$town['coor'] = new MapCoords($cx, $cy);
			$town['name'] = 'Castle N';
			$town['player'] = OWNNOONE;
			$town['race'] = $this->CS->TownType[$town['type']];
			$town['objid'] = OBJECTS::OBJ_CASTLE;

			$this->objects[] = $town;
		}
	}

	private function Mines() {
		// 144 x 3 byte (cx, cy, id)

		for($i = 0; $i < MINEBLOCK; $i++) {
			$cx = $this->ReadUint8();
			$cy = $this->ReadUint8();
			$id = $this->ReadUint8();

			// empty block
			if($cx == OWNNOONE && $cy == OWNNOONE) {
				continue;
			}

			$mine = array();
			$ismine = true;
			switch($id) {
				// wood
				case 0x00:
					$mine['objid'] = OBJECTS::OBJ_SAWMILL;
					$mine['name'] = $this->CS->Mines[$id];
					break;
				// mercury
				case 0x01:
					$mine['objid'] = OBJECTS::OBJ_ALCHEMYLAB;
					$mine['name'] = $this->CS->Mines[$id];
					break;
				// ore
				case 0x02:
					$mine['objid'] = OBJECTS::OBJ_MINES;
					$mine['name'] = $this->CS->Mines[$id];
					break;
				// sulfur
				case 0x03:
					$mine['objid'] = OBJECTS::OBJ_MINES;
					$mine['name'] = $this->CS->Mines[$id];
					break;
				// crystal
				case 0x04:
					$mine['objid'] = OBJECTS::OBJ_MINES;
					$mine['name'] = $this->CS->Mines[$id];
					break;
				// gems
				case 0x05:
					$mine['objid'] = OBJECTS::OBJ_MINES;
					$mine['name'] = $this->CS->Mines[$id];
					break;
				// gold
				case 0x06:
					$mine['objid'] = OBJECTS::OBJ_MINES;
					$mine['name'] = $this->CS->Mines[$id];
					break;

				// lighthouse
				case 0x64:
					$ismine = false;
					$mine['objid'] = OBJECTS::OBJ_LIGHTHOUSE;
					break;
				// dragon city
				case 0x65:
					$ismine = false;
					$mine['objid'] = OBJECTS::OBJ_DRAGONCITY;
					break;
				// abandoned mines
				case 0x67:
					$ismine = false;
					$mine['objid'] = OBJECTS::OBJ_ABANDONEDMINE;
					break;
				default:
					break;
			}

			$mine['coor'] = new MapCoords($cx, $cy);
			$mine['player'] = OWNNOONE;
			if($ismine) {
				/* prepare tile access for mines
					xox
				*/

				$x0 = $cx;
				$y0 = $cy;
				$xm = ($mine['objid'] == OBJECTS::OBJ_SAWMILL) ? $x0 - 2 : $x0 - 1;
				$xx = $x0 + 1;
				$ym = $y0;
				for($x = $xm; $x <= $xx; $x++) {
					for($y = $ym; $y <= $y0; $y++) {
						if($x == $x0 || ($x < 0 || $y < 0 || $x > $this->map_size|| $y > $this->map_size)) {
							continue;
						}
						$this->terrain[$y][$x]->owner = COLORS::NONE;
					}
				}

				$this->mines_list[] = new Listobject($mine['name'], $mine['coor'], '', OWNERNONE, 0, $id);
				if($this->special_access) {
					$this->terrain[$cy][$cx]->special = MAPSPECIAL::MINE; //special color for mine access tile
				}
				else {
					$this->terrain[$cy][$cx]->owner = COLORS::NONE;
				}
			}

			$this->objects[] = $mine;
		}
	}

	private function FinalBlocks() {

		$this->SkipBytes(1); //obelisks count, but we count them in another place, so skip this

		//final blocks
		while(true) {
			$l = $this->ReadUint8();
			$h = $this->ReadUint8();
			if($h == 0 && $l == 0) {
				break;
			}
			else {
				$countblock = 256 * $h + $l - 1;
			}
		}

		// castle or heroes or (events, rumors, etc)
		for($i = 0; $i < $countblock; $i++) {
			$findobject = -1;
			// read block
			$blocksize = $this->ReadUint16();

			//get object tileindex based on some magic
			foreach($this->objectsX as $tileindex) {
				$x = $tileindex % $this->map_size;
				$y = ($tileindex - $x) / $this->map_size;
				$cell = $this->terrain[$y][$x];

				$orders = ($cell->quantity2 << 8) | $cell->quantity1;
				if($orders && !($orders % 0x08) && ($i + 1 == $orders / 0x08)) {
					$findobject = $tileindex;
				}
			}

			//valid tileindex
			if($findobject >= 0) {
				$x = $findobject % $this->map_size;
				$y = ($findobject - $x) / $this->map_size;
				$cell = $this->terrain[$y][$x];

				$obj = array();
				$obj['objid'] = $cell->generalObject;
				$obj['name'] = $this->GetObjectById($obj['objid']);
				$obj['coor'] = new MapCoords($x, $y);
				$this->curcoor = $obj['coor'];

				switch($obj['objid']) {
					case OBJECTS::OBJ_CASTLE:
					case OBJECTS::OBJ_RNDTOWN:
					case OBJECTS::OBJ_RNDCASTLE:
						// add castle
						if(SIZEOFMP2CASTLE != $blocksize) {
							echo 'Wrong castle size '.$blocksize;
							$this->SkipBytes($blocksize);
							continue;
						}
						$obj['data'] = $this->ReadCastle();
						$this->terrain[$y][$x]->owner = $obj['data']['owner'];
						break;

					case OBJECTS::OBJ_JAIL:
					case OBJECTS::OBJ_HEROES:
						if(SIZEOFMP2HEROES != $blocksize) {
							echo 'Wrong hero size';
							$this->SkipBytes($blocksize);
							continue;
						}
						$obj['data'] = $this->ReadHero($obj['objid'], $cell->indexName1);
						$this->terrain[$y][$x]->owner = $obj['data']['owner'];
						$this->heroes_list[] = $obj;
						break;

					case OBJECTS::OBJ_SIGN:
					case OBJECTS::OBJ_BOTTLE:
						$this->curobj = $obj['objid'];
						$obj['data'] = $this->ReadSignBottle($blocksize);
						break;

					case OBJECTS::OBJ_EVENT:
						$obj['data'] = $this->ReadEvent($blocksize);
						break;

					case OBJECTS::OBJ_SPHINX:
						$obj['data'] = $this->ReadSphinx($blocksize);
						break;


				} //switch end

				//not really needed to save all objects to one array, not used anywhere
				//$this->objects[] = $obj;

			}
			else {
				$rumorcheck = $this->ReadByteRelPos(8);
				$eventcheck = $this->ReadByteRelPos(42);
				// add event day
				if($blocksize > (SIZEOFMP2EVENT - 1) && $eventcheck == 1) {
					$this->events[] = $this->ReadEventDay($blocksize);
				}
				// add rumors
				elseif($blocksize > (SIZEOFMP2RUMOR - 1) && $rumorcheck) {
					$this->SkipBytes(8);
					$this->rumors[] = $this->ReadString($blocksize - 8);
				}
				else {
					//if no valid or empty object, skip full block
					$this->SkipBytes($blocksize);
				}
			}

		}
	}

	private function ReadCastle() {
		$castle = array();

		$player = $this->ReadUint8(); //0-5
		$color = $player + 1; //0 + 1-6
		if($player > 5) {
			$color = COLORS::NONE;
		}
		else {
			$this->players[$player]['townsOwned']++;
			$this->players[$player]['townpos'] = $this->curcoor;
		}
		$castle['owner'] = $color;
		$castle['player'] = $this->CS->PlayersColours[$color];

		/* add owner to the castle tiles and access
				xxx
				xxoxx
		*/

		$x0 = $this->curcoor->x;
		$y0 = $this->curcoor->y;
		$xm = $x0 - 2;
		$xx = $x0 + 2;
		$ym = $y0 - 1;
		for($x = $xm; $x <= $xx; $x++) {
			for($y = $ym; $y <= $y0; $y++) {
				if($y == $ym && ($x == $xm || $x == $xx)) continue;
				$this->terrain[$y][$x]->owner = $color;
			}
		}

		// custom building
		$customBuildings = $this->ReadUint8();
		if($customBuildings) {
			// building
			$build = $this->ReadUint16();
			// dwelling
			$dwelling = $this->ReadUint16();

			//detailed building info skipped, just show bits
			$castle['buildings'] = $this->bvar($build);
			$castle['dwelling'] = $this->bvar($dwelling);

			// magic tower
			$castle['mageguild'] = $this->ReadUint8();
		}
		else {
			$this->SkipBytes(5);
		}

		// custom troops
		$castle['troops'] = array();
		$custom_troops = $this->ReadUint8();
		if($custom_troops) {
			$castle['troops'] = $this->ReadTroops();
		}
		else {
			$this->SkipBytes(15);
		}

		// captain
		$castle['captain'] = $this->ReadUint8();

		// custom name, read always, since some default name is saved anyway
		$this->SkipBytes(1);
		$castle['Name'] = $this->ReadString(13);

		// race
		$towntype = $this->ReadUint8();
		if($towntype > 5) {
			$towntype = TOWNTYPE::RANDOM;
		}
		$castle['type'] = $this->GetTownById($towntype);

		// castle
		$castle['Fort'] = $this->ReadUint8();

		// allow upgrade to castle (0 - true, 1 - false)
		$castle['AllowUpgrade'] = ($this->ReadUint8() == 0);

		// unknown
		$this->SkipBytes(29);

		$this->towns_list[] = new Listobject($castle['Name'], $this->curcoor, '', $castle['player'], $castle['troops'], $castle['type']);

		return $castle;
	}

	private function ReadHero($objid, $affiliation) {
		$hero = array();
		$hero['name'] = 'Random';

		$color = COLORS::NONE;
		if($objid != OBJECTS::OBJ_JAIL) {
			if($affiliation < 7) {
				$color = COLORS::BLUE;
			}
			elseif($affiliation < 14) {
				$color = COLORS::GREEN;
			}
			elseif($affiliation < 21) {
				$color = COLORS::RED;
			}
			elseif($affiliation < 28) {
				$color = COLORS::YELLOW;
			}
			elseif($affiliation < 35) {
				$color = COLORS::ORANGE;
			}
			else {
				$color = COLORS::PURPLE;
			}
			$this->players[$color - 1]['HeroCount']++;
		}
		$hero['owner'] = $color;
		$hero['color'] = $this->CS->PlayersColours[$color];
		$hero['race'] = 0; //later

		// unknown
		$this->SkipBytes(1);

		// custom troops
		$hastroops = $this->ReadUint8();
		if($hastroops) {
			$hero['troops'] = $this->ReadTroops();
		}
		else {
			$this->SkipBytes(15);
		}

		// custom portrait
		$hasportrait = $this->ReadUint8();
		if($hasportrait) {
			$hero['portrait'] = $this->ReadUint8();
		}
		else {
			$this->SkipBytes(1);
		}

		// 3 artifacts
		for($i = 0; $i < 3; $i++) {
			$artid = $this->ReadUint8();
			if($artid < MAXARTIFACTID) {
				$artifact = $this->GetArtifactById($artid);
				$hero['Artifacts'][] = $artifact;
				$this->artifacts_list[] = new ListObject($artifact, $this->curcoor, 'Hero: '.$hero['name']);
			}
		}

		// unknown byte
		$this->SkipBytes(1);

		// experience
		$hero['exp'] = $this->ReadUint32();

		// custom skill
		$custom_secskill = $this->ReadUint8();
		if($custom_secskill) {
			for($i = 0; $i < 8; $i++) {
				$skill = $this->ReadUint8() + 1;
				if($skill > MAXSKILLID) continue;
				$hero['skills'][$i] = array($this->GetSecskillById($skill), 0);
			}
			for($i = 0; $i < 8; $i++) {
				$level = $this->ReadUint8();
				if($level == 0) continue;
				$hero['skills'][$i][1] = $level;
			}
		}
		else {
			$this->SkipBytes(16);
		}

		// unknown
		$this->SkipBytes(1);

		// custom name
		$hasName = $this->ReadUint8();
		if($hasName) {
			$hero['name'] = $this->ReadString(13);
		}
		else {
			$this->SkipBytes(13);
			if($hasportrait) {
				$hero['name'] = $this->GetHeroById($hero['portrait']);
			}
		}

		if($color >= 1 && $color <= 6) {
			$this->players[$color - 1]['HeroName'][] = $hero['name'];
		}

		// patrol
		$hero['patrol'] = $this->ReadUint8();
		$hero['radius'] = 0;
		// count square
		$radius = $this->ReadUint8(); //radius for normal hero, race for imprisoned hero


		if($objid != OBJECTS::OBJ_JAIL) {
			$hero['radius'] = $radius;
		}
		else {
			$affiliation = $radius;
		}

		$race = TOWNTYPE::RANDOM;
		switch($affiliation % 7) {
				case 0: $race = TOWNTYPE::KNIGHT; break;
				case 1: $race = TOWNTYPE::BARBAR; break;
				case 2: $race = TOWNTYPE::SORCERESS; break;
				case 3: $race = TOWNTYPE::WARLOCK; break;
				case 4: $race = TOWNTYPE::WIZARD; break;
				case 5: $race = TOWNTYPE::NECROMANCER; break;
				case 6: $race = TOWNTYPE::RANDOM; break;
		}

		$hero['color'] = $this->CS->PlayersColours[$color];
		$hero['race'] = $this->CS->TownType[$race];

		$this->SkipBytes(15);
		return $hero;
	}

	private function ReadSignBottle($blocksize) {
		$sign = array();
		$hasText = $this->ReadUint8();
		$this->SkipBytes(SIZEOFMP2SIGN - 2); //there is 1b hastext, 8b of zero and 1b on the end of the string
		if($hasText == 1 && $blocksize > SIZEOFMP2SIGN - 1) {
			$sign['text'] = $this->ReadString($blocksize - SIZEOFMP2SIGN + 1);
			$this->signs_list[] = new ListObject(($this->curobj == OBJECTS::OBJ_SIGN ? 'Sign' : 'Bottle'), $this->curcoor, $sign['text']);
		}
		else {
			$this->SkipBytes(1);
		}
		return $sign;
	}

	private function ReadEvent($blocksize) {
		$event = array();

		$check = $this->ReadUint8();

		if($blocksize > SIZEOFMP2EVENT - 1 && $check == 1) {
			$event['resources'] = $this->ReadResourses();

			$artid = $this->ReadUint16();
			$artifact = $this->GetArtifactById($artid);
			$event['artifact'] = $artifact;
			if($artid < MAXARTIFACTID) {
				$this->artifacts_list[] = new ListObject($artifact, $this->curcoor, 'Event');
			}

			$event['aiAble'] = $this->ReadUint8();
			$event['cancel'] = $this->ReadUint8();

			$this->SkipBytes(10);

			$event['players'] = '';
			for($i = 0; $i < PLAYERSNUM; $i++){
				$event['players'] .= $this->ReadUint8();
			}

			$event['message'] = $this->ReadString();
		}
		else {
			$this->SkipBytes($blocksize - 1);
		}
		return $event;
	}

	private function ReadSphinx($blocksize) {
		$sphinx = array();

		$check = $this->ReadUint8();

		if($blocksize > SIZEOFMP2RIDDLE - 1 && $check == 0) {
			$sphinx['resources'] = $this->ReadResourses();

			$artid = $this->ReadUint16();
			$artifact = $this->GetArtifactById($artid);
			$sphinx['artifact'] = $artifact;
			if($artid < MAXARTIFACTID) {
				$this->artifacts_list[] = new ListObject($artifact, $this->curcoor, 'Sphinx');
			}

			$numAnswers = $this->ReadUint8();
			$sphinx['answers'] = array();

			for($i = 0; $i < 8; $i++) {
				if($i < $numAnswers) {
					$sphinx['answers'][] = $this->ReadString(13);
				}
				else {
					$this->SkipBytes(13);
				}
			}

			$sphinx['riddle'] = $this->ReadString();

			$this->sphinxs_list[] = new ListObject('Sphinx', $this->curcoor, $sphinx['riddle'], implode($sphinx['answers'], '<br />'),
				$artifact, $this->PrintResources($sphinx['resources']));
		}
		else {
			$this->SkipBytes($blocksize - 1);
		}

		return $sphinx;
	}

	private function ReadEventDay($blocksize) {
		$check = $this->ReadUint8();
		if($check == 0) {
			$event['resources'] = $this->ReadResourses();

			$this->SkipBytes(2);

			$event['aiAble']= $this->ReadUint16();
			$event['first']= $this->ReadUint16();
			$event['interval']= $this->ReadUint16();

			$this->SkipBytes(6);

			$event['players'] = '';
			for($i = 0; $i < PLAYERSNUM; $i++){
				$event['players'] .= $this->ReadUint8();
			}

			$event['message']= $this->ReadString();

			return $event;
		}
		else {
			$this->SkipBytes($blocksize - 1);
		}
	}

	private function VictoryCondition(){
		$this->SetPos(0x1d);
		$this->victoryCond['type'] = $this->ReadUint8();
		$this->victoryCond['AI_cancomplete'] = $this->ReadUint8();
		$this->victoryCond['Normal_end'] = $this->ReadUint8();
		$winInfo1 = $this->ReadUint16();
		$this->SetPos(0x2c);
		$winInfo2 = $this->ReadUint16();

		switch($this->victoryCond['type']){
			case VICTORY::CAPTURETOWN: // 01 - Capture a specific town
				$this->victoryCond['name'] = 'Capture a specific town';
				$this->victoryCond['coor'] = new MapCoords($winInfo1, $winInfo2);
				break;
			case VICTORY::DEFEATHERO: // 02 - Defeat a specific Hero
				$this->victoryCond['name'] = 'Defeat a specific Hero';
				$this->victoryCond['coor'] = new MapCoords($winInfo1, $winInfo2);
				break;
			case VICTORY::ARTIFACT: // 03 - Acquire a specific artifact
				$this->victoryCond['name'] = 'Acquire a specific artifact';
				$artifact = ($winInfo1 == 0) ? 'Ultimate artifact' : $this->GetArtifactById($winInfo1 - 1);
				$this->victoryInfo = 'Acquire a specific artifact: '.$artifact;
				break;
			case VICTORY::ALLIED: // 04 - allied win
				for($i = 0; $i < PLAYERSNUM; $i++) {
					if(!array_key_exists($i, $this->players)) {
						$winInfo1++;
						continue;
					}
					if($i < $winInfo1) {
						$this->teams[0][] = $i;
					}
					else {
						$this->teams[1][] = $i;
					}
				}
				$this->teamscount = 2;

				$this->victoryCond['name'] = 'Allied victory';
				$this->victoryInfo = 'Allied victory: '.implode($this->teams[0], ', ').' vs '.implode($this->teams[1], ', ');
				break;
			case VICTORY::GOLD: // 05 - Accumulate gold
				$winInfo1 *= 1000;
				$this->victoryCond['name'] = 'Accumulate resources';
				$this->victoryCond['resource'] = $winInfo1;
				$this->victoryInfo = 'Accumulate gold: '.$winInfo1;
				break;
			case VICTORY::NONE: // 0
			default:
				$this->victoryCond['name'] = 'Standard';
				$this->victoryInfo = 'Defeat all players';
				break;
		}
		if($this->victoryCond['AI_cancomplete']) {
			$this->victoryInfo .= '<br />AI can complete condition too';
		}
		if($this->victoryCond['Normal_end']) {
			$this->victoryInfo .= '<br />Or standard end';
		}
	}

	public function LossCondition(){
		// 1	Special loss condition
		$this->SetPos(0x22);
		$this->lossCond['type'] = $this->ReadUint8();
		$lossCond1 = $this->ReadUint16();
		$this->SetPos(0x2e);
		$lossCond2 = $this->ReadUint16();

		switch($this->lossCond['type']){
			case LOSS::TOWN: // 00 - Lose a specific town
				$this->lossCond['name'] = 'Lose a specific town';
				$this->lossCond['coor'] = new MapCoords($lossCond1, $lossCond2);
				break;
			case LOSS::HERO: // 01 - Lose a specific hero
				$this->lossCond['name'] = 'Lose a specific hero';
				$this->lossCond['coor'] = new MapCoords($lossCond1, $lossCond2);
				break;
			case LOSS::TIME: // 02 - time
				$this->lossCond['name'] = 'Time expires';
				$month = floor($lossCond1 / 28);
				if($month > 0) {
					$month++;
				}
				$this->lossInfo = 'Complete before month '.$month.' and '.($lossCond1 % 28).' day';
				break;
			case LOSS::NONE:
			default:
				$this->lossCond['name'] = 'None';
				$this->lossInfo = 'Loose all towns and heroes';
				break;
		}
	}

	private function ParseFinish() {

		switch($this->victoryCond['type']){
			case VICTORY::CAPTURETOWN:
				$name = $this->GetMapObjectByPos(MAPOBJECTS::TOWN, $this->victoryCond['coor']);
				$this->victoryInfo = 'Capture town '.$name.' at'.$this->victoryCond['coor']->GetCoords();
				break;
			case VICTORY::DEFEATHERO:
				$name = $this->GetMapObjectByPos(MAPOBJECTS::HERO, $this->victoryCond['coor']);
				$this->victoryInfo = 'Defeat hero '.$name.' at '.$this->victoryCond['coor']->GetCoords();
				break;
		}

		switch($this->lossCond['type']) {
			case LOSS::TOWN:
				$name = $this->GetMapObjectByPos(MAPOBJECTS::TOWN, $this->lossCond['coor']);
				$this->lossInfo = 'Lose town '.$name.' at '.$this->lossCond['coor']->GetCoords();
				break;
			case LOSS::HERO:
				$name = $this->GetMapObjectByPos(MAPOBJECTS::HERO, $this->lossCond['coor']);
				$this->lossInfo = 'Loose hero '.$name.' at '.$this->lossCond['coor']->GetCoords();
				break;
		}

	}

	private function ProcessObject($cell, $x, $y) {
		switch($cell->generalObject) {

			case OBJECTS::OBJ_RNDULTIMATEARTIFACT:
			case OBJECTS::OBJ_RNDARTIFACT:
			case OBJECTS::OBJ_RNDARTIFACT1:
			case OBJECTS::OBJ_RNDARTIFACT2:
			case OBJECTS::OBJ_RNDARTIFACT3:
				$radius = ($cell->generalObject == OBJECTS::OBJ_RNDULTIMATEARTIFACT) ? ', radius='.(($cell->quantity1 >> 3) | ($cell->quantity2 << 5)) : '';
				$this->artifacts_list[] = new ListObject($this->GetObjectById($cell->generalObject), new MapCoords($x, $y), 'Map'.$radius);
				if($this->special_access) {
					$this->terrain[$y][$x]->special = MAPSPECIAL::ARTIFACT;
				}
				break;

			case OBJECTS::OBJ_ARTIFACT:
				$artid = ($cell->indexName1 - 1) / 2;
				$info = '';
				if($artid == 86) { //spell scroll
					$spellid = ($cell->quantity1 >> 3) | ($cell->quantity2 << 5);
					$info = ', '.$this->GetSpellById($spellid + 1);
				}
				$this->artifacts_list[] = new ListObject($this->GetArtifactById($artid), new MapCoords($x, $y), 'Map'.$info);
				if($this->special_access) {
					$this->terrain[$y][$x]->special = MAPSPECIAL::ARTIFACT;
				}
				break;

			case OBJECTS::OBJ_ABANDONEDMINE:
				if($cell->indexName1 != 8) break; //8 is value for access tile, dont count others
				$this->mines_list[] = new Listobject($this->GetObjectById($cell->generalObject), new MapCoords($x, $y), '');
				if($this->special_access) {
					$this->terrain[$y][$x]->special = MAPSPECIAL::MINE;
				}
				break;

			case OBJECTS::OBJ_MONSTER:
				$count = ($cell->quantity1 >> 3) | ($cell->quantity2 << 5);
				$this->monsters_list[] = new Listobject($this->GetCreatureById($cell->indexName1 + 1), new MapCoords($x, $y), '', OWNERNONE, $count);
				if($this->special_access) {
					$this->terrain[$y][$x]->special = MAPSPECIAL::MONSTER;
				}
				break;

			case OBJECTS::OBJ_RNDMONSTER:
			case OBJECTS::OBJ_RNDMONSTER1:
			case OBJECTS::OBJ_RNDMONSTER2:
			case OBJECTS::OBJ_RNDMONSTER3:
			case OBJECTS::OBJ_RNDMONSTER4:
				$count = ($cell->quantity1 << 8) | $cell->quantity2;
				$this->monsters_list[] = new Listobject($this->GetObjectById($cell->generalObject), new MapCoords($x, $y), '', OWNERNONE, $count);
				if($this->special_access) {
					$this->terrain[$y][$x]->special = MAPSPECIAL::MONSTER;
				}
				break;

			case OBJECTS::OBJ_OBELISK:
				$this->obeliskNum++;
				break;

			case OBJECTS::OBJ_HEROES:
				break;

		}

	}

	private function ReadTerrain() {

		$this->SetPos(MP2OFFSETDATA - 2 * 4);

		$w = $this->ReadUint32();
		$h = $this->ReadUint32();

		// seek to ADDONS block
		$this->SkipBytes($w * $h * SIZEOFMP2TILE);

		$numAddons = $this->ReadUint32();

		$mp2addons = array();


		//reading addons can be skipped, because it's not used anywhere in this app
		$this->SkipBytes(SIZEOFMP2ADDON * $numAddons);
		// read all addons
		/*
		for($i = 0; $i < $numAddons; $i++) {
			$mp2addons[$i] = new mp2addon();
			$mp2addons[$i]->indexAddon = $this->ReadUint16();
			$mp2addons[$i]->objectNameN1 = $this->ReadUint8() * 2;
			$mp2addons[$i]->indexNameN1 = $this->ReadUint8();
			$mp2addons[$i]->quantityN = $this->ReadUint8();
			$mp2addons[$i]->objectNameN2 = $this->ReadUint8();
			$mp2addons[$i]->indexNameN2 = $this->ReadUint8();
			$mp2addons[$i]->uniqNumberN1 = $this->ReadUint32();
			$mp2addons[$i]->uniqNumberN2 = $this->ReadUint32();
		}
		*/

		$addons_endpos = $this->GetPos();

		$this->SetPos(MP2OFFSETDATA);

		$tileindex = 0;
		for($y = 0; $y < $this->map_size; $y++) {
			for($x = 0; $x < $this->map_size; $x++) {
				$cell = new MapCell();

				//we can skip some properties, since this app does not use them
				$cell->surface = $this->ReadUint16();
				//$this->SkipBytes(18); //skipp all but surface

				$this->SkipBytes(1);
				//$cell->objectName1 = $this->ReadUint8();

				$cell->indexName1 = $this->ReadUint8();
				$cell->quantity1 = $this->ReadUint8();
				$cell->quantity2 = $this->ReadUint8();

				$this->SkipBytes(3);
				//$cell->objectName2 = $this->ReadUint8();
				//$cell->indexName2 = $this->ReadUint8();
				//$cell->shape = $this->ReadUint8();

				$cell->generalObject = $this->ReadUint8();

				$this->SkipBytes(10);
				//$cell->indexAddon = $this->ReadUint16();
				//$cell->uniqNumber1 = $this->ReadUint32();
				//$cell->uniqNumber2 = $this->ReadUint32();

				//set access based on OBJ vs OBJN (non passable) prefix. It's not 100% accurate, but it's pretty close
				$cell->access = in_array($cell->generalObject, $this->CS->ObjectsNonPassable) ? 1 : 0;
				$cell->owner = OWNERNONE;
				$cell->special = MAPSPECIAL::NONE;

				$this->terrain[$y][$x] = $cell;

				//objects count on the map
				if(!array_key_exists($cell->generalObject, $this->objects_unique)) {
					$this->objects_unique[$cell->generalObject] = array('name' => $this->GetObjectById($cell->generalObject), 'count' => 0);
				}
				$this->objects_unique[$cell->generalObject]['count']++;

				//tileindex of objects with more properties for later reading
				switch($cell->generalObject) {
					case OBJECTS::OBJ_RNDTOWN:
					case OBJECTS::OBJ_RNDCASTLE:
					case OBJECTS::OBJ_CASTLE:
					case OBJECTS::OBJ_HEROES:
					case OBJECTS::OBJ_SIGN:
					case OBJECTS::OBJ_BOTTLE:
					case OBJECTS::OBJ_EVENT:
					case OBJECTS::OBJ_SPHINX:
					case OBJECTS::OBJ_JAIL:
						$this->objectsX[] = $tileindex;
						break;
					default: break;
				}

				//no need to read addons info, this app does not use them
				// load all addon for current tils
				/*$
				indexAddBlock = $cell->indexAddon;
				while($indexAddBlock) {
					if($numAddons <= $indexAddBlock) {
						echo 'addon index out of range';
						break;
					}
					$cell->addons[] = $mp2addons[$indexAddBlock];
					$indexAddBlock = $mp2addons[$indexAddBlock]->indexAddon;
				}
				*/

				$this->ProcessObject($cell, $x, $y);

				$tileindex++;
			}
		}

		$this->SetPos($addons_endpos);
	}


	public function BuildMap() {

		$this->mapimage = sanity_string($this->mapfilename).'.png';
		$imgmapname = MAPDIRIMG.$this->mapimage;

		if($this->buildMapImage) {
			$this->img = imagecreate($this->map_size, $this->map_size); //map by size
			$imgmap = imagecreate($this::IMGSIZE, $this::IMGSIZE); //resized to constant size for all map sizes
			/* From web
				First byte - surface codes: (RGB colors on the map)
				ID   Terrain
				00 - Water
				01 - Grass
				02 - Snow
				03 - Swamp
				04 - Lava
				05 - Desert
				06 - Dirt
				07 - wasteland
				08 - Beach
				*/
			$this->imgcolors['dirt']          = imagecolorallocate($this->img, 0x68, 0x34, 0x10); //#68 34 10
			$this->imgcolors['sand']          = imagecolorallocate($this->img, 0xd8, 0xb8, 0x98); //#D8 B8 98
			$this->imgcolors['grass']         = imagecolorallocate($this->img, 0x20, 0x64, 0x18); //#20 64 18
			$this->imgcolors['snow']          = imagecolorallocate($this->img, 0xdc, 0xdc, 0xdc); //#DC DC DC
			$this->imgcolors['swamp']         = imagecolorallocate($this->img, 0x04, 0x30, 0x00); //#04 30 00
			$this->imgcolors['desert']        = imagecolorallocate($this->img, 0xc8, 0xa0, 0x18); //#C8 A0 18
			$this->imgcolors['lava']          = imagecolorallocate($this->img, 0x24, 0x24, 0x24); //#24 24 24
			$this->imgcolors['water']         = imagecolorallocate($this->img, 0x10, 0x20, 0x80); //#10 20 80
			$this->imgcolors['waste']         = imagecolorallocate($this->img, 0xe0, 0x84, 0x2c); //#E0 84 2C

			$this->imgcolors['bdirt']         = imagecolorallocate($this->img, 0x50, 0x24, 0x04); //#50 24 04
			$this->imgcolors['bsand']         = imagecolorallocate($this->img, 0xc0, 0x94, 0x6c); //#C0 94 6C
			$this->imgcolors['bgrass']        = imagecolorallocate($this->img, 0x0c, 0x4c, 0x08); //#0C 4C 08
			$this->imgcolors['bsnow']         = imagecolorallocate($this->img, 0xc0, 0xc0, 0xc0); //#C0 C0 C0
			$this->imgcolors['bswamp']        = imagecolorallocate($this->img, 0x00, 0x18, 0x00); //#00 18 00
			$this->imgcolors['bdesert']       = imagecolorallocate($this->img, 0xa8, 0x7c, 0x14); //#A8 7C 14
			$this->imgcolors['blava']         = imagecolorallocate($this->img, 0x04, 0x04, 0x04); //#04 04 04
			$this->imgcolors['bwater']        = imagecolorallocate($this->img, 0x00, 0x10, 0x60); //#10 20 80
			$this->imgcolors['bwaste']        = imagecolorallocate($this->img, 0xa4, 0x58, 0x10); //#A4 58 10

			$this->imgcolors['blue']          = imagecolorallocate($this->img, 0x31, 0x52, 0xff); //#404CB4
			$this->imgcolors['green']         = imagecolorallocate($this->img, 0x42, 0x94, 0x29); //#043804
			$this->imgcolors['red']           = imagecolorallocate($this->img, 0xff, 0x00, 0x00); //#A82020
			$this->imgcolors['yellow']        = imagecolorallocate($this->img, 0xff, 0xff, 0x00); //#ECD450
			$this->imgcolors['orange']        = imagecolorallocate($this->img, 0xff, 0xbb, 0x00); //#E09038
			$this->imgcolors['purple']        = imagecolorallocate($this->img, 0x8c, 0x29, 0xa5); //#B48CD0
			$this->imgcolors['neutral']       = imagecolorallocate($this->img, 0x84, 0x84, 0x84); //#C0C0C0

			$this->imgcolors['none']          = imagecolorallocate($this->img, 0xff, 0xff, 0xff);
			$this->imgcolors['mine']          = imagecolorallocate($this->img, 0xff, 0x00, 0xcc);
			$this->imgcolors['artifact']      = imagecolorallocate($this->img, 0x33, 0xff, 0xff);
			$this->imgcolors['monster']       = imagecolorallocate($this->img, 0x33, 0xff, 0x00);

			// Map
			$x = $y = 0;

			foreach($this->terrain as $y => $col) {
				foreach($col as $x => $cell) {
					$color = $this->GetCellSurface($cell);
					imagesetpixel($this->img, $x, $y, $color);
				}
			}

			imagecopyresized($imgmap, $this->img, 0, 0, 0, 0, $this::IMGSIZE, $this::IMGSIZE, $this->map_size, $this->map_size);
			imagepng($imgmap, $imgmapname);

			imagedestroy($this->img);
			imagedestroy($imgmap);
		}
	}

	public function DisplayMap() {
		$imgmapname = MAPDIRIMG.$this->mapimage;

		$mapsizepow = $this->map_size * $this->map_size;
		$output = '<br />Map : size='.$this->map_size.', cells='.$mapsizepow.', bytes='.($mapsizepow * 20).'<br />';
		$output .= '<table><tr><td><img src="'.$imgmapname.'" alt="ground" title="ground" /></td>';
		$output .= '</tr></table>';
		echo $output;
	}

	private function ReadTroops() {
		// set monster id
		$troops = array();
		for($i = 0; $i < 5; $i++) {
			$monid = $this->ReadUint8();
			if($monid == HNONE) {
				continue;
			}
			$troops[$i]['Unit'] = $this->GetCreatureById($monid + 1);
		}
		// set count
		for($i = 0; $i < 5; $i++) {
			$count = $this->ReadUint16();
			if(array_key_exists($i, $troops)) {
				$troops[$i]['Count'] = $count;
			}
		}
		return $troops;
	}

	private function PrintTroops($troops) {
		$out = '';
		foreach($troops as $t) {
			$out .= $t['Unit'].' : '.$t['Count'].'<br />';
		}
		return $out;
	}

	private function PrintResources($res) {
		$eres = array();
		foreach($res as $r => $amount) {
			if($amount == 0) continue;
			$eres[] = $amount.' '.$this->GetResource($r);
		}
		return implode($eres, '<br />');
	}

	private function ReadResourses() {
		$resources = array();
		for($i = 0; $i < 7; $i++) {
			$resources[$i] = $this->ReadInt32();
		}
		return $resources;
	}

	private function GetCellSurface($cell){

		if($cell->owner != OWNERNONE) {
			switch($cell->owner){
				case COLORS::BLUE:   return $this->imgcolors['blue'];
				case COLORS::GREEN:  return $this->imgcolors['green'];
				case COLORS::RED:    return $this->imgcolors['red'];
				case COLORS::YELLOW: return $this->imgcolors['yellow'];
				case COLORS::ORANGE: return $this->imgcolors['orange'];
				case COLORS::PURPLE: return $this->imgcolors['purple'];
				default:             return $this->imgcolors['neutral'];
			}
		}
		elseif($this->special_access && $cell->special != MAPSPECIAL::NONE) {
			switch($cell->special) {
				case MAPSPECIAL::MINE:     return $this->imgcolors['mine'];
				case MAPSPECIAL::ARTIFACT: return $this->imgcolors['artifact'];
				case MAPSPECIAL::MONSTER:  return $this->imgcolors['monster'];
			}
		}
		elseif($cell->access == 0){
			$t = $cell->surface & 0x3ff; //mask for ground type, 0xc00 is for shape
			if ($t < 30)  return $this->imgcolors['water'];
			if ($t < 92)  return $this->imgcolors['grass'];
			if ($t < 146) return $this->imgcolors['snow'];
			if ($t < 208) return $this->imgcolors['swamp'];
			if ($t < 262) return $this->imgcolors['lava'];
			if ($t < 321) return $this->imgcolors['desert'];
			if ($t < 361) return $this->imgcolors['dirt'];
			if ($t < 415) return $this->imgcolors['waste'];
			else          return $this->imgcolors['sand']; //432
		}
		else {
			$t = $cell->surface & 0x3ff; //mask for ground type, 0xc00 is for shape
			if ($t < 30)  return $this->imgcolors['bwater'];
			if ($t < 92)  return $this->imgcolors['bgrass'];
			if ($t < 146) return $this->imgcolors['bsnow'];
			if ($t < 208) return $this->imgcolors['bswamp'];
			if ($t < 262) return $this->imgcolors['blava'];
			if ($t < 321) return $this->imgcolors['bdesert'];
			if ($t < 361) return $this->imgcolors['bdirt'];
			if ($t < 415) return $this->imgcolors['bwaste'];
			else          return $this->imgcolors['bsand']; //432
		}
	}

	private function GetVersionName() {
		switch($this->version) {
			case $this::H2O: $this->versionname = 'SW'; break;
			case $this::POL: $this->versionname = 'POL'; break;
			default: $this->versionname = '?'; break;
		}
	}

	private function GetMapSize() {
		switch($this->map_size) {
			case 36:  $this->map_sizename = 'S'; break;
			case 72:  $this->map_sizename = 'M'; break;
			case 108: $this->map_sizename = 'L'; break;
			case 144: $this->map_sizename = 'XL'; break;
			default:  $this->map_sizename = '?'; break;
		}
	}

	private function GetDifficulty() {
		switch($this->map_diff) {
			case 0: $this->map_diffname = 'Easy'; break;
			case 1: $this->map_diffname = 'Normal'; break;
			case 2: $this->map_diffname = 'Hard'; break;
			case 3: $this->map_diffname = 'Expert'; break;
			default: $this->map_diffname = '?'; break;
		}
	}

	private function GetResource($resourceid) {
		switch($resourceid) {
			case 0: return 'Wood';
			case 1: return 'Mercury';
			case 2: return 'Ore';
			case 3: return 'Sulfur';
			case 4: return 'Crystal';
			case 5: return 'Gems';
			case 6: return 'Gold';
			default: return '?';
		}
	}

	private function GetArtifactById($artid) {
		return FromArray($artid, $this->CS->Artifacts);
	}

	private function GetSpellById($spellid) {
		return FromArray($spellid, $this->CS->Spells);
	}

	private function GetCreatureById($monid) {
		return FromArray($monid, $this->CS->Monster);
	}

	private function GetResourceById($id) {
		return $this->GetResource($id);
	}

	private function GetMineById($id) {
		return FromArray($id, $this->CS->Mines);
	}

	private function GetHeroById($id) {
		return FromArray($id, $this->CS->Heroes);
	}

	private function GetTownById($id) {
		return FromArray($id, $this->CS->TownType);
	}

	private function GetObjectById($id) {
		return FromArray($id, $this->CS->Objects);
	}

	private function GetSecskillById($id) {
		return FromArray($id, $this->CS->SecondarySkill);
	}

	private function GetSecskillLevelById($id) {
		return FromArray($id, $this->CS->SecSkillLevel);
	}

	private function GetMapObjectByPos($objid, $coords) {
		if($objid == MAPOBJECTS::TOWN) {
			foreach($this->towns_list as $town) {
				if($coords->x == $town->mapcoor->x && $coords->y == $town->mapcoor->y) {
					return $town->name;
				}
			}
		}
		elseif($objid == MAPOBJECTS::HERO) {
			foreach($this->heroes_list as $hero) {
				if($coords->x == $hero['coor']->x && $coords->y == $hero['coor']->y) {
					return $hero['data']['name'];
				}
			}
		}
		return '?';
	}

	private function ReadUint8(){
		if($this->pos >= $this->filesize || $this->pos < 0){
			dbglog();
			die('Bad position '.$this->pos);
			return;
		}
		return ord($this->mapdata[$this->pos++]);
	}

	private function ReadUint16(){
		$res = $this->ReadUint8();
		$res += $this->ReadUint8() << 8;
		return $res;
	}

	private function ReadUint32(){
		$res = $this->ReadUint16();
		$res += $this->ReadUint16() << 16;
		return $res;
	}

	public function ReadInt8(){
		$res = $this->ReadUint8();
		if($res > 0x7E) {
			$res -= 0x100;
		}
		return $res;
	}

	private function ReadInt32(){
		$res = $this->ReadUint32();
		if($res > MAXINT32) {
			$res -= MININT32;
		}
		return $res;
	}

	//unused, no 64 bit in map format
	/*private function ReadUint64(){
		return $this->fix64($this->ReadUint32(), $this->ReadUint32());
	}

	private function fix64($numL, $numH){
		if($numH < 0) {
			$numH += MININT32;
		}
		if($numL < 0) {
			$numL += MININT32;
		}
		$num = bcadd($numL, bcmul($numH, MININT32));
		if($num > bcpow(2, 63)) {
			return bcsub($num, bcpow(MININT32, 2)); // 2, 64
		}
		return $num;
	}
	*/

	private function ReadString($length = 0){
		$res = '';
		if($this->pos >= $this->length || $this->pos < 0){
			dbglog();
			$this->mapdata = null;
			$this->terrain = null;
			$this->CS = null;
			//vd($this);
			die('Bad string pos '.$this->pos);
			return;
		}

		$bytesread = 0;
		while(true) {
			if($length > 0 && $bytesread >= $length) {
				break;
			}
			$byte = $this->mapdata[$this->pos++];
			$bytesread++;
			if(ord($byte) == 0) {
				break;
			}
			$res .= $byte;
		}
		//if given length, skip by unread bytes
		if($length > 0){
			$this->pos += ($length - $bytesread);
		}
		return $this->SC->Convert($res);
	}

	private function SkipBytes($bytes = 31){
		$this->pos += $bytes;
	}

	//read byte from position relative to current position and get back to same position
	private function ReadByteRelPos($num) {
		if($this->pos + $num + 1 > $this->length) {
			return; //overread
		}
		$this->pos += $num;
		$res = $this->ReadUint8();
		$this->pos -= ($num + 1);
		return $res;
	}

	private function SetPos($pos){
		$this->pos = $pos;
	}

	private function GetPos(){
		return $this->pos;
	}

	//print current position
	private function ppos(){
		vd(dechex($this->pos). ' '.$this->pos);
	}

	private function pvar($var){
		echo ' '.dechex($var). ' '.$var.'<br />';
	}

	private function bvar($var){
		$bprint = sprintf('%08b', $var & 0xff);
		if($var > 0xff) {
			$bprint = sprintf('%08b', ($var >> 8) & 0xff).' '.$bprint;
		}
		return $bprint;
	}

}


class MapCell {
	//unused properties are skipped
	public $surface;     // tile (ocean, grass, snow, swamp, lava, desert, dirt, wasteland, beach)
	//public $tileIndex;
	//public $objectName1; // level 1.0
	public $indexName1;  // index level 1.0 or 0xFF
	public $quantity1;   // count
	public $quantity2;   // count
	//public $objectName2; // level 2.0
	//public $indexName2;  // index level 2.0 or 0xFF
	//public $shape;       // shape reflect % 4, 0 none, 1 vertical, 2 horizontal, 3 any
	public $generalObject; // zero or object, OBJECT ID
	//public $indexAddon;	// zero or index addons_t
	//public $uniqNumber1;	// level 1.0
	//public $uniqNumber2;	// level 2.0

	public $access;       //accessibility
	public $owner;        //is object on tile owned -> owner id
	public $special;      //display some object on map with special colour
	public $addons;
}

//currently unused
// origin mp2 addons tile
/*
class mp2addon {
	public $indexAddon; // zero or next addons_t
	public $objectNameN1; // level 1.N
	public $indexNameN1; // level 1.N or 0xFF
	public $quantityN; //
	public $objectNameN2; // level 2.N
	public $indexNameN2; // level 1.N or 0xFF
	public $uniqNumberN1; // level 1.N
	public $uniqNumberN2; // level 2.N
};
*/

class MapCoords {
	public $x;
	public $y;

	public function __construct($x = COOR_INVALID, $y = COOR_INVALID) {
		$this->x = $x;
		$this->y = $y;
	}

	public function GetCoords(){
		if($this->x == COOR_INVALID) {
			return '?';
		}
		return '['.$this->x.','.$this->y.']';
	}
}

//generic object list
class ListObject {
	public $name;
	public $mapcoor;
	public $parent;
	public $owner;
	public $count;
	public $info;

	public function __construct($name, $coor, $parent, $owner = OWNERNONE, $count = 0, $info = '') {
		$this->name = $name;
		$this->mapcoor = $coor;
		$this->parent = $parent;
		$this->owner = $owner;
		$this->count = $count;
		$this->info = $info;
	}
}

function EventSortByDate($a, $b){
	if($a['first'] > $b['first']) return 1;
	if($a['first'] < $b['first']) return -1;
	return 0;
}

function ListSortByName($a, $b){
	return strcmp($a->name, $b->name);
}

?>
