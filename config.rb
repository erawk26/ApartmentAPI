css_dir         = "css"
sass_dir        = "scss"
images_dir      = "img"
relative_assets = true
# Uncomment this when the site goes live
#output_style = :compressed

require 'autoprefixer-rails'

on_stylesheet_saved do |file|
	css = File.read(file)
	map = file + '.map'

	if File.exists? map
		result = AutoprefixerRails.process(css,
																			 from: file,
																			 to:   file,
																			 map:  { prev: File.read(map), inline: false })
		File.open(file, 'w') { |io| io << result.css }
		File.open(map,  'w') { |io| io << result.map }
	else
		File.open(file, 'w') { |io| io << AutoprefixerRails.process(css) }
	end
end