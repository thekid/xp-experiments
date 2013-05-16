#!/bin/sh

#-grb help: Context-sensitive help on a certain command
  GRB_COMMAND=$1
shift 1 || exit 2

EXEC=echo
COMMAND="$DIRNAME"/cmd.${GRB_COMMAND}.sh 
if [ -f "$COMMAND" ]; then
  grep '^#-grb' "$COMMAND" | sed -e 's/#-grb/* grb/g'
  grep '^  GRB' "$COMMAND" | sed -e 's/GRB_//g' | sed -e 's/\-/ || /g'
  echo 
  . "$COMMAND" "$@"
else
  "No such command: $GRB_COMMAND"
fi

exit 3
