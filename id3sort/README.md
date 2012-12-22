MP3 Title Editor
================
This small utility changes the ID3 information based on existing ID3 
information. This tool makes use of the "ruby-mp3info" library available
at https://github.com/moumar/ruby-mp3info

Example
-------
The following prefixes the title with the artist:

```sh
$ ruby -Ilib id3-title-edit.rb "%a - %t" *.mp3
```

A file with artist "Mc Hammer" and title "Can't touch this" would now
have a new title called "Mc Hammer - Can't touch this".