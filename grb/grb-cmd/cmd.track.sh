#!/bin/sh

#-grb track: Track a remote branch
  GRB_BRANCH=$1
shift 1 || exit 2

$EXEC git branch --track $GRB_BRANCH origin/$GRB_BRANCH
$EXEC git checkout $GRB_BRANCH
