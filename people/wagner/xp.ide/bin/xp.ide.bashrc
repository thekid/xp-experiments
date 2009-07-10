##
# Set the XP_IDE_XAR environment variable to
# the path of the ide classes
##
if [ -z ${XP_IDE_CP} ]; then
	XP_IDE_CPs=( $(echo ${HOME}/xp/lib/xp-ide-*.xar | sort) )
	declare -x XP_IDE_CP=${XP_IDE_CPs[ ${#XP_IDE_XARs[*]} - 1]}
fi

##
# bash completion for nx and gx
# 
##
_xp.ide.completion.bash()
{
	local opts;
	opts=$(xpide xp.ide.autocompletion.Runner xp.ide.autocompletion.Bash ${COMP_WORDS[COMP_CWORD]})
	COMPREPLY=( ${opts} );
}
complete -o nospace -o default -F _xp.ide.completion.bash nx gx
