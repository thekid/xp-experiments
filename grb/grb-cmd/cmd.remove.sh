#!/bin/sh

#-grb remove: Remove a branch
  BRANCH=$1
shift 1 || exit 2

$EXEC git push origin :refs/heads/$BRANCH
$EXEC git checkout master
$EXEC git branch -d $BRANCH
