<?php
/**
 * This is the template for generating a controller class within a module.
 *
 * @var uni\web\View $this
 * @var uni\generator\generators\module\Generator $generator
 */
echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

use uni\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
