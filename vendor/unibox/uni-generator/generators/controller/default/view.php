<?php
/**
 * This is the template for generating an action view file.
 *
 * @var uni\web\View $this
 * @var uni\generator\generators\controller\Generator $generator
 * @var string $action the action ID
 */

echo "<?php\n";
?>
/**
 * @var uni\web\View $this
 */
<?= "?>" ?>

<h1><?= $generator->getControllerID() . '/' . $action ?></h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= '<?=' ?> __FILE__; ?></code>.
</p>
