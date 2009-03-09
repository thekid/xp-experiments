#!/bin/sh
#
# $Id$
#


# Parse command line options
OPTS=""
while getopts 'v' COMMAND_LINE_ARGUMENT ; do
  case "$COMMAND_LINE_ARGUMENT" in
    v)  OPTS="$OPTS -v"  ;;
    ?)  exit
  esac
done
shift $(($OPTIND - 1))

assertHaveActiveTag

cd $(tmpTagDir)/current-tag

echo -n "Status on: "
svn info . | grep ^URL: | cut -d ' ' -f 2
svn status $OPTS
