##
# Set the XP_IDE_XAR environment variable to
# the path of the ide classes
##
if [ -z ${XP_IDE_CP} ]; then
	XP_IDE_CPs=( $(echo ${HOME}/xp/lib/xp-ide-*.xar | sort) )
    XP_IDE_IDX=${#XP_IDE_XARs[*]}
    
	declare -x XP_IDE_CP=${XP_IDE_CPs[(( ${XP_IDE_IDX--} ))]}
fi

##
# bash completion for nx and gx
# 
##
_xp.ide.completion.bash()
{
	local opts;
	opts=$(echo -n  ${COMP_WORDS[COMP_CWORD]} | xpide xp.ide.completion.Runner xp.ide.completion.Bash)
	COMPREPLY=( ${opts} );
}
complete -o nospace -o default -F _xp.ide.completion.bash nx gx
