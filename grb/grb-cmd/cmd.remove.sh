#!/bin/sh

#-grb remove: Remove a branch
  GRB_BRANCH=$1
shift 1 || exit 2

$EXEC git push origin :refs/heads/$GRB_BRANCH
$EXEC git checkout master
$EXEC git branch -d $GRB_BRANCH
