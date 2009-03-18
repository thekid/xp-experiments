<?php
/**
 * This file is part of moepbot.
 * @version $Id: url.php,v 1.5 2009/03/15 16:08:29 schlind Exp $
 * @package net.moep.irc.moepbot
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 * @copyright See LICENSE file
 */
// the bot replies randomly or if someone talks to the bot in a channel
if (self::isInit()) {

} else if (self::isOnChannel() && self::isPrivmsg()) {

	$targetChannel = self::getTargetChannel();
	$sourceNick = self::getSourceNick();

	$urlFile = self::getConfigValue('url.db.file');
	#self::log("url.db.file=$urlFile");
	$enabled = 1|| self::getConfigValue("url.enable.$targetChannel");
	#self::log("url.enable.$targetChannel=$enabled");
	$aaaalt = self::getConfigValue("url.aaaalt.$targetChannel");
	#self::log("url.aaaalt.$targetChannel=$aaaalt");

	if (!$enabled) return;

	if (self::isCommand('lasturls')) {

		$amount = self::getMessage();
		if (empty($amount) || !is_numeric($amount)) { $amount = 3; }
		if (8<$amount) { $amount=8; }

		$linkDB =& MoepUtil::getArray($urlFile);

		$linksOnChannel = isset($linkDB)
		? $linkDB : null;

		if (is_array($linksOnChannel)) {
			$linksOnChannel = array_reverse($linksOnChannel);
			$i = 0;
			foreach ($linksOnChannel as $url => $meta) {
				if ($amount <= $i++) break;
				$date = date('d.m.Y H:i', $meta['time']);
				#$title = $meta['title'];
				#print_r($meta);
				#$title = MoepUtil::bold(MoepUtil::colour($title, 0, 2));
				$url = MoepUtil::colour($url, 7,0);
				self::sendMessage($targetChannel, "[$date] $url");
			}
		}

	} else if (self::isCommand('url')) {

		$search = self::getMessage();

		$linkDB =& MoepUtil::getArray($urlFile);

		$linksOnChannel = isset($linkDB) ? $linkDB : null;

		if (empty($search)) {
			// random url
			$rand = array_rand($linksOnChannel);

			$date = date('d.m.Y H:i', $linksOnChannel[$rand]['time']);
			#$title = $linksOnChannel[$rand]['title'];
			#$title = MoepUtil::bold(MoepUtil::colour($title, 0, 2));
			$rand = MoepUtil::colour($rand, 7,0);
			#print_r($linksOnChannel[$rand]);
			self::sendAction($targetChannel, "[$date] $rand");
		} else {
			// search url/s
			self::log("searching urls for $search...");
			$searchResults = array();
			$linkDB = array_reverse($linkDB);
			$count = 0;
			foreach ($linkDB as $url => $meta) {
				#self::log("stristr($url, $search)");
				#self::log("stristr($url, {$meta['title']})");
				if (stristr($url, $search)
				|| (isset($meta['title'])
				&& stristr($meta['title'], $search))) {
					// found title
					$searchResults[$url] = $meta;
					$count++;
				}
				if (5<$count) break;
			}
			foreach ($searchResults as $url => $meta) {
				$date = date('d.m.Y H:i', $meta['time']);
				#$title = $meta['title'];
				#$title = MoepUtil::bold(MoepUtil::colour($title, 0, 2));
				$url = MoepUtil::colour($url, 7,0);
				self::sendAction($targetChannel, "[$date] $url");
			}
		}
	} else if (preg_match_all(
    '@(https?://([-\w\.]+)+(:)?(/([\w/_\%\:\~\-\.\,]*(\?\S+)?)?)?)@i', 
	self::getMessage(), $matches)) {

		$urls = array_shift($matches);
		if (is_array($urls)) {

			self::log('Fetching '.count($urls).' url/s!');

			//			$linkDB =& MoepUtil::getArray($urlFile);
			//
			//			$pattern ='@(://([-\w\.]+)+(/)?)@i';
			//			foreach ($urls as $url) {
			//				preg_match($pattern, $url, $match);
			//				array_shift($match);
			//				array_shift($match);
			//				$host = array_shift($match);
			//				self::log("host=$host,\n url=$url");
			//
			//				if (isset($linkDB[$url])) {
			//					#$title = ($linkDB[$url]['title']);
			//					$nick  = ($linkDB[$url]['nick']);
			//					$time  = ($linkDB[$url]['time']);
			//					$chan  = ($linkDB[$url]['channel']);
			//					$date  = date('\a\m d.m.Y \u\m H:i \U\h\r',$time);
			//
			//					if($aaaalt)
			//					#self::sendMessage($targetChannel,
			//					#"der link '$url' ist *aaaalt*.. $nick kam damit schon $date an..");
			//					self::sendAction($targetChannel, ".oO(aaalt?)");
			//				} else {
			//
			//					//                    $remote = fopen($url);
			//					//                    if (is_resource($remote)) {
			//					//                        $file = fread($remote, 1024);
			//					//                        $f2 = $file;
			//					//                        #if (is_array($file)) foreach($file as $line) $f2 .= $line;
			//					//                        preg_match_all('/\<title\>(.*)\<\/title\>/i', $f2, $title);
			//					//                        if (isset($title[1][0])) {
			//					//                            $title = preg_replace('/\&\#(.*);/','-',$title[1][0]);
			//					//                        } else {
			//					//                            $title = '-/-';
			//					//                        }
			//					//                        $title = htmlspecialchars_decode($title);
			//					//                        self::log("url-html-title=$title");
			//					//                    }
			//
			//					$linkDB[$url] = array(
			//                    'nick'=> $sourceNick, 'channel'=> $targetChannel,
			//					#'title'=> $title,
			//                    'time'=> time());
			//				}
			//		}
		}
	}
}
?>
