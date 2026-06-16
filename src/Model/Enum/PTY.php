<?php
declare(strict_types=1);

namespace SPC\Model\Enum;

enum PTY: int
{
	case Undefined = 0;
	case News = 1;
	case CurrentAffairs = 2;
	case Information = 3;
	case Sport = 4;
	case Education = 5;
	case Drama = 6;
	case Culture = 7;
	case Science = 8;
	case Varied = 9;
	case PopMusic = 10;
	case RockMusic = 11;
	case EasyListening = 12;
	case LightClassical = 13;
	case SeriousClassical = 14;
	case OtherMusic = 15;
	case Weather = 16;
	case Finance = 17;
	case ChildrensProgrammes = 18;
	case SocialAffairs = 19;
	case Religion = 20;
	case PhoneIn = 21;
	case Travel = 22;
	case Leisure = 23;
	case Jazz = 24;
	case Country = 25;
	case NationalMusic = 26;
	case Oldies = 27;
	case FolkMusic = 28;
	case Documentary = 29;
	case AlarmTest = 30;
	case Alarm = 31;
}
