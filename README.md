Kohana Assets
=============

An easy to use Kohana Assets manager. 

## Usage

Adding assets can be done either within a controller or a view.

    $assets = assets::instance();
  
    $assets->add('js/jquery.js');
    $assets->add('js/core.js');

Rendering the assets is fairly straight forward.

    $assets = assets::instance();
  
    echo $assets;

JS & CSS can be split up upon rendering. Unless specified, JS & CSS files will be added to the 'head' & 'footer' groups, respectfully.

    echo $assets->render('head');
    
    echo $assets->render('footer');

Configs can now be used to add many assets at once. NOTE: must specify asset type as 'config'

    $assets->add('assets/jquery-ui', 'config');
    
Asset config example for jquery ui

    return array(
            array('path' => 'js//jquery/1.7/jquery.min.js'),
	        array('path' => 'js/jquery-ui-1.8.16.custom.css'),
	        array('path' => 'js/jquery-ui-1.8.16.custom.min.js'),
    );