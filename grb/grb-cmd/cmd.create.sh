#!/bin/sh

#-grb create: Create a branch
  BRANCH=$1
shift 1 || exit 2

$EXEC git push origin master:refs/heads/$BRANCH
$EXEC git fetch origin
$EXEC git branch --track $BRANCH origin/$BRANCH
$EXEC git checkout $BRANCH
