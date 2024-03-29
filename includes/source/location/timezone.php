<?php
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * @package datavice-wp-plugin
     * @version 0.1.0
     * Data for Provinces in the Philippines only.
    */

	$dv_tz_list = "('AD', 'Europe/Andorra', '+01:00', '+02:00'),
	('AE', 'Asia/Dubai', '+04:00', '+04:00'),
	('AF', 'Asia/Kabul', '+04:30', '+04:30'),
	('AG', 'America/Antigua', '−04:00', '−04:00'),
	('AI', 'America/Anguilla', '−04:00', '−04:00'),
	('AL', 'Europe/Tirane', '+01:00', '+02:00'),
	('AM', 'Asia/Yerevan', '+04:00', '+04:00'),
	('AO', 'Africa/Luanda', '+01:00', '+01:00'),
	('AQ', 'Antarctica/Casey', '+11:00', '+11:00'),
	('AQ', 'Antarctica/Davis', '+07:00', '+07:00'),
	('AQ', 'Antarctica/DumontDUr', '+10:00', '+10:00'),
	('AQ', 'Antarctica/Mawson', '+05:00', '+05:00'),
	('AQ', 'Antarctica/McMurdo', '+12:00', '+13:00'),
	('AQ', 'Antarctica/Palmer', '−03:00', '−03:00'),
	('AQ', 'Antarctica/Rothera', '−03:00', '−03:00'),
	('AQ', 'Antarctica/Syowa', '+03:00', '+03:00'),
	('AQ', 'Antarctica/Troll', '+00:00', '+02:00'),
	('AQ', 'Antarctica/Vostok', '+06:00', '+06:00'),
	('AR', 'America/Argentina/Bu', '−03:00', '−03:00'),
	('AR', 'America/Argentina/Ca', '−03:00', '−03:00'),
	('AR', 'America/Argentina/Co', '−03:00', '−03:00'),
	('AR', 'America/Argentina/Ju', '−03:00', '−03:00'),
	('AR', 'America/Argentina/La', '−03:00', '−03:00'),
	('AR', 'America/Argentina/Me', '−03:00', '−03:00'),
	('AR', 'America/Argentina/Ri', '−03:00', '−03:00'),
	('AR', 'America/Argentina/Sa', '−03:00', '−03:00'),
	('AR', 'America/Argentina/Sa', '−03:00', '−03:00'),
	('AR', 'America/Argentina/Sa', '−03:00', '−03:00'),
	('AR', 'America/Argentina/Tu', '−03:00', '−03:00'),
	('AR', 'America/Argentina/Us', '−03:00', '−03:00'),
	('AS', 'Pacific/Pago_Pago', '−11:00', '−11:00'),
	('AT', 'Europe/Vienna', '+01:00', '+02:00'),
	('AU', 'Antarctica/Macquarie', '+11:00', '+11:00'),
	('AU', 'Australia/Adelaide', '+09:30', '+10:30'),
	('AU', 'Australia/Brisbane', '+10:00', '+10:00'),
	('AU', 'Australia/Broken_Hil', '+09:30', '+10:30'),
	('AU', 'Australia/Currie', '+10:00', '+11:00'),
	('AU', 'Australia/Darwin', '+09:30', '+09:30'),
	('AU', 'Australia/Eucla', '+08:45', '+08:45'),
	('AU', 'Australia/Hobart', '+10:00', '+11:00'),
	('AU', 'Australia/Lindeman', '+10:00', '+10:00'),
	('AU', 'Australia/Lord_Howe', '+10:30', '+11:00'),
	('AU', 'Australia/Melbourne', '+10:00', '+11:00'),
	('AU', 'Australia/Perth', '+08:00', '+08:00'),
	('AU', 'Australia/Sydney', '+10:00', '+11:00'),
	('AW', 'America/Aruba', '−04:00', '−04:00'),
	('AX', 'Europe/Mariehamn', '+02:00', '+03:00'),
	('AZ', 'Asia/Baku', '+04:00', '+04:00'),
	('BA', 'Europe/Sarajevo', '+01:00', '+02:00'),
	('BB', 'America/Barbados', '−04:00', '−04:00'),
	('BD', 'Asia/Dhaka', '+06:00', '+06:00'),
	('BE', 'Europe/Brussels', '+01:00', '+02:00'),
	('BF', 'Africa/Ouagadougou', '+00:00', '+00:00'),
	('BG', 'Europe/Sofia', '+02:00', '+03:00'),
	('BH', 'Asia/Bahrain', '+03:00', '+03:00'),
	('BH', 'Europe/Sarajevo', '+01:00', '+02:00'),
	('BI', 'Africa/Bujumbura', '+02:00', '+02:00'),
	('BJ', 'Africa/Porto-Novo', '+01:00', '+01:00'),
	('BL', 'America/St_Barthelem', '−04:00', '−04:00'),
	('BM', 'Atlantic/Bermuda', '−04:00', '−03:00'),
	('BN', 'Asia/Brunei', '+08:00', '+08:00'),
	('BO', 'America/La_Paz', '−04:00', '−04:00'),
	('BQ', 'America/Kralendijk', '−04:00', '−04:00'),
	('BR', 'America/Araguaina', '−03:00', '−03:00'),
	('BR', 'America/Bahia', '−03:00', '−03:00'),
	('BR', 'America/Belem', '−03:00', '−03:00'),
	('BR', 'America/Boa_Vista', '−04:00', '−04:00'),
	('BR', 'America/Campo_Grande', '−04:00', '−03:00'),
	('BR', 'America/Cuiaba', '−04:00', '−03:00'),
	('BR', 'America/Eirunepe', '−05:00', '−05:00'),
	('BR', 'America/Fortaleza', '−03:00', '−03:00'),
	('BR', 'America/Maceio', '−03:00', '−03:00'),
	('BR', 'America/Manaus', '−04:00', '−04:00'),
	('BR', 'America/Noronha', '−02:00', '−02:00'),
	('BR', 'America/Porto_Velho', '−04:00', '−04:00'),
	('BR', 'America/Recife', '−03:00', '−03:00'),
	('BR', 'America/Rio_Branco', '−05:00', '−05:00'),
	('BR', 'America/Santarem', '−03:00', '−03:00'),
	('BR', 'America/Sao_Paulo', '−03:00', '−03:00'),
	('BS', 'America/Nassau', '−05:00', '−04:00'),
	('BT', 'Asia/Thimphu', '+06:00', '+06:00'),
	('BW', 'Africa/Gaborone', '+02:00', '+02:00'),
	('BY', 'Europe/Minsk', '+03:00', '+03:00'),
	('BZ', 'America/Belize', '−06:00', '−06:00'),
	('CA', 'America/Atikokan', '−05:00', '−05:00'),
	('CA', 'America/Blanc-Sablon', '−04:00', '−04:00'),
	('CA', 'America/Cambridge_Ba', '−07:00', '−06:00'),
	('CA', 'America/Creston', '−07:00', '−07:00'),
	('CA', 'America/Dawson', '−08:00', '−07:00'),
	('CA', 'America/Dawson_Creek', '−07:00', '−07:00'),
	('CA', 'America/Edmonton', '−07:00', '−06:00'),
	('CA', 'America/Fort_Nelson', '−07:00', '−07:00'),
	('CA', 'America/Glace_Bay', '−04:00', '−03:00'),
	('CA', 'America/Goose_Bay', '−04:00', '−03:00'),
	('CA', 'America/Halifax', '−04:00', '−03:00'),
	('CA', 'America/Inuvik', '−07:00', '−06:00'),
	('CA', 'America/Iqaluit', '−05:00', '−04:00'),
	('CA', 'America/Moncton', '−04:00', '−03:00'),
	('CA', 'America/Nipigon', '−05:00', '−04:00'),
	('CA', 'America/Pangnirtung', '−05:00', '−04:00'),
	('CA', 'America/Rainy_River', '−06:00', '−05:00'),
	('CA', 'America/Rankin_Inlet', '−06:00', '−05:00'),
	('CA', 'America/Regina', '−06:00', '−06:00'),
	('CA', 'America/Resolute', '−06:00', '−05:00'),
	('CA', 'America/St_Johns', '−03:30', '−02:30'),
	('CA', 'America/Swift_Curren', '−06:00', '−06:00'),
	('CA', 'America/Thunder_Bay', '−05:00', '−04:00'),
	('CA', 'America/Toronto', '−05:00', '−04:00'),
	('CA', 'America/Vancouver', '−08:00', '−07:00'),
	('CA', 'America/Whitehorse', '−08:00', '−07:00'),
	('CA', 'America/Winnipeg', '−06:00', '−05:00'),
	('CA', 'America/Yellowknife', '−07:00', '−06:00'),
	('CC', 'Indian/Cocos', '+06:30', '+06:30'),
	('CD', 'Africa/Kinshasa', '+01:00', '+01:00'),
	('CD', 'Africa/Lubumbashi', '+02:00', '+02:00'),
	('CF', 'Africa/Bangui', '+01:00', '+01:00'),
	('CG', 'Africa/Brazzaville', '+01:00', '+01:00'),
	('CH', 'Europe/Zurich', '+01:00', '+02:00'),
	('CI', 'Africa/Abidjan', '+00:00', '+00:00'),
	('CK', 'Pacific/Rarotonga', '−10:00', '−10:00'),
	('CL', 'America/Punta_Arenas', '−03:00', '−03:00'),
	('CL', 'America/Santiago', '−04:00', '−03:00'),
	('CL', 'Pacific/Easter', '−06:00', '−05:00'),
	('CM', 'Africa/Douala', '+01:00', '+01:00'),
	('CN', 'Asia/Shanghai', '+08:00', '+08:00'),
	('CN', 'Asia/Urumqi', '+06:00', '+06:00'),
	('CO', 'America/Bogota', '−05:00', '−05:00'),
	('CR', 'America/Costa_Rica', '−06:00', '−06:00'),
	('CU', 'America/Havana', '−05:00', '−04:00'),
	('CV', 'Atlantic/Cape_Verde', '−01:00', '−01:00'),
	('CW', 'America/Curacao', '−04:00', '−04:00'),
	('CX', 'Indian/Christmas', '+07:00', '+07:00'),
	('CY', 'Asia/Famagusta', '+02:00', '+02:00'),
	('CY', 'Asia/Nicosia', '+02:00', '+03:00'),
	('CZ', 'Europe/Prague', '+01:00', '+02:00'),
	('DE', 'Europe/Berlin', '+01:00', '+02:00'),
	('DE', 'Europe/Busingen', '+01:00', '+02:00'),
	('DJ', 'Africa/Djibouti', '+03:00', '+03:00'),
	('DK', 'Europe/Copenhagen', '+01:00', '+02:00'),
	('DM', 'America/Dominica', '−04:00', '−04:00'),
	('DO', 'America/Santo_Doming', '−04:00', '−04:00'),
	('DZ', 'Africa/Algiers', '+01:00', '+01:00'),
	('EC', 'America/Guayaquil', '−05:00', '−05:00'),
	('EC', 'Pacific/Galapagos', '−06:00', '−06:00'),
	('EE', 'Europe/Tallinn', '+02:00', '+03:00'),
	('EG', 'Africa/Cairo', '+02:00', '+02:00'),
	('EH', 'Africa/El_Aaiun', '+00:00', '+01:00'),
	('ER', 'Africa/Asmara', '+03:00', '+03:00'),
	('ES', 'Africa/Ceuta', '+01:00', '+01:00'),
	('ES', 'Atlantic/Canary', '+00:00', '+01:00'),
	('ES', 'Europe/Madrid', '+01:00', '+02:00'),
	('ET', 'Africa/Addis_Ababa', '+03:00', '+03:00'),
	('FI', 'Europe/Helsinki', '+02:00', '+03:00'),
	('FJ', 'Pacific/Fiji', '+12:00', '+13:00'),
	('FK', 'Atlantic/Stanley', '−03:00', '−03:00'),
	('FM', 'Pacific/Chuuk', '+10:00', '+10:00'),
	('FM', 'Pacific/Kosrae', '+11:00', '+11:00'),
	('FM', 'Pacific/Pohnpei', '+11:00', '+11:00'),
	('FO', 'Atlantic/Faroe', '+00:00', '+01:00'),
	('FR', 'Europe/Paris', '+01:00', '+02:00'),
	('GA', 'Africa/Libreville', '+01:00', '+01:00'),
	('GB', 'Europe/London', '+00:00', '+01:00'),
	('GD', 'America/Grenada', '−04:00', '−04:00'),
	('GE', 'Asia/Tbilisi', '+04:00', '+04:00'),
	('GF', 'America/Cayenne', '−03:00', '−03:00'),
	('GG', 'Europe/Guernsey', '+00:00', '+01:00'),
	('GH', 'Africa/Accra', '+00:00', '+00:00'),
	('GI', 'Europe/Gibraltar', '+01:00', '+02:00'),
	('GL', 'America/Danmarkshavn', '+00:00', '+00:00'),
	('GL', 'America/Godthab', '−03:00', '−02:00'),
	('GL', 'America/Scoresbysund', '−01:00', '+00:00'),
	('GL', 'America/Thule', '−04:00', '−03:00'),
	('GM', 'Africa/Banjul', '+00:00', '+00:00'),
	('GN', 'Africa/Conakry', '+00:00', '+00:00'),
	('GP', 'America/Guadeloupe', '−04:00', '−04:00'),
	('GQ', 'Africa/Malabo', '+01:00', '+01:00'),
	('GR', 'Europe/Athens', '+02:00', '+03:00'),
	('GS', 'Atlantic/South_Georg', '−02:00', '−02:00'),
	('GT', 'America/Guatemala', '−06:00', '−06:00'),
	('GU', 'Pacific/Guam', '+10:00', '+10:00'),
	('GW', 'Africa/Bissau', '+00:00', '+00:00'),
	('GY', 'America/Guyana', '−04:00', '−04:00'),
	('HK', 'Asia/Hong_Kong', '+08:00', '+08:00'),
	('HN', 'America/Tegucigalpa', '−06:00', '−06:00'),
	('HR', 'Europe/Zagreb', '+01:00', '+02:00'),
	('HT', 'America/Port-au-Prin', '−05:00', '−04:00'),
	('HU', 'Europe/Budapest', '+01:00', '+02:00'),
	('ID', 'Asia/Jakarta', '+07:00', '+07:00'),
	('ID', 'Asia/Jayapura', '+09:00', '+09:00'),
	('ID', 'Asia/Makassar', '+08:00', '+08:00'),
	('ID', 'Asia/Pontianak', '+07:00', '+07:00'),
	('IE', 'Europe/Dublin', '+00:00', '+01:00'),
	('IL', 'Asia/Jerusalem', '+02:00', '+03:00'),
	('IM', 'Europe/Isle_of_Man', '+00:00', '+01:00'),
	('IN', 'Asia/Kolkata', '+05:30', '+05:30'),
	('IO', 'Indian/Chagos', '+06:00', '+06:00'),
	('IQ', 'Asia/Baghdad', '+03:00', '+03:00'),
	('IR', 'Asia/Tehran', '+03:30', '+04:30'),
	('IS', 'Atlantic/Reykjavik', '+00:00', '+00:00'),
	('IT', 'Europe/Rome', '+01:00', '+02:00'),
	('JE', 'Europe/Jersey', '+00:00', '+01:00'),
	('JM', 'America/Jamaica', '−05:00', '−05:00'),
	('JO', 'Asia/Amman', '+02:00', '+03:00'),
	('JP', 'Asia/Tokyo', '+09:00', '+09:00'),
	('KE', 'Africa/Nairobi', '+03:00', '+03:00'),
	('KG', 'Asia/Bishkek', '+06:00', '+06:00'),
	('KH', 'Asia/Phnom_Penh', '+07:00', '+07:00'),
	('KI', 'Pacific/Enderbury', '+13:00', '+13:00'),
	('KI', 'Pacific/Kiritimati', '+14:00', '+14:00'),
	('KI', 'Pacific/Tarawa', '+12:00', '+12:00'),
	('KM', 'Indian/Comoro', '+03:00', '+03:00'),
	('KN', 'America/St_Kitts', '−04:00', '−04:00'),
	('KP', 'Asia/Pyongyang', '+09:00', '+09:00'),
	('KR', 'Asia/Seoul', '+09:00', '+09:00'),
	('KW', 'Asia/Kuwait', '+03:00', '+03:00'),
	('KY', 'America/Cayman', '−05:00', '−05:00'),
	('KZ', 'Asia/Almaty', '+06:00', '+06:00'),
	('KZ', 'Asia/Aqtau', '+05:00', '+05:00'),
	('KZ', 'Asia/Aqtobe', '+05:00', '+05:00'),
	('KZ', 'Asia/Atyrau', '+05:00', '+05:00'),
	('KZ', 'Asia/Oral', '+05:00', '+05:00'),
	('KZ', 'Asia/Qyzylorda', '+05:00', '+05:00'),
	('LA', 'Asia/Vientiane', '+07:00', '+07:00'),
	('LB', 'Asia/Beirut', '+02:00', '+03:00'),
	('LC', 'America/St_Lucia', '−04:00', '−04:00'),
	('LI', 'Europe/Vaduz', '+01:00', '+02:00'),
	('LK', 'Asia/Colombo', '+05:30', '+05:30'),
	('LR', 'Africa/Monrovia', '+00:00', '+00:00'),
	('LS', 'Africa/Maseru', '+02:00', '+02:00'),
	('LT', 'Europe/Vilnius', '+02:00', '+03:00'),
	('LU', 'Europe/Luxembourg', '+01:00', '+02:00'),
	('LV', 'Europe/Riga', '+02:00', '+03:00'),
	('LY', 'Africa/Tripoli', '+02:00', '+02:00'),
	('MA', 'Africa/Casablanca', '+01:00', '+01:00'),
	('MC', 'Europe/Monaco', '+01:00', '+02:00'),
	('MD', 'Europe/Chisinau', '+02:00', '+03:00'),
	('ME', 'Europe/Podgorica', '+01:00', '+02:00'),
	('MF', 'America/Marigot', '−04:00', '−04:00'),
	('MG', 'Indian/Antananarivo', '+03:00', '+03:00'),
	('MH', 'Pacific/Kwajalein', '+12:00', '+12:00'),
	('MH', 'Pacific/Majuro', '+12:00', '+12:00'),
	('MK', 'Europe/Skopje', '+01:00', '+02:00'),
	('ML', 'Africa/Bamako', '+00:00', '+00:00'),
	('MM', 'Asia/Rangoon', '+06:30', '+06:30'),
	('MM', 'Asia/Yangon', '+06:30', '+06:30'),
	('MN', 'Asia/Choibalsan', '+08:00', '+08:00'),
	('MN', 'Asia/Hovd', '+07:00', '+07:00'),
	('MN', 'Asia/Ulaanbaatar', '+08:00', '+08:00'),
	('MO', 'Asia/Macau', '+08:00', '+08:00'),
	('MP', 'Pacific/Saipan', '+10:00', '+10:00'),
	('MQ', 'America/Martinique', '−04:00', '−04:00'),
	('MR', 'Africa/Nouakchott', '+00:00', '+00:00'),
	('MS', 'America/Montserrat', '−04:00', '−04:00'),
	('MT', 'Europe/Malta', '+01:00', '+02:00'),
	('MU', 'Indian/Mauritius', '+04:00', '+04:00'),
	('MV', 'Indian/Maldives', '+05:00', '+05:00'),
	('MW', 'Africa/Blantyre', '+02:00', '+02:00'),
	('MX', 'America/Bahia_Bander', '−06:00', '−05:00'),
	('MX', 'America/Cancun', '−05:00', '−05:00'),
	('MX', 'America/Chihuahua', '−07:00', '−06:00'),
	('MX', 'America/Hermosillo', '−07:00', '−07:00'),
	('MX', 'America/Matamoros', '−06:00', '−05:00'),
	('MX', 'America/Mazatlan', '−07:00', '−06:00'),
	('MX', 'America/Merida', '−06:00', '−05:00'),
	('MX', 'America/Mexico_City', '−06:00', '−05:00'),
	('MX', 'America/Monterrey', '−06:00', '−05:00'),
	('MX', 'America/Ojinaga', '−07:00', '−06:00'),
	('MX', 'America/Tijuana', '−08:00', '−07:00'),
	('MY', 'Asia/Kuala_Lumpur', '+08:00', '+08:00'),
	('MY', 'Asia/Kuching', '+08:00', '+08:00'),
	('MZ', 'Africa/Maputo', '+02:00', '+02:00'),
	('NA', 'Africa/Windhoek', '+02:00', '+02:00'),
	('NC', 'Pacific/Noumea', '+11:00', '+11:00'),
	('NE', 'Africa/Niamey', '+01:00', '+01:00'),
	('NF', 'Pacific/Norfolk', '+11:00', '+11:00'),
	('NG', 'Africa/Lagos', '+01:00', '+01:00'),
	('NI', 'America/Managua', '−06:00', '−06:00'),
	('NL', 'Europe/Amsterdam', '+01:00', '+02:00'),
	('NO', 'Europe/Oslo', '+01:00', '+02:00'),
	('NP', 'Asia/Kathmandu', '+05:45', '+05:45'),
	('NR', 'Pacific/Nauru', '+12:00', '+12:00'),
	('NU', 'Pacific/Niue', '−11:00', '−11:00'),
	('NZ', 'Pacific/Auckland', '+12:00', '+13:00'),
	('NZ', 'Pacific/Chatham', '+12:45', '+13:45'),
	('OM', 'Asia/Muscat', '+04:00', '+04:00'),
	('PA', 'America/Panama', '−05:00', '−05:00'),
	('PE', 'America/Lima', '−05:00', '−05:00'),
	('PF', 'Pacific/Gambier', '−09:00', '−09:00'),
	('PF', 'Pacific/Marquesas', '−09:30', '−09:30'),
	('PF', 'Pacific/Tahiti', '−10:00', '−10:00'),
	('PG', 'Pacific/Bougainville', '+11:00', '+11:00'),
	('PG', 'Pacific/Port_Moresby', '+10:00', '+10:00'),
	('PH', 'Asia/Manila', '+08:00', '+08:00'),
	('PK', 'Asia/Karachi', '+05:00', '+05:00'),
	('PL', 'Europe/Warsaw', '+01:00', '+02:00'),
	('PM', 'America/Miquelon', '−03:00', '−02:00'),
	('PN', 'Pacific/Pitcairn', '−08:00', '−08:00'),
	('PR', 'America/Puerto_Rico', '−04:00', '−04:00'),
	('PS', 'Asia/Gaza', '+02:00', '+03:00'),
	('PS', 'Asia/Hebron', '+02:00', '+03:00'),
	('PT', 'Atlantic/Azores', '−01:00', '+00:00'),
	('PT', 'Atlantic/Madeira', '+00:00', '+01:00'),
	('PT', 'Europe/Lisbon', '+00:00', '+01:00'),
	('PW', 'Pacific/Palau', '+09:00', '+09:00'),
	('PY', 'America/Asuncion', '−04:00', '−03:00'),
	('QA', 'Asia/Qatar', '+03:00', '+03:00'),
	('RE', 'Indian/Reunion', '+04:00', '+04:00'),
	('RO', 'Europe/Bucharest', '+02:00', '+03:00'),
	('RS', 'Europe/Belgrade', '+01:00', '+02:00'),
	('RU', 'Asia/Anadyr', '+12:00', '+12:00'),
	('RU', 'Asia/Barnaul', '+07:00', '+07:00'),
	('RU', 'Asia/Chita', '+09:00', '+09:00'),
	('RU', 'Asia/Irkutsk', '+08:00', '+08:00'),
	('RU', 'Asia/Kamchatka', '+12:00', '+12:00'),
	('RU', 'Asia/Khandyga', '+09:00', '+09:00'),
	('RU', 'Asia/Krasnoyarsk', '+07:00', '+07:00'),
	('RU', 'Asia/Magadan', '+11:00', '+11:00'),
	('RU', 'Asia/Novokuznetsk', '+07:00', '+07:00'),
	('RU', 'Asia/Novosibirsk', '+07:00', '+07:00'),
	('RU', 'Asia/Omsk', '+06:00', '+06:00'),
	('RU', 'Asia/Sakhalin', '+11:00', '+11:00'),
	('RU', 'Asia/Srednekolymsk', '+11:00', '+11:00'),
	('RU', 'Asia/Tomsk', '+07:00', '+07:00'),
	('RU', 'Asia/Ust-Nera', '+10:00', '+10:00'),
	('RU', 'Asia/Vladivostok', '+10:00', '+10:00'),
	('RU', 'Asia/Yakutsk', '+09:00', '+09:00'),
	('RU', 'Asia/Yekaterinburg', '+05:00', '+05:00'),
	('RU', 'Europe/Astrakhan', '+04:00', '+04:00'),
	('RU', 'Europe/Kaliningrad', '+02:00', '+02:00'),
	('RU', 'Europe/Kirov', '+03:00', '+03:00'),
	('RU', 'Europe/Moscow', '+03:00', '+03:00'),
	('RU', 'Europe/Samara', '+04:00', '+04:00'),
	('RU', 'Europe/Saratov', '+04:00', '+04:00'),
	('RU', 'Europe/Ulyanovsk', '+04:00', '+04:00'),
	('RU', 'Europe/Volgograd', '+04:00', '+04:00'),
	('RW', 'Africa/Kigali', '+02:00', '+02:00'),
	('SA', 'Asia/Riyadh', '+03:00', '+03:00'),
	('SB', 'Pacific/Guadalcanal', '+11:00', '+11:00'),
	('SC', 'Indian/Mahe', '+04:00', '+04:00'),
	('SD', 'Africa/Khartoum', '+02:00', '+02:00'),
	('SE', 'Europe/Stockholm', '+01:00', '+02:00'),
	('SG', 'Asia/Singapore', '+08:00', '+08:00'),
	('SH', 'Atlantic/St_Helena', '+00:00', '+00:00'),
	('SI', 'Europe/Ljubljana', '+01:00', '+02:00'),
	('SJ', 'Arctic/Longyearbyen', '+01:00', '+02:00'),
	('SK', 'Europe/Bratislava', '+01:00', '+02:00'),
	('SL', 'Africa/Freetown', '+00:00', '+00:00'),
	('SM', 'Europe/San_Marino', '+01:00', '+02:00'),
	('SN', 'Africa/Dakar', '+00:00', '+00:00'),
	('SO', 'Africa/Mogadishu', '+03:00', '+03:00'),
	('SR', 'America/Paramaribo', '−03:00', '−03:00'),
	('SS', 'Africa/Juba', '+03:00', '+03:00'),
	('ST', 'Africa/Sao_Tome', '+00:00', '+00:00'),
	('SV', 'America/El_Salvador', '−06:00', '−06:00'),
	('SX', 'America/Lower_Prince', '−04:00', '−04:00'),
	('SY', 'Asia/Damascus', '+02:00', '+03:00'),
	('SZ', 'Africa/Mbabane', '+02:00', '+02:00'),
	('TC', 'America/Grand_Turk', '−05:00', '−04:00'),
	('TD', 'Africa/Ndjamena', '+01:00', '+01:00'),
	('TF', 'Indian/Kerguelen', '+05:00', '+05:00'),
	('TG', 'Africa/Lome', '+00:00', '+00:00'),
	('TH', 'Asia/Bangkok', '+07:00', '+07:00'),
	('TJ', 'Asia/Dushanbe', '+05:00', '+05:00'),
	('TK', 'Pacific/Fakaofo', '+13:00', '+13:00'),
	('TL', 'Asia/Dili', '+09:00', '+09:00'),
	('TM', 'Asia/Ashgabat', '+05:00', '+05:00'),
	('TN', 'Africa/Tunis', '+01:00', '+01:00'),
	('TO', 'Pacific/Tongatapu', '+13:00', '+14:00'),
	('TR', 'Europe/Istanbul', '+03:00', '+03:00'),
	('TT', 'America/Port_of_Spai', '−04:00', '−04:00'),
	('TV', 'Pacific/Funafuti', '+12:00', '+12:00'),
	('TW', 'Asia/Taipei', '+08:00', '+08:00'),
	('TZ', 'Africa/Dar_es_Salaam', '+03:00', '+03:00'),
	('UA', 'Europe/Kiev', '+02:00', '+03:00'),
	('UA', 'Europe/Simferopol', '+03:00', '+03:00'),
	('UA', 'Europe/Uzhgorod', '+02:00', '+03:00'),
	('UA', 'Europe/Zaporozhye', '+02:00', '+03:00'),
	('UG', 'Africa/Kampala', '+03:00', '+03:00'),
	('UM', 'Pacific/Midway', '−11:00', '−11:00'),
	('UM', 'Pacific/Wake', '+12:00', '+12:00'),
	('US', 'America/Adak', '−10:00', '−09:00'),
	('US', 'America/Anchorage', '−09:00', '−08:00'),
	('US', 'America/Boise', '−07:00', '−06:00'),
	('US', 'America/Chicago', '−06:00', '−05:00'),
	('US', 'America/Denver', '−07:00', '−06:00'),
	('US', 'America/Detroit', '−05:00', '−04:00'),
	('US', 'America/Indiana/Indi', '−05:00', '−04:00'),
	('US', 'America/Indiana/Knox', '−06:00', '−05:00'),
	('US', 'America/Indiana/Mare', '−05:00', '−04:00'),
	('US', 'America/Indiana/Pete', '−05:00', '−04:00'),
	('US', 'America/Indiana/Tell', '−06:00', '−05:00'),
	('US', 'America/Indiana/Veva', '−05:00', '−04:00'),
	('US', 'America/Indiana/Vinc', '−05:00', '−04:00'),
	('US', 'America/Indiana/Wina', '−05:00', '−04:00'),
	('US', 'America/Juneau', '−09:00', '−08:00'),
	('US', 'America/Kentucky/Lou', '−05:00', '−04:00'),
	('US', 'America/Kentucky/Mon', '−05:00', '−04:00'),
	('US', 'America/Los_Angeles', '−08:00', '−07:00'),
	('US', 'America/Menominee', '−06:00', '−05:00'),
	('US', 'America/Metlakatla', '−09:00', '−08:00'),
	('US', 'America/New_York', '−05:00', '−04:00'),
	('US', 'America/Nome', '−09:00', '−08:00'),
	('US', 'America/North_Dakota', '−06:00', '−05:00'),
	('US', 'America/North_Dakota', '−06:00', '−05:00'),
	('US', 'America/North_Dakota', '−06:00', '−05:00'),
	('US', 'America/Phoenix', '−07:00', '−07:00'),
	('US', 'America/Sitka', '−09:00', '−08:00'),
	('US', 'America/Yakutat', '−09:00', '−08:00'),
	('US', 'Pacific/Honolulu', '−10:00', '−10:00'),
	('UY', 'America/Montevideo', '−03:00', '−03:00'),
	('UZ', 'Asia/Samarkand', '+05:00', '+05:00'),
	('UZ', 'Asia/Tashkent', '+05:00', '+05:00'),
	('VA', 'Europe/Vatican', '+01:00', '+02:00'),
	('VC', 'America/St_Vincent', '−04:00', '−04:00'),
	('VE', 'America/Caracas', '−04:00', '−04:00'),
	('VG', 'America/Tortola', '−04:00', '−04:00'),
	('VI', 'America/St_Thomas', '−04:00', '−04:00'),
	('VN', 'Asia/Ho_Chi_Minh', '+07:00', '+07:00'),
	('VU', 'Pacific/Efate', '+11:00', '+11:00'),
	('WF', 'Pacific/Wallis', '+12:00', '+12:00'),
	('WS', 'Pacific/Apia', '+13:00', '+14:00'),
	('YE', 'Asia/Aden', '+03:00', '+03:00'),
	('YT', 'Indian/Mayotte', '+03:00', '+03:00'),
	('ZA', 'Africa/Johannesburg', '+02:00', '+02:00'),
	('ZM', 'Africa/Lusaka', '+02:00', '+02:00'),
	('ZW', 'Africa/Harare', '+02:00', '+02:00');
";