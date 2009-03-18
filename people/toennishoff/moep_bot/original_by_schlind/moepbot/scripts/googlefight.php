<?php
// $Id: googlefight.php,v 1.4 2009/03/15 16:08:29 schlind Exp $
/**
 * GoogleFight!
 *
 * @package     org.schlind.php.bottich.plugins
 * @version     $Revision: 1.4 $
 * @author      Sascha Schlindwein <phpbot@schlind.org>
 */
if (self::isInit()) {
	// init-phase
	self::log('[googlefight] $Id: googlefight.php,v 1.4 2009/03/15 16:08:29 schlind Exp $');
}

else if (self::isChannelCommand('fight')) {

	// command fight
	$googleUrl = 'http://www.google.de/search?hl=de&btnG=Google-Suche&q=';
	$parameters = explode('-', self::getMessage());
	$resultmsg  = '';

	if (!empty($parameters[0]) && !empty($parameters[1])) {

		$word1 = trim($parameters[0]);
		$word2 = trim($parameters[1]);
		$urlword1 = urlencode($word1);
		$urlword2 = urlencode($word2);
		self::log("[googlefight] Starting fight $word1 vs $word2");

		if ($word1 == $word2) {
			$resultmsg = "unentschieden";
		} else {

			self::log("[googlefight] Fetching word 1 $word1");
			$file = file("$googleUrl$urlword1");
			$gfanswer = '';
			foreach ($file as $line) { $gfanswer .= $line; }

			$filter = "/\<b\>(.*)\<\/b\>/isU";
			$hits = array();
			preg_match_all($filter, $gfanswer, &$hits, PREG_PATTERN_ORDER);
			#var_dump($hits);
			$hits = array_shift($hits);
			$hits = $hits[3];
			$x1 = str_replace(array('<b>', '</b>'), '', $hits);
			self::log("[googlefight] x1=$x1");


			self::log("[googlefight] Fetching word 2 $word2");
			$file = file("$googleUrl$urlword2");
			$gfanswer = '';
			foreach ($file as $line) { $gfanswer .= $line; }

			$filter = "/\<b\>(.*)\<\/b\>/isU";
			$hits = array();
			preg_match_all($filter, $gfanswer, &$hits, PREG_PATTERN_ORDER);
			$hits = array_shift($hits);
			$hits = $hits[3];
			$x2 = str_replace(array('<b>', '</b>'), '', $hits);

			$v1 = str_replace('.','',$x1);
			$v2 = str_replace('.','',$x2);
			$sum = $v1 + $v2;

			if (0 != $sum) {
				$p1= round(100 * $v1 / $sum, 3);
				$p2= round(100 * $v2 / $sum, 3);
			} else {
				$p1= -0;
				$p2= -0;
			}

			$i1 = intval(str_replace('.','',$x1));
			$i2 = intval(str_replace('.','',$x2));

			if (!is_numeric($i1) || !is_numeric($i2)) {
				$resultmsg = "google hat schonwieder die seite geaendert, alles kaputt :-(";
			} else {
				$s1 = str_replace(' ','.',trim($gfanswer[0]));
				$s2 = str_replace(' ','.',trim($gfanswer[1]));
				if (($i1 == $i2)) {
					$resultmsg = "unentschieden";
				} else {
					if ($i1 < $i2) {
						$resultmsg = $word2." gewinnt mit $p2% gegen $word1 ($x2 > $x1)";
					}
					else {
						$resultmsg = $word1." gewinnt mit $p1% gegen $word2 ($x1 > $x2)";
					}
				}
				self::log("[googlefight] OK '$resultmsg'");
			}
				
				
		}
	}	 else {
		$resultmsg .= 'Beispiel: '.('!fight').' word1 - word2';
	}

	self::sendMessage(self::getTargetChannel(), $resultmsg);

	unset($word1, $word2, $urlword1, $urlword2, $file, $filter,
	$gfanswer, $hits, $resultmsg,
	$v1, $v2, $i1, $i2, $x1, $x2, $s1, $s2, $sum, $parameters);

}
?>
