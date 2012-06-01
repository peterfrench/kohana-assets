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