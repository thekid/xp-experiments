<?php
/**
 * $Id: kfe.php,v 1.4 2009/03/15 14:10:20 schlind Exp $
 *
 * Topic
 *
 * @package     org.schlind.php.bottich.plugins
 * @version     $Revision: 1.4 $
 * @author      Sascha Schlindwein <phpbot@schlind.org>
 */
if (self::isInit()) {
	self::log('$Id: kfe.php,v 1.4 2009/03/15 14:10:20 schlind Exp $');
} else if (self::isHeartBeat()) {
} else if (self::isPrivmsg() && self::isOnChannel() && self::isCommand('kfe')) {
	self::sendAction(self::getTargetChannel(), "  .---.");
	self::sendAction(self::getTargetChannel(), "  |---'=.");
	self::sendAction(self::getTargetChannel(), "  |   |='");
	self::sendAction(self::getTargetChannel(), "  `---'");
	self::sendAction(self::getTargetChannel(), "K A F F E E");
}
?>
