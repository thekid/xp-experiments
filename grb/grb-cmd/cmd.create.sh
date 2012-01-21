#!/bin/sh

#-grb create: Create a branch
  GRB_BRANCH=$1
  GRB_BASE=${2-master}
shift 1 || exit 2

$EXEC git push origin $GRB_BASE:refs/heads/$GRB_BRANCH
$EXEC git fetch origin
$EXEC git branch --track $GRB_BRANCH origin/$GRB_BRANCH
$EXEC git checkout $GRB_BRANCH
