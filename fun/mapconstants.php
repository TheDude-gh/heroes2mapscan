<?php

	const OWNERNONE = 0xff;
	const OWNNOONE = 0xff;
	const OBJECT_INVALID = -1; //invalid object id
	const TILE_SPECIAL = 0x7ff; //just random number to mark special tile property
	const COOR_INVALID = -1; //invalid coordinates

	const MAXINT32 = 0x80000000; //1 << 31;
	const MININT32 = 0x100000000; //1 << 32; //without minus


	//HEROES2
	const PLAYERSNUM = 6;
	const LENGTHNAME = 16;
	const LENGTHDESCRIPTION = 200; //143
	const MP2OFFSETDATA = 428;
	const SIZEOFMP2TILE = 20;
	const SIZEOFMP2ADDON = 15;
	const CASTLEBLOCK = 72;
	const MINEBLOCK = 144;

	const SIZEOFMP2CASTLE= 0x46;
	const SIZEOFMP2HEROES = 0x4c;
	const SIZEOFMP2SIGN = 0x0a;
	const SIZEOFMP2RUMOR = 0x09;
	const SIZEOFMP2EVENT = 0x32;
	const SIZEOFMP2RIDDLE = 0x8a;

	const MAXARTIFACTID = 103;
	const MAXSKILLID = 15;

	const HNONE = 0xff;


	class MAPOBJECTS {
		const NONE = 0;
		const HERO = 1;
		const TOWN = 2;
		const MONSTER = 3;
	}

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

	class TOWNTYPE {
		const KNIGHT = 0;
		const BARBAR = 1;
		const SORCERESS = 2;
		const WARLOCK = 3;
		const WIZARD = 4;
		const NECROMANCER = 5;
		const MULT = 6;
		const RANDOM1 = 7;
		const RANDOM = 0xff;
	}

	class OBJECTS {
		const NO_OBJ = -1;
		const OBJ_ZERO = 0;	// 0x0
		const OBJ_UNKNW_02 = 2;	// 0x2
		const OBJN_ALCHEMYLAB = 1;	// 0x1
		const OBJ_UNKNW_03 = 3;	// 0x3
		const OBJN_SKELETON = 4;	// 0x4
		const OBJN_DAEMONCAVE = 5;	// 0x5
		const OBJ_UNKNW_06 = 6;	// 0x6
		const OBJN_FAERIERING = 7;	// 0x7
		const OBJ_UNKNW_08 = 8;	// 0x8
		const OBJ_UNKNW_09 = 9;	// 0x9
		const OBJN_GAZEBO = 10;	// 0xA
		const OBJ_UNKNW_0B = 11;	// 0xB
		const OBJN_GRAVEYARD = 12;	// 0xC
		const OBJN_ARCHERHOUSE = 13;	// 0xD
		const OBJ_UNKNW_0E = 14;	// 0xE
		const OBJN_DWARFCOTT = 15;	// 0xF
		const OBJN_PEASANTHUT = 16;	// 0x10
		const OBJ_UNKNW_11 = 17;	// 0x11
		const OBJ_UNKNW_12 = 18;	// 0x12
		const OBJ_UNKNW_13 = 19;	// 0x13
		const OBJN_DRAGONCITY = 20;	// 0x14
		const OBJN_LIGHTHOUSE = 21;	// 0x15
		const OBJN_WATERWHEEL = 22;	// 0x16
		const OBJN_MINES = 23;	// 0x17
		const OBJ_UNKNW_18 = 24;	// 0x18
		const OBJN_OBELISK = 25;	// 0x19
		const OBJN_OASIS = 26;	// 0x1A
		const OBJ_UNKNW_1B = 27;	// 0x1B
		const OBJ_COAST = 28;	// 0x1C
		const OBJN_SAWMILL = 29;	// 0x1D
		const OBJN_ORACLE = 30;	// 0x1E
		const OBJ_UNKNW_1F = 31;	// 0x1F
		const OBJN_SHIPWRECK = 32;	// 0x20
		const OBJ_UNKNW_21 = 33;	// 0x21
		const OBJN_DESERTTENT = 34;	// 0x22
		const OBJN_CASTLE = 35;	// 0x23
		const OBJN_STONELIGHTS = 36;	// 0x24
		const OBJN_WAGONCAMP = 37;	// 0x25
		const OBJ_UNKNW_26 = 38;	// 0x26
		const OBJ_UNKNW_27 = 39;	// 0x27
		const OBJN_WINDMILL = 40;	// 0x28
		const OBJ_UNKNW_29 = 41;	// 0x29
		const OBJ_UNKNW_2A = 42;	// 0x2A
		const OBJ_UNKNW_2B = 43;	// 0x2B
		const OBJ_UNKNW_2C = 44;	// 0x2C
		const OBJ_UNKNW_2D = 45;	// 0x2D
		const OBJ_UNKNW_2E = 46;	// 0x2E
		const OBJ_UNKNW_2F = 47;	// 0x2F
		const OBJN_RNDTOWN = 48;	// 0x30
		const OBJN_RNDCASTLE = 49;	// 0x31
		const OBJ_UNKNW_32 = 50;	// 0x32
		const OBJ_UNKNW_33 = 51;	// 0x33
		const OBJ_UNKNW_34 = 52;	// 0x34
		const OBJ_UNKNW_35 = 53;	// 0x35
		const OBJ_UNKNW_36 = 54;	// 0x36
		const OBJ_UNKNW_37 = 55;	// 0x37
		const OBJ_SHRUB2 = 56;	// 0x38
		const OBJ_NOTHINGSPECIAL = 57;	// 0x39
		const OBJN_WATCHTOWER = 58;	// 0x3A
		const OBJN_TREEHOUSE = 59;	// 0x3B
		const OBJN_TREECITY = 60;	// 0x3C
		const OBJN_RUINS = 61;	// 0x3D
		const OBJN_FORT = 62;	// 0x3E
		const OBJN_TRADINGPOST = 63;	// 0x3F
		const OBJN_ABANDONEDMINE = 64;	// 0x40
		const OBJ_UNKNW_41 = 65;	// 0x41
		const OBJ_UNKNW_42 = 66;	// 0x42
		const OBJ_UNKNW_43 = 67;	// 0x43
		const OBJN_TREEKNOWLEDGE = 68;	// 0x44
		const OBJN_DOCTORHUT = 69;	// 0x45
		const OBJN_TEMPLE = 70;	// 0x46
		const OBJN_HILLFORT = 71;	// 0x47
		const OBJN_HALFLINGHOLE = 72;	// 0x48
		const OBJN_MERCENARYCAMP = 73;	// 0x49
		const OBJ_UNKNW_4A = 74;	// 0x4A
		const OBJ_UNKNW_4B = 75;	// 0x4B
		const OBJN_PYRAMID = 76;	// 0x4C
		const OBJN_CITYDEAD = 77;	// 0x4D
		const OBJN_EXCAVATION = 78;	// 0x4E
		const OBJN_SPHINX = 79;	// 0x4F
		const OBJ_UNKNW_50 = 80;	// 0x50
		const OBJ_TARPIT = 81;	// 0x51
		const OBJN_ARTESIANSPRING = 82;	// 0x52
		const OBJN_TROLLBRIDGE = 83;	// 0x53
		const OBJN_WATERINGHOLE = 84;	// 0x54
		const OBJN_WITCHSHUT = 85;	// 0x55
		const OBJN_XANADU = 86;	// 0x56
		const OBJN_CAVE = 87;	// 0x57
		const OBJ_UNKNW_58 = 88;	// 0x58
		const OBJN_MAGELLANMAPS = 89;	// 0x59
		const OBJ_UNKNW_5A = 90;	// 0x5A
		const OBJN_DERELICTSHIP = 91;	// 0x5B
		const OBJ_UNKNW_5C = 92;	// 0x5C
		const OBJ_UNKNW_5D = 93;	// 0x5D
		const OBJN_MAGICWELL = 94;	// 0x5E
		const OBJ_UNKNW_5F = 95;	// 0x5F
		const OBJN_OBSERVATIONTOWER = 96;	// 0x60
		const OBJN_FREEMANFOUNDRY = 97;	// 0x61
		const OBJ_UNKNW_62 = 98;	// 0x62
		const OBJ_TREES = 99;	// 0x63
		const OBJ_MOUNTS = 100;	// 0x64
		const OBJ_VOLCANO = 101;	// 0x65
		const OBJ_FLOWERS = 102;	// 0x66
		const OBJ_STONES = 103;	// 0x67
		const OBJ_WATERLAKE = 104;	// 0x68
		const OBJ_MANDRAKE = 105;	// 0x69
		const OBJ_DEADTREE = 106;	// 0x6A
		const OBJ_STUMP = 107;	// 0x6B
		const OBJ_CRATER = 108;	// 0x6C
		const OBJ_CACTUS = 109;	// 0x6D
		const OBJ_MOUND = 110;	// 0x6E
		const OBJ_DUNE = 111;	// 0x6F
		const OBJ_LAVAPOOL = 112;	// 0x70
		const OBJ_SHRUB = 113;	// 0x71
		const OBJN_ARENA = 114;	// 0x72
		const OBJN_BARROWMOUNDS = 115;	// 0x73
		const OBJN_MERMAID = 116;	// 0x74
		const OBJN_SIRENS = 117;	// 0x75
		const OBJN_HUTMAGI = 118;	// 0x76
		const OBJN_EYEMAGI = 119;	// 0x77
		const OBJN_TRAVELLERTENT = 120;	// 0x78
		const OBJ_UNKNW_79 = 121;	// 0x79
		const OBJ_UNKNW_7A = 122;	// 0x7A
		const OBJN_JAIL = 123;	// 0x7B
		const OBJN_FIREALTAR = 124;	// 0x7C
		const OBJN_AIRALTAR = 125;	// 0x7D
		const OBJN_EARTHALTAR = 126;	// 0x7E
		const OBJN_WATERALTAR = 127;	// 0x7F
		const OBJ_WATERCHEST = 128;	// 0x80
		const OBJ_ALCHEMYLAB = 129;	// 0x81
		const OBJ_SIGN = 130;	// 0x82
		const OBJ_BUOY = 131;	// 0x83
		const OBJ_SKELETON = 132;	// 0x84
		const OBJ_DAEMONCAVE = 133;	// 0x85
		const OBJ_TREASURECHEST = 134;	// 0x86
		const OBJ_FAERIERING = 135;	// 0x87
		const OBJ_CAMPFIRE = 136;	// 0x88
		const OBJ_FOUNTAIN = 137;	// 0x89
		const OBJ_GAZEBO = 138;	// 0x8A
		const OBJ_ANCIENTLAMP = 139;	// 0x8B
		const OBJ_GRAVEYARD = 140;	// 0x8C
		const OBJ_ARCHERHOUSE = 141;	// 0x8D
		const OBJ_GOBLINHUT = 142;	// 0x8E
		const OBJ_DWARFCOTT = 143;	// 0x8F
		const OBJ_PEASANTHUT = 144;	// 0x90
		const OBJ_UNKNW_91 = 145;	// 0x91
		const OBJ_UNKNW_92 = 146;	// 0x92
		const OBJ_EVENT = 147;	// 0x93
		const OBJ_DRAGONCITY = 148;	// 0x94
		const OBJ_LIGHTHOUSE = 149;	// 0x95
		const OBJ_WATERWHEEL = 150;	// 0x96
		const OBJ_MINES = 151;	// 0x97
		const OBJ_MONSTER = 152;	// 0x98
		const OBJ_OBELISK = 153;	// 0x99
		const OBJ_OASIS = 154;	// 0x9A
		const OBJ_RESOURCE = 155;	// 0x9B
		const OBJ_UNKNW_9C = 156;	// 0x9C
		const OBJ_SAWMILL = 157;	// 0x9D
		const OBJ_ORACLE = 158;	// 0x9E
		const OBJ_SHRINE1 = 159;	// 0x9F
		const OBJ_SHIPWRECK = 160;	// 0xA0
		const OBJ_UNKNW_A1 = 161;	// 0xA1
		const OBJ_DESERTTENT = 162;	// 0xA2
		const OBJ_CASTLE = 163;	// 0xA3
		const OBJ_STONELIGHTS = 164;	// 0xA4
		const OBJ_WAGONCAMP = 165;	// 0xA5
		const OBJ_UNKNW_A6 = 166;	// 0xA6
		const OBJ_WHIRLPOOL = 167;	// 0xA7
		const OBJ_WINDMILL = 168;	// 0xA8
		const OBJ_ARTIFACT = 169;	// 0xA9
		const OBJ_UNKNW_AA = 170;	// 0xAA
		const OBJ_BOAT = 171;	// 0xAB
		const OBJ_RNDULTIMATEARTIFACT = 172;	// 0xAC
		const OBJ_RNDARTIFACT = 173;	// 0xAD
		const OBJ_RNDRESOURCE = 174;	// 0xAE
		const OBJ_RNDMONSTER = 175;	// 0xAF
		const OBJ_RNDTOWN = 176;	// 0xB0
		const OBJ_RNDCASTLE = 177;	// 0xB1
		const OBJ_UNKNW_B2 = 178;	// 0xB2
		const OBJ_RNDMONSTER1 = 179;	// 0xB3
		const OBJ_RNDMONSTER2 = 180;	// 0xB4
		const OBJ_RNDMONSTER3 = 181;	// 0xB5
		const OBJ_RNDMONSTER4 = 182;	// 0xB6
		const OBJ_HEROES = 183;	// 0xB7
		const OBJ_UNKNW_B8 = 184;	// 0xB8
		const OBJ_UNKNW_B9 = 185;	// 0xB9
		const OBJ_WATCHTOWER = 186;	// 0xBA
		const OBJ_TREEHOUSE = 187;	// 0xBB
		const OBJ_TREECITY = 188;	// 0xBC
		const OBJ_RUINS = 189;	// 0xBD
		const OBJ_FORT = 190;	// 0xBE
		const OBJ_TRADINGPOST = 191;	// 0xBF
		const OBJ_ABANDONEDMINE = 192;	// 0xC0
		const OBJ_THATCHEDHUT = 193;	// 0xC1
		const OBJ_STANDINGSTONES = 194;	// 0xC2
		const OBJ_IDOL = 195;	// 0xC3
		const OBJ_TREEKNOWLEDGE = 196;	// 0xC4
		const OBJ_DOCTORHUT = 197;	// 0xC5
		const OBJ_TEMPLE = 198;	// 0xC6
		const OBJ_HILLFORT = 199;	// 0xC7
		const OBJ_HALFLINGHOLE = 200;	// 0xC8
		const OBJ_MERCENARYCAMP = 201;	// 0xC9
		const OBJ_SHRINE2 = 202;	// 0xCA
		const OBJ_SHRINE3 = 203;	// 0xCB
		const OBJ_PYRAMID = 204;	// 0xCC
		const OBJ_CITYDEAD = 205;	// 0xCD
		const OBJ_EXCAVATION = 206;	// 0xCE
		const OBJ_SPHINX = 207;	// 0xCF
		const OBJ_WAGON = 208;	// 0xD0
		const OBJ_UNKNW_D1 = 209;	// 0xD1
		const OBJ_ARTESIANSPRING = 210;	// 0xD2
		const OBJ_TROLLBRIDGE = 211;	// 0xD3
		const OBJ_WATERINGHOLE = 212;	// 0xD4
		const OBJ_WITCHSHUT = 213;	// 0xD5
		const OBJ_XANADU = 214;	// 0xD6
		const OBJ_CAVE = 215;	// 0xD7
		const OBJ_LEANTO = 216;	// 0xD8
		const OBJ_MAGELLANMAPS = 217;	// 0xD9
		const OBJ_FLOTSAM = 218;	// 0xDA
		const OBJ_DERELICTSHIP = 219;	// 0xDB
		const OBJ_SHIPWRECKSURVIROR = 220;	// 0xDC
		const OBJ_BOTTLE = 221;	// 0xDD
		const OBJ_MAGICWELL = 222;	// 0xDE
		const OBJ_MAGICGARDEN = 223;	// 0xDF
		const OBJ_OBSERVATIONTOWER = 224;	// 0xE0
		const OBJ_FREEMANFOUNDRY = 225;	// 0xE1
		const OBJ_UNKNW_E2 = 226;	// 0xE2
		const OBJ_UNKNW_E3 = 227;	// 0xE3
		const OBJ_UNKNW_E4 = 228;	// 0xE4
		const OBJ_UNKNW_E5 = 229;	// 0xE5
		const OBJ_UNKNW_E6 = 230;	// 0xE6
		const OBJ_UNKNW_E7 = 231;	// 0xE7
		const OBJ_UNKNW_E8 = 232;	// 0xE8
		const OBJ_REEFS = 233;	// 0xE9
		const OBJN_ALCHEMYTOWER = 234;	// 0xEA
		const OBJN_STABLES = 235;	// 0xEB
		const OBJ_MERMAID = 236;	// 0xEC
		const OBJ_SIRENS = 237;	// 0xED
		const OBJ_HUTMAGI = 238;	// 0xEE
		const OBJ_EYEMAGI = 239;	// 0xEF
		const OBJ_ALCHEMYTOWER = 240;	// 0xF0
		const OBJ_STABLES = 241;	// 0xF1
		const OBJ_ARENA = 242;	// 0xF2
		const OBJ_BARROWMOUNDS = 243;	// 0xF3
		const OBJ_RNDARTIFACT1 = 244;	// 0xF4
		const OBJ_RNDARTIFACT2 = 245;	// 0xF5
		const OBJ_RNDARTIFACT3 = 246;	// 0xF6
		const OBJ_BARRIER = 247;	// 0xF7
		const OBJ_TRAVELLERTENT = 248;	// 0xF8
		const OBJ_UNKNW_F9 = 249;	// 0xF9
		const OBJ_UNKNW_FA = 250;	// 0xFA
		const OBJ_JAIL = 251;	// 0xFB
		const OBJ_FIREALTAR = 252;	// 0xFC
		const OBJ_AIRALTAR = 253;	// 0xFD
		const OBJ_EARTHALTAR = 254;	// 0xFE
		const OBJ_WATERALTAR = 255;	// 0xFF
	}

	class COLORS {
		const NONE	  = 0;
		const BLUE    = 1;
		const GREEN   = 2;
		const RED     = 3;
		const YELLOW  = 4;
		const ORANGE  = 5;
		const PURPLE  = 6;
		const UNUSED	= 0xff;
	}

	class MAPSPECIAL {
		const NONE	   = 0;
		const MINE     = 1;
		const ARTIFACT = 2;
		const MONSTER  = 3;
	}

	class HeroesConstants {

		public $PlayersColours = [
			0 => 'None',
			1 => 'Blue',
			2 => 'Green',
			3 => 'Red',
			4 => 'Yellow',
			5 => 'Orange',
			6 => 'Purple',
			0xff => 'None',
		];

		public $PrimarySkill = [
			0 => 'Attack',
			1 => 'Defense',
			2 => 'Spell Power',
			3 => 'Knowledge',
			4 => 'Experience'
		];

		public $SecondarySkill = [
			0 => 'Unknown',
			1 => 'Pathfinding',
			2 => 'Archery',
			3 => 'Logistics',
			4 => 'Scouting',
			5 => 'Diplomacy',
			6 => 'Navigation',
			7 => 'Leadership',
			8 => 'Wisdom' ,
			9 => 'Mysticism' ,
			10 => 'Luck' ,
			11 => 'Ballistics' ,
			12 => 'Eagle Eye' ,
			13 => 'Necromancy' ,
			14 => 'Estates' ,
			15 => 'Learning' ,
		];

		public $TownType = [
			0 => 'Knight',
			1 => 'Barbar',
			2 => 'Sorceress',
			3 => 'Warlock',
			4 => 'Wizard',
			5 => 'Necromancer',
			6 => 'Multi',
			7 => 'Random',
			255 => 'Random'
		];

		public $SecSkillLevel = [
			0 => 'None',
			1 => 'Basic',
			2 => 'Advanced',
			3 => 'Expert',
		];

		public $TerrainType = [
			-2 => 'WRONG',
			-1 => 'BORDER',
			0 => 'WATER',
			1 => 'GRASS',
			2 => 'SNOW',
			3 => 'SWAMP',
			4 => 'LAVA',
			5 => 'DESERT',
			6 => 'DIRT',
			7 => 'WASTELAND',
			8 => 'BEACH',
		];

		//full defines of obj, monsters, heroes
		public $Monster = [
			0 => 'Unknown Monster',
			1 => 'Peasant',
			2 => 'Archer',
			3 => 'Ranger',
			4 => 'Pikeman',
			5 => 'Veteran Pikeman',
			6 => 'Swordsman',
			7 => 'Master Swordsman',
			8 => 'Cavalry',
			9 => 'Champion',
			10 => 'Paladin',
			11 => 'Crusader',
			12 => 'Goblin',
			13 => 'Orc',
			14 => 'Orc Chief',
			15 => 'Wolf',
			16 => 'Ogre',
			17 => 'Ogre Lord',
			18 => 'Troll',
			19 => 'War Troll',
			20 => 'Cyclops',
			21 => 'Sprite',
			22 => 'Dwarf',
			23 => 'Battle Dwarf',
			24 => 'Elf',
			25 => 'Grand Elf',
			26 => 'Druid',
			27 => 'Greater Druid',
			28 => 'Unicorn',
			29 => 'Phoenix',
			30 => 'Centaur',
			31 => 'Gargoyle',
			32 => 'Griffin',
			33 => 'Minotaur',
			34 => 'Minotaur King',
			35 => 'Hydra',
			36 => 'Green Dragon',
			37 => 'Red Dragon',
			38 => 'Black Dragon',
			39 => 'Halfling',
			40 => 'Boar',
			41 => 'Iron Golem',
			42 => 'Steel Golem',
			43 => 'Roc',
			44 => 'Mage',
			45 => 'Archmage',
			46 => 'Giant',
			47 => 'Titan',
			48 => 'Skeleton',
			49 => 'Zombie',
			50 => 'Mutant Zombie',
			51 => 'Mummy',
			52 => 'Royal Mummy',
			53 => 'Vampire',
			54 => 'Vampire Lord',
			55 => 'Lich',
			56 => 'Power Lich',
			57 => 'Bone Dragon',
			58 => 'Rogue',
			59 => 'Nomad',
			60 => 'Ghost',
			61 => 'Genie',
			62 => 'Medusa',
			63 => 'Earth Elemental',
			64 => 'Air Elemental',
			65 => 'Fire Elemental',
			66 => 'Water Elemental',
			67 => 'Random Monster',
			68 => 'Random Monster 1',
			69 => 'Random Monster 2',
			70 => 'Random Monster 3',
			71 => 'Random Monster 4',
		];

		public $Objects = [
			OBJECTS::OBJ_ZERO => 'Empty tile',
			OBJECTS::OBJN_ALCHEMYLAB => 'Alchemist Lab N',
			OBJECTS::OBJ_ALCHEMYLAB => 'Alchemist Lab',
			OBJECTS::OBJN_DAEMONCAVE => 'Daemon Cave N',
			OBJECTS::OBJ_DAEMONCAVE => 'Daemon Cave',
			OBJECTS::OBJN_FAERIERING => 'Faerie Ring N',
			OBJECTS::OBJ_FAERIERING => 'Faerie Ring',
			OBJECTS::OBJN_GRAVEYARD => 'Graveyard N',
			OBJECTS::OBJ_GRAVEYARD => 'Graveyard',
			OBJECTS::OBJN_DRAGONCITY => 'Dragon City N',
			OBJECTS::OBJ_DRAGONCITY => 'Dragon City',
			OBJECTS::OBJN_LIGHTHOUSE => 'Light House N',
			OBJECTS::OBJ_LIGHTHOUSE => 'Light House',
			OBJECTS::OBJN_WATERWHEEL => 'Water Wheel N',
			OBJECTS::OBJ_WATERWHEEL => 'Water Wheel',
			OBJECTS::OBJN_MINES => 'Mines N',
			OBJECTS::OBJ_MINES => 'Mines',
			OBJECTS::OBJN_OBELISK => 'Obelisk N',
			OBJECTS::OBJ_OBELISK => 'Obelisk',
			OBJECTS::OBJN_OASIS => 'Oasis N',
			OBJECTS::OBJ_OASIS => 'Oasis',
			OBJECTS::OBJN_SAWMILL => 'Sawmill N',
			OBJECTS::OBJ_SAWMILL => 'Sawmill',
			OBJECTS::OBJN_ORACLE => 'Oracle N',
			OBJECTS::OBJ_ORACLE => 'Oracle',
			OBJECTS::OBJN_DESERTTENT => 'Desert Tent N',
			OBJECTS::OBJ_DESERTTENT => 'Desert Tent',
			OBJECTS::OBJN_CASTLE => 'Castle N',
			OBJECTS::OBJ_CASTLE => 'Castle',
			OBJECTS::OBJN_WAGONCAMP => 'Wagon Camp N',
			OBJECTS::OBJ_WAGONCAMP => 'Wagon Camp',
			OBJECTS::OBJN_WINDMILL => 'Windmill N',
			OBJECTS::OBJ_WINDMILL => 'Windmill',
			OBJECTS::OBJN_RNDTOWN => 'Random Town N',
			OBJECTS::OBJ_RNDTOWN => 'Random Town',
			OBJECTS::OBJN_RNDCASTLE => 'Random Castle N',
			OBJECTS::OBJ_RNDCASTLE => 'Random Castle',
			OBJECTS::OBJN_WATCHTOWER => 'Watch Tower N',
			OBJECTS::OBJ_WATCHTOWER => 'Watch Tower',
			OBJECTS::OBJN_TREECITY => 'Tree City N',
			OBJECTS::OBJ_TREECITY => 'Tree City',
			OBJECTS::OBJN_TREEHOUSE => ' Tree House N',
			OBJECTS::OBJ_TREEHOUSE => ' Tree House',
			OBJECTS::OBJN_RUINS => 'Ruins N',
			OBJECTS::OBJ_RUINS => 'Ruins',
			OBJECTS::OBJN_FORT => 'Fort N',
			OBJECTS::OBJ_FORT => 'Fort',
			OBJECTS::OBJN_TRADINGPOST => 'Trading Post N',
			OBJECTS::OBJ_TRADINGPOST => 'Trading Post',
			OBJECTS::OBJN_ABANDONEDMINE => 'Abandoned Mine N',
			OBJECTS::OBJ_ABANDONEDMINE => 'Abandoned Mine',
			OBJECTS::OBJN_TREEKNOWLEDGE => 'Tree of Knowledge N',
			OBJECTS::OBJ_TREEKNOWLEDGE => 'Tree of Knowledge',
			OBJECTS::OBJN_DOCTORHUT => 'Witch Doctor\'s Hut N',
			OBJECTS::OBJ_DOCTORHUT => 'Witch Doctor\'s Hut',
			OBJECTS::OBJN_TEMPLE => 'Temple N',
			OBJECTS::OBJ_TEMPLE => 'Temple',
			OBJECTS::OBJN_HILLFORT => 'Hill Fort N',
			OBJECTS::OBJ_HILLFORT => 'Hill Fort',
			OBJECTS::OBJN_HALFLINGHOLE => 'Halfling Hole N',
			OBJECTS::OBJ_HALFLINGHOLE => 'Halfling Hole',
			OBJECTS::OBJN_MERCENARYCAMP => 'Mercenary Camp N',
			OBJECTS::OBJ_MERCENARYCAMP => 'Mercenary Camp',
			OBJECTS::OBJN_PYRAMID => 'Pyramid N',
			OBJECTS::OBJ_PYRAMID => 'Pyramid',
			OBJECTS::OBJN_CITYDEAD => 'City of the Dead N',
			OBJECTS::OBJ_CITYDEAD => 'City of the Dead',
			OBJECTS::OBJN_EXCAVATION => 'Excavation N',
			OBJECTS::OBJ_EXCAVATION => 'Excavation',
			OBJECTS::OBJN_SPHINX => 'Sphinx N',
			OBJECTS::OBJ_SPHINX => 'Sphinx',
			OBJECTS::OBJN_TROLLBRIDGE => 'Troll Bridge N',
			OBJECTS::OBJ_TROLLBRIDGE => 'Troll Bridge',
			OBJECTS::OBJN_WITCHSHUT => 'Witch Hut N',
			OBJECTS::OBJ_WITCHSHUT => 'Witch Hut',
			OBJECTS::OBJN_XANADU => 'Xanadu N',
			OBJECTS::OBJ_XANADU => 'Xanadu',
			OBJECTS::OBJN_CAVE => 'Cave N',
			OBJECTS::OBJ_CAVE => 'Cave',
			OBJECTS::OBJN_MAGELLANMAPS => 'Magellan Maps N',
			OBJECTS::OBJ_MAGELLANMAPS => 'Magellan Maps',
			OBJECTS::OBJN_DERELICTSHIP => 'Derelict Ship N',
			OBJECTS::OBJ_DERELICTSHIP => 'Derelict Ship',
			OBJECTS::OBJN_SHIPWRECK => 'Ship Wreck N',
			OBJECTS::OBJ_SHIPWRECK => 'Ship Wreck',
			OBJECTS::OBJN_OBSERVATIONTOWER => 'Observation Tower N',
			OBJECTS::OBJ_OBSERVATIONTOWER => 'Observation Tower',
			OBJECTS::OBJN_FREEMANFOUNDRY => 'Freeman Foundry N',
			OBJECTS::OBJ_FREEMANFOUNDRY => 'Freeman Foundry',
			OBJECTS::OBJN_WATERINGHOLE => 'Watering Hole N',
			OBJECTS::OBJ_WATERINGHOLE  => 'Watering Hole',
			OBJECTS::OBJN_ARTESIANSPRING => 'Artesian Spring N',
			OBJECTS::OBJ_ARTESIANSPRING => 'Artesian Spring',
			OBJECTS::OBJN_GAZEBO => 'Gazebo N',
			OBJECTS::OBJ_GAZEBO => 'Gazebo',
			OBJECTS::OBJN_ARCHERHOUSE => 'Archer\'s House N',
			OBJECTS::OBJ_ARCHERHOUSE => 'Archer\'s House',
			OBJECTS::OBJN_PEASANTHUT => 'Peasant Hut N',
			OBJECTS::OBJ_PEASANTHUT => 'Peasant Hut',
			OBJECTS::OBJN_DWARFCOTT => 'Dwarf Cottage N',
			OBJECTS::OBJ_DWARFCOTT => 'Dwarf Cottage',
			OBJECTS::OBJN_STONELIGHTS => 'Stone Liths N',
			OBJECTS::OBJ_STONELIGHTS => 'Stone Liths',
			OBJECTS::OBJN_MAGICWELL => ' Magic Well N',
			OBJECTS::OBJ_MAGICWELL => ' Magic Well',
			OBJECTS::OBJ_HEROES => 'Heroes',
			OBJECTS::OBJ_SIGN => 'Sign',
			OBJECTS::OBJ_SHRUB2 => 'Shrub',
			OBJECTS::OBJ_NOTHINGSPECIAL => 'Nothing Special',
			OBJECTS::OBJ_TARPIT => 'Tar Pit',
			OBJECTS::OBJ_COAST => 'Coast',
			OBJECTS::OBJ_MOUND => 'Mound',
			OBJECTS::OBJ_DUNE => 'Dune',
			OBJECTS::OBJ_STUMP => 'Stump',
			OBJECTS::OBJ_CACTUS => 'Cactus',
			OBJECTS::OBJ_TREES => 'Trees',
			OBJECTS::OBJ_DEADTREE => 'Dead Tree',
			OBJECTS::OBJ_MOUNTS => 'Mountains',
			OBJECTS::OBJ_VOLCANO => 'Volcano',
			OBJECTS::OBJ_STONES => 'Rock',
			OBJECTS::OBJ_FLOWERS => 'Flowers',
			OBJECTS::OBJ_WATERLAKE => 'Water Lake',
			OBJECTS::OBJ_MANDRAKE => 'Mandrake',
			OBJECTS::OBJ_CRATER => 'Crater',
			OBJECTS::OBJ_LAVAPOOL => 'Lava Pool',
			OBJECTS::OBJ_SHRUB => 'Shrub',
			OBJECTS::OBJ_BUOY => 'Buoy',
			OBJECTS::OBJN_SKELETON => 'Skeleton N',
			OBJECTS::OBJ_SKELETON => 'Skeleton',
			OBJECTS::OBJ_TREASURECHEST => 'Treasure Chest',
			OBJECTS::OBJ_WATERCHEST => 'Sea Chest',
			OBJECTS::OBJ_CAMPFIRE => 'Campfire',
			OBJECTS::OBJ_FOUNTAIN => 'Fountain',
			OBJECTS::OBJ_ANCIENTLAMP => 'Genie Lamp',
			OBJECTS::OBJ_GOBLINHUT => 'Goblin Hut',
			OBJECTS::OBJ_THATCHEDHUT => 'Thatched Hut',
			OBJECTS::OBJ_MONSTER => 'Monster',
			OBJECTS::OBJ_RESOURCE => 'Resource',
			OBJECTS::OBJ_WHIRLPOOL => 'Whirlpool',
			OBJECTS::OBJ_ARTIFACT => 'Artifact',
			OBJECTS::OBJ_BOAT => 'Boat',
			OBJECTS::OBJ_RNDARTIFACT => 'Random Artifact',
			OBJECTS::OBJ_RNDRESOURCE => 'Random Resource',
			OBJECTS::OBJ_RNDMONSTER1 => 'Random Monster 1',
			OBJECTS::OBJ_RNDMONSTER2 => 'Random Monster 2',
			OBJECTS::OBJ_RNDMONSTER3 => 'Random Monster 3',
			OBJECTS::OBJ_RNDMONSTER4 => 'Random Monster 4',
			OBJECTS::OBJ_STANDINGSTONES => 'Standing Stones',
			OBJECTS::OBJ_EVENT => 'Event',
			OBJECTS::OBJ_RNDMONSTER => 'Random Monster',
			OBJECTS::OBJ_RNDULTIMATEARTIFACT => 'Random Ultimate Artifact',
			OBJECTS::OBJ_IDOL   => 'Idol',
			OBJECTS::OBJ_SHRINE1 => ' Shrine of the First Circle',
			OBJECTS::OBJ_SHRINE2 => ' Shrine of the Second Circle',
			OBJECTS::OBJ_SHRINE3 => ' Shrine of the Third Circle',
			OBJECTS::OBJ_WAGON  => 'Wagon',
			OBJECTS::OBJ_LEANTO => 'Lean To',
			OBJECTS::OBJ_FLOTSAM => ' Flotsam',
			OBJECTS::OBJ_SHIPWRECKSURVIROR => ' Shipwreck Survivor',
			OBJECTS::OBJ_BOTTLE => 'Bottle',
			OBJECTS::OBJ_MAGICGARDEN => 'Magic Garden',
			OBJECTS::OBJ_RNDARTIFACT1   => 'Random Artifact 1',
			OBJECTS::OBJ_RNDARTIFACT2  => 'Random Artifact 2',
			OBJECTS::OBJ_RNDARTIFACT3  => 'Random Artifact 3',
			OBJECTS::OBJN_JAIL => 'Jail N',
			OBJECTS::OBJ_JAIL => 'Jail',
			OBJECTS::OBJN_TRAVELLERTENT => 'Traveller\'s Tent N',
			OBJECTS::OBJ_TRAVELLERTENT => 'Traveller\'s Tent',
			OBJECTS::OBJ_BARRIER => 'Barrier',
			OBJECTS::OBJN_FIREALTAR => 'Fire Summoning Altar N',
			OBJECTS::OBJ_FIREALTAR => 'Fire Summoning Altar',
			OBJECTS::OBJN_AIRALTAR => 'Air Summoning Altar N',
			OBJECTS::OBJ_AIRALTAR => 'Air Summoning Altar',
			OBJECTS::OBJN_EARTHALTAR => 'Earth Summoning Altar N',
			OBJECTS::OBJ_EARTHALTAR => 'Earth Summoning Altar',
			OBJECTS::OBJN_WATERALTAR => 'Water Summoning Altar N',
			OBJECTS::OBJ_WATERALTAR => 'Water Summoning Altar',
			OBJECTS::OBJN_BARROWMOUNDS => 'Barrow Mounds N',
			OBJECTS::OBJ_BARROWMOUNDS => 'Barrow Mounds',
			OBJECTS::OBJN_ARENA => 'Arena N',
			OBJECTS::OBJ_ARENA => 'Arena',
			OBJECTS::OBJN_STABLES => 'Stables N',
			OBJECTS::OBJ_STABLES => 'Stables',
			OBJECTS::OBJN_ALCHEMYTOWER => 'Alchemist\'s Tower N',
			OBJECTS::OBJ_ALCHEMYTOWER => 'Alchemist\'s Tower',
			OBJECTS::OBJN_HUTMAGI => 'Hut of the Magi N',
			OBJECTS::OBJ_HUTMAGI => 'Hut of the Magi',
			OBJECTS::OBJN_EYEMAGI => 'Eye of the Magi N',
			OBJECTS::OBJ_EYEMAGI => 'Eye of the Magi',
			OBJECTS::OBJN_MERMAID => 'Mermaid N',
			OBJECTS::OBJ_MERMAID => 'Mermaid',
			OBJECTS::OBJN_SIRENS => 'Sirens N',
			OBJECTS::OBJ_SIRENS => 'Sirens',
			OBJECTS::OBJ_REEFS => 'Reefs',
			OBJECTS::OBJ_UNKNW_02 => 'OBJ_UNKNW_02',
			OBJECTS::OBJ_UNKNW_03 => 'OBJ_UNKNW_03',
			OBJECTS::OBJ_UNKNW_06 => 'OBJ_UNKNW_06',
			OBJECTS::OBJ_UNKNW_08 => 'OBJ_UNKNW_08',
			OBJECTS::OBJ_UNKNW_09 => 'OBJ_UNKNW_09',
			OBJECTS::OBJ_UNKNW_0B => 'OBJ_UNKNW_0B',
			OBJECTS::OBJ_UNKNW_0E => 'OBJ_UNKNW_0E',
			OBJECTS::OBJ_UNKNW_11 => 'OBJ_UNKNW_11',
			OBJECTS::OBJ_UNKNW_12 => 'OBJ_UNKNW_12',
			OBJECTS::OBJ_UNKNW_13 => 'OBJ_UNKNW_13',
			OBJECTS::OBJ_UNKNW_18 => 'OBJ_UNKNW_18',
			OBJECTS::OBJ_UNKNW_1B => 'OBJ_UNKNW_1B',
			OBJECTS::OBJ_UNKNW_1F => 'OBJ_UNKNW_1F',
			OBJECTS::OBJ_UNKNW_21 => 'OBJ_UNKNW_21',
			OBJECTS::OBJ_UNKNW_26 => 'OBJ_UNKNW_26',
			OBJECTS::OBJ_UNKNW_27 => 'OBJ_UNKNW_27',
			OBJECTS::OBJ_UNKNW_29 => 'OBJ_UNKNW_29',
			OBJECTS::OBJ_UNKNW_2A => 'OBJ_UNKNW_2A',
			OBJECTS::OBJ_UNKNW_2B => 'OBJ_UNKNW_2B',
			OBJECTS::OBJ_UNKNW_2C => 'OBJ_UNKNW_2C',
			OBJECTS::OBJ_UNKNW_2D => 'OBJ_UNKNW_2D',
			OBJECTS::OBJ_UNKNW_2E => 'OBJ_UNKNW_2E',
			OBJECTS::OBJ_UNKNW_2F => 'OBJ_UNKNW_2F',
			OBJECTS::OBJ_UNKNW_32 => 'OBJ_UNKNW_32',
			OBJECTS::OBJ_UNKNW_33 => 'OBJ_UNKNW_33',
			OBJECTS::OBJ_UNKNW_34 => 'OBJ_UNKNW_34',
			OBJECTS::OBJ_UNKNW_35 => 'OBJ_UNKNW_35',
			OBJECTS::OBJ_UNKNW_36 => 'OBJ_UNKNW_36',
			OBJECTS::OBJ_UNKNW_37 => 'OBJ_UNKNW_37',
			OBJECTS::OBJ_UNKNW_41 => 'OBJ_UNKNW_41',
			OBJECTS::OBJ_UNKNW_42 => 'OBJ_UNKNW_42',
			OBJECTS::OBJ_UNKNW_43 => 'OBJ_UNKNW_43',
			OBJECTS::OBJ_UNKNW_4A => 'OBJ_UNKNW_4A',
			OBJECTS::OBJ_UNKNW_4B => 'OBJ_UNKNW_4B',
			OBJECTS::OBJ_UNKNW_50 => 'OBJ_UNKNW_50',
			OBJECTS::OBJ_UNKNW_58 => 'OBJ_UNKNW_58',
			OBJECTS::OBJ_UNKNW_5A => 'OBJ_UNKNW_5A',
			OBJECTS::OBJ_UNKNW_5C => 'OBJ_UNKNW_5C',
			OBJECTS::OBJ_UNKNW_5D => 'OBJ_UNKNW_5D',
			OBJECTS::OBJ_UNKNW_5F => 'OBJ_UNKNW_5F',
			OBJECTS::OBJ_UNKNW_62 => 'OBJ_UNKNW_62',
			OBJECTS::OBJ_UNKNW_79 => 'OBJ_UNKNW_79',
			OBJECTS::OBJ_UNKNW_7A => 'OBJ_UNKNW_7A',
			OBJECTS::OBJ_UNKNW_91 => 'OBJ_UNKNW_91',
			OBJECTS::OBJ_UNKNW_92 => 'OBJ_UNKNW_92',
			OBJECTS::OBJ_UNKNW_A1 => 'OBJ_UNKNW_A1',
			OBJECTS::OBJ_UNKNW_A6 => 'OBJ_UNKNW_A6',
			OBJECTS::OBJ_UNKNW_AA => 'OBJ_UNKNW_AA',
			OBJECTS::OBJ_UNKNW_B2 => 'OBJ_UNKNW_B2',
			OBJECTS::OBJ_UNKNW_B8 => 'OBJ_UNKNW_B8',
			OBJECTS::OBJ_UNKNW_B9 => 'OBJ_UNKNW_B9',
			OBJECTS::OBJ_UNKNW_D1 => 'OBJ_UNKNW_D1',
			OBJECTS::OBJ_UNKNW_E2 => 'OBJ_UNKNW_E2',
			OBJECTS::OBJ_UNKNW_E3 => 'OBJ_UNKNW_E3',
			OBJECTS::OBJ_UNKNW_E4 => 'OBJ_UNKNW_E4',
			OBJECTS::OBJ_UNKNW_E5 => 'OBJ_UNKNW_E5',
			OBJECTS::OBJ_UNKNW_E6 => 'OBJ_UNKNW_E6',
			OBJECTS::OBJ_UNKNW_E7 => 'OBJ_UNKNW_E7',
			OBJECTS::OBJ_UNKNW_E8 => 'OBJ_UNKNW_E8',
			OBJECTS::OBJ_UNKNW_F9 => 'OBJ_UNKNW_F9',
			OBJECTS::OBJ_UNKNW_FA => 'OBJ_UNKNW_FA',
		];

		public $Mines = [
			0 => 'Sawmill',
			1 => 'Alchemist\'s Lab',
			2 => 'Ore Pit',
			3 => 'Sulfur Dune',
			4 => 'Crystal Cavern',
			5 => 'Gem Pond',
			6 => 'Gold Mine',
			7 => 'Abandoned Mine',
		];

		public $Resources = [
			0 => 'Wood',
			1 => 'Mercury',
			2 => 'Ore',
			3 => 'Sulfur',
			4 => 'Crystal',
			5 => 'Gems',
			6 => 'Gold',
		];

		public $Artifacts = [
			0 => 'Ultimate Book of Knowledge',
			1 => 'Ultimate Sword of Dominion',
			2 => 'Ultimate Cloak of Protection',
			3 => 'Ultimate Wand of Magic',
			4 => 'Ultimate Shield',
			5 => 'Ultimate Staff',
			6 => 'Ultimate Crown',
			7 => 'Golden Goose',
			8 => 'Arcane Necklace of Magic',
			9 => 'Caster\'s Bracelet of Magic',
			10 => 'Mage\'s Ring of Power',
			11 => 'Witch\'s Broach of Magic',
			12 => 'Medal of Valor',
			13 => 'Medal of Courage',
			14 => 'Medal of Honor',
			15 => 'Medal of Distinction',
			16 => 'Fizbin of Misfortune',
			17 => 'Thunder Mace of Dominion',
			18 => 'Armored Gauntlets of Protection',
			19 => 'Defender Helm of Protection',
			20 => 'Giant Flail of Dominion',
			21 => 'Ballista of Quickness',
			22 => 'Stealth Shield of Protection',
			23 => 'Dragon Sword of Dominion',
			24 => 'Power Axe of Dominion',
			25 => 'Divine Breastplate of Protection',
			26 => 'Minor Scroll of Knowledge',
			27 => 'Major Scroll of Knowledge',
			28 => 'Superior Scroll of Knowledge',
			29 => 'Foremost Scroll of Knowledge',
			30 => 'Endless Sack of Gold',
			31 => 'Endless Bag of Gold',
			32 => 'Endless Purse of Gold',
			33 => 'Nomad Boots of Mobility',
			34 => 'Traveler\'s Boots of Mobility',
			35 => 'Lucky Rabbit\'s Foot',
			36 => 'Golden Horseshoe',
			37 => 'Gambler\'s Lucky Coin',
			38 => 'Four-Leaf Clover',
			39 => 'True Compass of Mobility',
			40 => 'Sailor\'s Astrolabe of Mobility',
			41 => 'Evil Eye',
			42 => 'Enchanted Hourglass',
			43 => 'Gold Watch',
			44 => 'Skullcap',
			45 => 'Ice Cloak',
			46 => 'Fire Cloak',
			47 => 'Lightning Helm',
			48 => 'Evercold Icicle',
			49 => 'Everhot Lava Rock',
			50 => 'Lightning Rod',
			51 => 'Snake-Ring',
			52 => 'Ankh',
			53 => 'Book of Elements',
			54 => 'Elemental Ring',
			55 => 'Holy Pendant',
			56 => 'Pendant of Free Will',
			57 => 'Pendant of Life',
			58 => 'Serenity Pendant',
			59 => 'Seeing-eye Pendant',
			60 => 'Kinetic Pendant',
			61 => 'Pendant of Death',
			62 => 'Wand of Negation',
			63 => 'Golden Bow',
			64 => 'Telescope',
			65 => 'Statesman\'s Quill',
			66 => 'Wizard\'s Hat',
			67 => 'Power Ring',
			68 => 'Ammo Cart',
			69 => 'Tax Lien',
			70 => 'Hideous Mask',
			71 => 'Endless Pouch of Sulfur',
			72 => 'Endless Vial of Mercury',
			73 => 'Endless Pouch of Gems',
			74 => 'Endless Cord of Wood',
			75 => 'Endless Cart of Ore',
			76 => 'Endless Pouch of Crystal',
			77 => 'Spiked Helm',
			78 => 'Spiked Shield',
			79 => 'White Pearl',
			80 => 'Black Pearl',
			81 => 'Magic Book',
			82 => 'Dummy 1',
			83 => 'Dummy 2',
			84 => 'Dummy 3',
			85 => 'Dummy 4',
			86 => 'Spell Scroll',
			87 => 'Arm of the Martyr',
			88 => 'Breastplate of Anduran',
			89 => 'Broach of Shielding',
			90 => 'Battle Garb of Anduran',
			91 => 'Crystal Ball',
			92 => 'Heart of Fire',
			93 => 'Heart of Ice',
			94 => 'Helmet of Anduran',
			95 => 'Holy Hammer',
			96 => 'Legendary Scepter',
			97 => 'Masthead',
			98 => 'Sphere of Negation',
			99 => 'Staff of Wizardry',
			100 => 'Sword Breaker',
			101 => 'Sword of Anduran',
			102 => 'Spade of Necromancy',
			103 => 'Unknown',
		];

		public $Spells = [
			0 => 'Unknown',
			1 => 'Fireball',
			2 => 'Fireblast',
			3 => 'Lightning Bolt',
			4 => 'Chain Lightning',
			5 => 'Teleport',
			6 => 'Cure',
			7 => 'Mass Cure',
			8 => 'Resurrect',
			9 => 'Resurrect True',
			10 => 'Haste',
			11 => 'Mass Haste',
			12 => 'Slow',
			13 => 'Mass Slow',
			14 => 'Blind',
			15 => 'Bless',
			16 => 'Mass Bless',
			17 => 'Stoneskin',
			18 => 'Steelskin',
			19 => 'Curse',
			20 => 'Mass Curse',
			21 => 'Holy Word',
			22 => 'Holy Shout',
			23 => 'Anti-Magic',
			24 => 'Dispel Magic',
			25 => 'Mass Dispel',
			26 => 'Magic Arrow',
			27 => 'Berserker',
			28 => 'Armageddon',
			29 => 'Elemental Storm',
			30 => 'Meteor Shower',
			31 => 'Paralyze',
			32 => 'Hypnotize',
			33 => 'Cold Ray',
			34 => 'Cold Ring',
			35 => 'Disrupting Ray',
			36 => 'Death Ripple',
			37 => 'Death Wave',
			38 => 'Dragon Slayer',
			39 => 'Blood Lust',
			40 => 'Animate Dead',
			41 => 'Mirror Image',
			42 => 'Shield',
			43 => 'Mass Shield',
			44 => 'Summon Earth Elemental',
			45 => 'Summon Air Elemental',
			46 => 'Summon Fire Elemental',
			47 => 'Summon Water Elemental',
			48 => 'Earthquake',
			49 => 'View Mines',
			50 => 'View Resources',
			51 => 'View Artifacts',
			52 => 'View Towns',
			53 => 'View Heroes',
			54 => 'View All',
			55 => 'Identify Hero',
			56 => 'Summon Boat',
			57 => 'Dimension Door',
			58 => 'Town Gate',
			59 => 'Town Portal',
			60 => 'Visions',
			61 => 'Haunt',
			62 => 'Set Earth Guardian',
			63 => 'Set Air Guardian',
			64 => 'Set Fire Guardian',
			65 => 'Set Water Guardian',
		];


		public $Heroes = [
			// knight
			0 => 'Lord Kilburn',
			1 => 'Sir Gallanth',
			2 => 'Ector',
			3 => 'Gwenneth',
			4 => 'Tyro',
			5 => 'Ambrose',
			6 => 'Ruby',
			7 => 'Maximus',
			8 => 'Dimitry',
			// barbarian
			9 => 'Thundax',
			10 => 'Fineous',
			11 => 'Jojosh',
			12 => 'Crag Hack',
			13 => 'Jezebel',
			14 => 'Jaclyn',
			15 => 'Ergon',
			16 => 'Tsabu',
			17 => 'Atlas',
			// sorceress
			18 => 'Astra',
			19 => 'Natasha',
			20 => 'Troyan',
			21 => 'Vatawna',
			22 => 'Rebecca',
			23 => 'Gem',
			24 => 'Ariel',
			25 => 'Carlawn',
			26 => 'Luna',
			// warlock
			27 => 'Arie',
			28 => 'Alamar',
			29 => 'Vesper',
			30 => 'Crodo',
			31 => 'Barok',
			32 => 'Kastore',
			33 => 'Agar',
			34 => 'Falagar',
			35 => 'Wrathmont',
			// wizard
			36 => 'Myra',
			37 => 'Flint',
			38 => 'Dawn',
			39 => 'Halon',
			40 => 'Myrini',
			41 => 'Wilfrey',
			42 => 'Sarakin',
			43 => 'Kalindra',
			44 => 'Mandigal',
			// necromant
			45 => 'Zom',
			46 => 'Darlana',
			47 => 'Zam',
			48 => 'Ranloo',
			49 => 'Charity',
			50 => 'Rialdo',
			51 => 'Roxana',
			52 => 'Sandro',
			53 => 'Celia',
			// campains
			54 => 'Roland',
			55 => 'Lord Corlagon',
			56 => 'Sister Eliza',
			57 => 'Archibald',
			58 => 'Lord Halton',
			59 => 'Brother Bax',
			// loyalty version
			60 => 'Solmyr',
			61 => 'Dainwin',
			62 => 'Mog',
			63 => 'Uncle Ivan',
			64 => 'Joseph',
			65 => 'Gallavant',
			66 => 'Elderian',
			67 => 'Ceallach',
			68 => 'Drakonia',
			69 => 'Martine',
			70 => 'Jarkonas',
			// debug
			71 => 'SandySandy',
			72 => 'Unknown',
		];

		public $ObjectsNonPassable = [
			OBJECTS::OBJN_ABANDONEDMINE,
			OBJECTS::OBJN_AIRALTAR,
			OBJECTS::OBJN_ALCHEMYLAB,
			OBJECTS::OBJN_ALCHEMYTOWER,
			OBJECTS::OBJN_ARENA,
			OBJECTS::OBJN_ARCHERHOUSE,
			OBJECTS::OBJN_ARTESIANSPRING,
			OBJECTS::OBJN_BARROWMOUNDS,
			OBJECTS::OBJN_CASTLE,
			OBJECTS::OBJN_CAVE,
			OBJECTS::OBJN_CITYDEAD,
			OBJECTS::OBJN_DAEMONCAVE,
			OBJECTS::OBJN_DERELICTSHIP,
			OBJECTS::OBJN_DESERTTENT,
			OBJECTS::OBJN_DOCTORHUT,
			OBJECTS::OBJN_DRAGONCITY,
			OBJECTS::OBJN_DWARFCOTT,
			OBJECTS::OBJN_EARTHALTAR,
			OBJECTS::OBJN_EXCAVATION,
			OBJECTS::OBJN_EYEMAGI,
			OBJECTS::OBJN_FAERIERING,
			OBJECTS::OBJN_FIREALTAR,
			OBJECTS::OBJN_FORT,
			OBJECTS::OBJN_FREEMANFOUNDRY,
			OBJECTS::OBJN_GAZEBO,
			OBJECTS::OBJN_GRAVEYARD,
			OBJECTS::OBJN_HALFLINGHOLE,
			OBJECTS::OBJN_HILLFORT,
			OBJECTS::OBJN_HUTMAGI,
			OBJECTS::OBJN_JAIL,
			OBJECTS::OBJN_LIGHTHOUSE,
			OBJECTS::OBJN_MAGELLANMAPS,
			OBJECTS::OBJN_MAGICWELL,
			OBJECTS::OBJN_MERCENARYCAMP,
			OBJECTS::OBJN_MERMAID,
			OBJECTS::OBJN_MINES,
			OBJECTS::OBJN_OASIS,
			OBJECTS::OBJN_OBELISK,
			OBJECTS::OBJN_OBSERVATIONTOWER,
			OBJECTS::OBJN_ORACLE,
			OBJECTS::OBJN_PEASANTHUT,
			OBJECTS::OBJN_PYRAMID,
			OBJECTS::OBJN_RNDCASTLE,
			OBJECTS::OBJN_RNDTOWN,
			OBJECTS::OBJN_RUINS,
			OBJECTS::OBJN_SAWMILL,
			OBJECTS::OBJN_SHIPWRECK,
			OBJECTS::OBJN_SIRENS,
			OBJECTS::OBJN_SKELETON,
			OBJECTS::OBJN_SPHINX,
			OBJECTS::OBJN_STABLES,
			OBJECTS::OBJN_STONELIGHTS,
			OBJECTS::OBJN_TEMPLE,
			OBJECTS::OBJN_TRADINGPOST,
			OBJECTS::OBJN_TRAVELLERTENT,
			OBJECTS::OBJN_TREECITY,
			OBJECTS::OBJN_TREEHOUSE,
			OBJECTS::OBJN_TREEKNOWLEDGE,
			OBJECTS::OBJN_TROLLBRIDGE,
			OBJECTS::OBJN_WAGONCAMP,
			OBJECTS::OBJN_WATERALTAR,
			OBJECTS::OBJN_WATERINGHOLE,
			OBJECTS::OBJN_WATERWHEEL,
			OBJECTS::OBJN_WATCHTOWER,
			OBJECTS::OBJN_WINDMILL,
			OBJECTS::OBJN_WITCHSHUT,
			OBJECTS::OBJN_XANADU,

			OBJECTS::OBJ_CACTUS,
			OBJECTS::OBJ_CRATER,
			OBJECTS::OBJ_DEADTREE,
			OBJECTS::OBJ_DUNE,
			OBJECTS::OBJ_FLOWERS,
			OBJECTS::OBJ_LAVAPOOL,
			OBJECTS::OBJ_MOUND,
			OBJECTS::OBJ_MOUNTS,
			OBJECTS::OBJ_REEFS,
			OBJECTS::OBJ_SHRUB,
			OBJECTS::OBJ_SHRUB2,
			OBJECTS::OBJ_STONES,
			OBJECTS::OBJ_STUMP,
			OBJECTS::OBJ_TARPIT,
			OBJECTS::OBJ_TREES,
			OBJECTS::OBJ_VOLCANO,
			OBJECTS::OBJ_WATERLAKE,
		];

		public $Victory = [
			VICTORY::NONE => 'Standard',
			VICTORY::CAPTURETOWN => 'Capture a specific town',
			VICTORY::DEFEATHERO => 'Defeat a specific Hero',
			VICTORY::ARTIFACT => 'Acquire a specific artifact',
			VICTORY::ALLIED => 'Your side defeats the opposing side',
			VICTORY::GOLD => 'Accumulate gold',
		];

		public $Loss = [
			LOSS::NONE => 'None',
			LOSS::TOWN => 'Lose a specific town',
			LOSS::HERO => 'Lose a specific hero',
			LOSS::TIME => 'Time expire',
		];
	}







?>
