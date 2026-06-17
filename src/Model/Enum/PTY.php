<?php
declare(strict_types=1);

namespace SPC\Model\Enum;

enum PTY: int
{
	case None = 0;
	case News = 1;
	case Information = 2;
	case Sports = 3;
	case Talk = 4;
	case Rock = 5;
	case ClassicRock = 6;
	case AdultHits = 7;
	case SoftRock = 8;
	case Top40 = 9;
	case Country = 10;
	case Oldies = 11;
	case SoftMusic = 12;
	case Nostalgia = 13;
	case Jazz = 14;
	case Classical = 15;
	case RhythmBlues = 16;
	case SoftRhythmBlues = 17;
	case Language = 18;
	case ReligiousMusic = 19;
	case ReligiousTalk = 20;
	case Personality = 21;
	case Public = 22;
	case College = 23;
	case Unassigned24 = 24;
	case Unassigned25 = 25;
	case Unassigned26 = 26;
	case Unassigned27 = 27;
	case Unassigned28 = 28;
	case Weather = 29;
	case EmergencyTest = 30;
	case Emergency = 31;
}
