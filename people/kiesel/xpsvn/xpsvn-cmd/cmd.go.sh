#!/bin/sh
#
# $Id$
#

echo "---> Starting temporary shell, use 'exit' to return where you came from..."
cd "$(tmpTagDir)"/current-tag && $SHELL
