#!/bin/sh
#
# $Id$
#

assertHaveActiveTag

cd $(tmpTagDir)/current-tag
svn update
