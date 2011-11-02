#!/bin/sh

#-grb help: Context-sensitive help on a certain command
  COMMAND=$1
shift 1 || exit 2

EXEC=echo
if [ -f "$DIRNAME"/cmd.${COMMAND}.sh ]; then
  grep -A 1 '^#-grb' "$DIRNAME"/cmd.${COMMAND}.sh | sed -e 's/#-grb/* grb/g'
  echo 
  . "$DIRNAME"/cmd.${COMMAND}.sh "$@"
else
  "No such command: $COMMAND"
fi

exit 3
