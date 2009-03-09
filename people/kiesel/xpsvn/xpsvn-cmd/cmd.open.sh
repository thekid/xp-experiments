#!/bin/sh
#
# $Id$
#

TAGDIR=$(tmpTagDir)
TAG=$1

[ -z $TAG ] && exit 1

if [ ! -d "$TAGDIR" ]; then
  mkdir -p "$TAGDIR";
fi

if [ -d "$TAGDIR"/current-tag ]; then
  echo "Cannot open tag $TAG, as you still have a tag checked out. Aborting."
  exit 1;
fi

svn co $(repositoryRoot)/tags/$1 "$TAGDIR"/current-tag
