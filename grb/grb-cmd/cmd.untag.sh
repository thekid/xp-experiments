#!/bin/sh

#-grb untag: Remove a tag
  GRB_TAG=$1
shift 1 || exit 2

$EXEC git tag -d $GRB_TAG
$EXEC git push origin :refs/tags/$GRB_TAG