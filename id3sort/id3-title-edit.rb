require "mp3info"

if ARGV.size < 2
  printf "Usage: %s <format> [file [file1 [...]]]\n", __FILE__
  puts "* %t     - Title"
  puts "* %a     - Artist"
  puts "* %y     - Year"
  puts "* %A     - Album"
  puts "* %T     - Track"
  puts "* %f     - Filename without extension"
  puts "* %XXXX  - Tag with name 'XXXX'"
  exit 1
end

format = ARGV.shift

ARGV.each do |file|
  Mp3Info.open(file) do |mp3info|
    puts "== " + file + " ==" 
    puts mp3info

    # Now modify
    title = format.
      gsub("%t", mp3info.tag.title || "").
      gsub("%a", mp3info.tag.artist || "").
      gsub("%A", mp3info.tag.album || "").
      gsub("%f", File.basename(file).gsub(/\.[a-zA-Z0-9]+$/, "")).
      gsub("%y", mp3info.tag.year.nil? ? "" : mp3info.tag.year.to_s).
      gsub("%T", mp3info.tag.tracknum.nil? ? "" : mp3info.tag.tracknum.to_s).
      gsub(/%[A-Z0-9]{4}/) { |tag| mp3info.tag[tag] }

    puts "==> '" + title + "'"
    mp3info.tag.title = title
    mp3info.close
    puts
  end
end
