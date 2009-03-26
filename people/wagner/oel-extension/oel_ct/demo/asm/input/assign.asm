line 1 'assign.php'
pushval 'Hello'
beginvar
pushvar $a
assign
free

line 2 'assign.php'
beginvar
pushvar $a
endvar
echo
