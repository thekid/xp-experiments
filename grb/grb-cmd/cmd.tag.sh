#!/bin/sh

#-grb tag: Create a tag
  GRB_TAG=$1
shift 1 || exit 2

$EXEC git tag -a $GRB_TAG -m "- Release $GRB_TAG"
$EXEC git push origin $GRB_TAG