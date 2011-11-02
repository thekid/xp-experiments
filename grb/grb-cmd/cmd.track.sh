#!/bin/sh

#-grb track: Track a remote branch
  BRANCH=$1
shift 1 || exit 2

$EXEC git branch --track $BRANCH origin/$BRANCH
$EXEC git checkout $BRANCH
