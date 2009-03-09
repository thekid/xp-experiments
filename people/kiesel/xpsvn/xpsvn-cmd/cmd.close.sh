#!/bin/sh
#
# $Id$
#

TAGDIR=$(tmpTagDir)
assertHaveActiveTag

rm -rvf "$TAGDIR/current-tag"
