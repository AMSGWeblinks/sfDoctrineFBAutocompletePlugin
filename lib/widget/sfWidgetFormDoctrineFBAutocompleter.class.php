<?php

/**
 * sfWidgetFormDoctrineFBAutocompleter represents an autocompleter input widget rendered by JQuery.
 *
 * This widget needs JQuery to work.
 *
 * You also need to include the JavaScripts and stylesheets files returned by the getJavaScripts()
 * and getStylesheets() methods.
 *
 * If you use symfony 1.2, it can be done automatically for you.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Gregory SCHURGAST <fgreg@negko.com>
 */
class sfWidgetFormDoctrineFBAutocompleter extends sfWidgetFormDoctrineChoice
{
  /**
   * Configures the current widget.
   *
   * Available options:
   *
   *  * url:            The URL to call to get the choices to use (required)
   *  * config:         A JavaScript array that configures the JQuery autocompleter widget
   *  * value_callback: A callback that converts the value before it is displayed
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('json_url', '/sfDoctrineFBAutocompleteJson/list/model/%model%');
    $this->addOption('cache', false);
    $this->addOption('height', false);
    $this->addOption('newel', false);
    $this->addOption('firstselected', false);
    $this->addOption('filter_case', false);
    $this->addOption('filter_hide', false);
    $this->addOption('filter_selected', false);
    $this->addOption('complete_text', false);
    $this->addOption('maxshownitems', false);
    $this->addOption('maxitems', false);
    $this->addOption('onselect', false);
    $this->addOption('onremove', false);
    $this->addOption('delay ', false);
    $this->addOption('template', <<<EOF
    %associated%
    <script type="text/javascript">
      
      jQuery(document).ready(function() {
        
        jQuery("#%id% option").attr('selected','selected');
        jQuery("#%id%").fcbkcomplete({
            %json_url%
            %cache%
            %newel%
            %firstselected%
            %filter_case%
            %filter_hide%
            %filter_selected%
            %complete_text%
            %maxshownitems%
            %maxitems%
            %onselect%
            %onremove%
            %delay%
        })
      });
    </script>
EOF
);

    parent::configure($options, $attributes);
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The date displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if (is_null($value)){$value = array();}

    $choices = $this->getChoices();
    
    $associated = array();
    
    foreach ($choices as $key => $option)
    {
      if (in_array(strval($key), $value))
      {
        $associated[$key] = $option;
      }
    }
        
    $url = str_replace('%model%',$this->getOption('model') , $this->getOption('json_url'));
    $json_url           = 'json_url : "' . $url  .'",';
    $cache              = $this->getOption('cache') ? 'cache : true,' : '' ;
    $newel              = $this->getOption('newel') ? 'newel : true,' : '' ;
    $firstselected      = $this->getOption('firstselected') ? 'firstselected : "'.$this->getOption('firstselected').'",' : '' ;
    $filter_case        = $this->getOption('filter_case') ? 'filter_case : true,' : '' ;
    $filter_hide        = $this->getOption('filter_hide') ? 'filter_hide : true,' : '' ;
    $filter_selected    = $this->getOption('filter_selected') ? 'filter_selected : true,' : '' ;
    $complete_text      = $this->getOption('complete_text') ? 'complete_text : "'.$this->getOption('complete_text').'",' : '' ;
    $maxshownitems      = $this->getOption('maxshownitems') ? 'maxshownitems : "'.$this->getOption('maxshownitems').'",' : '' ;
    $maxitems           = $this->getOption('maxitems') ? 'maxitems : "'.$this->getOption('maxitems').'",' : '' ;
    $onselect           = $this->getOption('onselect') ? 'onselect : "'.$this->getOption('onselect').'",' : '' ;
    $onremove           = $this->getOption('onremove') ? 'onremove : "'.$this->getOption('onremove').'",' : '' ;
    $delay              = $this->getOption('delay') ? 'delay : "'.$this->getOption('delay').'",' : '' ;

   
    $associatedWidget = new sfWidgetFormSelect(array('multiple' => true, 'choices' => $associated ));
    
    return strtr($this->getOption('template'), array(
      '%id%'                => $this->generateId($name),
      '%json_url%'          => $json_url,
      '%cache%'             => $cache,
      '%newel%'             => $newel,
      '%firstselected%'     => $firstselected,
      '%filter_case%'       => $filter_case,
      '%filter_hide%'       => $filter_hide,
      '%filter_selected%'   => $filter_selected,
      '%complete_text%'     => $complete_text,
      '%maxshownitems%'     => $maxshownitems,
      '%maxitems%'          => $maxitems,
      '%onselect%'          => $onselect,
      '%onremove%'          => $onremove,
      '%delay%'             => $delay,
      '%associated%'        => $associatedWidget->render($name)
    ));

    
  }

  /**
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    return array('/sfDoctrineFBAutocompletePlugin/css/style.css' => 'all');
  }

  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavascripts()
  {
    return array('/sfDoctrineFBAutocompletePlugin/js/jquery.fcbkcomplete.min.js');
  }
}
