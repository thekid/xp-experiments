#!/bin/sh
#
# $Id$
#

assertHaveActiveTag

cd "$(tmpTagDir)"/current-tag
echo -n "===> Current status in " ; pwd
svn status

echo
read -p "Do you really want to merge this (y/n)? " desc

if [ "$desc" = "y" ]; then
  svn ci -m '- MFT'
fi
