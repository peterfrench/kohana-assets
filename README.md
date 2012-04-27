Kohana Assets
=============

An easy to use Kohana asset manager. 

## Usage

Adding assets can be done either within a controller or a view.

    $assets = assets::instance();
  
    $assets->add('js/jquery.js');
    $assets->add('js/core.js');

Rendering the assets is fairly straight forward.

    $assets = assets::instance();
  
    echo $assets;

JS & CSS can be split up upon rendering.

    echo $assets->render('css');
    
    echo $assets->render('js');