<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'io.File',
    'img.Image',
    'img.shapes.Line',
    'img.io.PngStreamWriter',
    'img.fonts.TrueTypeFont'
  );

  /**
   * Creates "Web 2.0"-style reflecting text
   * 
   */
  class ReflectingText extends Command {
    protected $text;
    protected $font;
    protected $size;
    protected $color;
    protected $background;
    protected $hover;
    protected $percent;
    protected $output;
    
    /**
     * Sets text to be rendered
     *
     * @param   string text
     */
    #[@arg(position= 0)]
    public function setText($text) {
      $this->text= $text;
    }

    /**
     * Sets font to be used
     *
     * @param   string font
     */
    #[@arg]
    public function setFont($font) {
      $this->font= $font;
    }

    /**
     * Sets text size to be used (default: 30)
     *
     * @param   string size
     */
    #[@arg]
    public function setSize($size= 30) {
      $this->size= (int)$size;
    }

    /**
     * Sets text color to be used (default: #ffffff)
     *
     * @param   string color
     */
    #[@arg]
    public function setColor($color= '#ffffff') {
      $this->color= new Color($color);
    }

    /**
     * Sets background color to be used (default: #990000)
     *
     * @param   string color
     */
    #[@arg]
    public function setBackground($color= '#990000') {
      $this->background= new Color($color);
    }

    /**
     * Sets text hover to be used (default: 0)
     *
     * @param   string hover
     */
    #[@arg]
    public function setHover($hover= 0) {
      $this->hover= (int)$hover;
    }

    /**
     * Sets how strong reflection should be (default: 60)
     *
     * @param   string percent
     */
    #[@arg]
    public function setPercent($percent= 60) {
      $this->percent= (int)$percent;
    }

    /**
     * Sets output file to be used (default: out.png)
     *
     * @param   string file
     */
    #[@arg]
    public function setOutput($file= 'out.png') {
      $this->output= new File($file);
    }

    /**
     * Main runner method
     *
     */
    public function run() {

      // First, calculate boundaries
      // Note: There should probably be a TrueTypeFont::calculateDimensions()
      // method or something - we'll need an RFC for this:)
      $font= new TrueTypeFont($this->font, $this->size, 0);
      $boundaries= imagettfbbox($font->size, $font->angle, $font->name, $this->text);
      $padding= 10;
      $width= abs($boundaries[4] - $boundaries[0]);
      $height= abs($boundaries[5] - $boundaries[1]) + $this->hover;

      // Create an image
      $img= Image::create($width+ $padding * 2, $height * 2 + $padding * 2, IMG_TRUECOLOR);
      $img->fill($img->allocate($this->background), 0, 0);

      // Draw text onto it
      $baseline= $padding + $font->size;
      $font->drawtext(
        $img->handle, 
        $img->allocate($this->color), 
        $this->text, 
        $padding, 
        $baseline
      );

      // Flip text
      for (
        $i= 0, $transparent= 0, $step= (40 + $this->percent) / $font->size; 
        $i <= $font->size; 
        $i++
      ) {
        $y= $baseline + $font->size + $this->hover +- $i+ 1;
        $img->copyFrom(
          $img, 
          $padding,                      // dst_x
          $y,                            // dst_y
          $padding,                      // src_x
          $padding + $i,                 // src_y
          $width,                        // src_w
          1                              // src_h
        );

        // Overlay fading
        $img->draw(new Line($img->allocate($this->background, floor($transparent)), $padding, $y, $padding+ $width, $y));
        $transparent= min($transparent+ $step, 127);
      }

      // Save
      $img->saveTo(new PngStreamWriter($this->output));
      $this->out->writeLine('Results written to ', $this->output->getURI());
    }
  }
?>
