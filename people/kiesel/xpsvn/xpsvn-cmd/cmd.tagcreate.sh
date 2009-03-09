#!/bin/sh
#
# $Id$
#

TAG=$1

svn ls $(repositoryRoot)/tags/$TAG 2&>1 >/dev/null
if [ $? -eq 0 ]; then
  echo "Tag does already exist. Aborting.";
  exit 1;
fi

# Now create...
echo "===> Creating directory structure for tag $TAG ..."
svn mkdir "$(repositoryRoot)"/tags/$TAG
