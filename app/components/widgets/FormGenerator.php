<?php
/**
 * Created by PhpStorm.
 * User: Rashidov Nuriddin
 * I'm a developer not copy paster
 * Date: 06.10.2015
 * Time: 8:16
 */

namespace app\components\widgets;


use uni\helpers\Inflector;
use uni\helpers\VarDumper;

class FormGenerator
{
    public $fields = [];
    public $modelClass;
    public $layout;
    public $src = false;
    public $layouttype;

    public function getSrc()
    {
        if ($this->src && is_string($this->src)) {
            return "form/" . $this->src . "_form";
        } else {
            return "form/" . strtolower((new \ReflectionClass($this->modelClass))->getShortName()) . "_form";
        }
    }

    public function generate()
    {
        $path = \Uni::$app->controller->getViewPath() ."/".$this->getSrc().".php";

        if (file_exists($path)) {
            return $this->getSrc();
        }
        $this->fields["dropdown"] = [];
        $this->fields["inputtext"] = [];
        $this->fields["filedocs"] = [];
        $this->fields["fileimage"] = [];
        $this->fields["date"] = [];
        $this->fields["others"] = [];
        $this->fields["text"] = [];
        if (is_object($this->modelClass)) {
            $class = $this->modelClass->className();
        } else $class = $this->modelClass;
        if (is_subclass_of($class, 'app\components\Model')) {

            $table = $this->getTableSchema();
            foreach ($table->columns as $column) {
                if (!in_array($column->name, $this->modelClass->notgen)) {
                    $this->renderField($column);
                }
            }
            $form = $this->renderForm();
            return $form;

        } else {
            echo "Not valid";
        }

    }

    public function __construct($model = null, $layouttype = "horizontal", $layout = false)
    {
        $this->modelClass = $model;
        $this->layouttype = $layouttype;
        $this->layout = $layout;

    }

    public function setModel($model)
    {
        $this->modelClass = $model;
    }

    public function setLayoutType($type)
    {
        $this->layouttype = $type;
    }

    public function renderField($column)
    {
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false || !isset($tableSchema->columns[$column->name])) {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                $this->fields["inputtext"][$column->name] = "\$form->field(\$model, '$column->name')->passwordInput()";
            } else {
                $this->fields["inputtext"][$column->name] = "\$form->field(\$model, '$column->name')";
            }
        }

        if ($this->strpos_array($column->name, ['date', 'time', 'birth', 'dob', 'birthday']) !== false) {
            $this->fields["date"][$column->name] = "\$form->field(\$model, '$column->name')->widget(\\kartik\\date\\DatePicker::classname(), [
                            'options' => ['placeholder' => 'Enter  date ...'],'pluginOptions' => ['autoclose'=>true,'format' => 'dd.mm.yyyy']]);";
        } elseif (array_search($column->name, $tableSchema->primaryKey) !== false) {
            $this->fields["dropdown"][$column->name] = "\$form->field(\$model, '$column->name')->hiddenInput()->label(false)";
        } elseif (($drop = $this->modelClass->getDropDownProp($column->name)) !== false) {
            $this->fields["dropdown"][$column->name] = "\$form->field(\$model, '$column->name')->widget(kartik\\widgets\\Select2::classname(),['language' => 'ru','value'=>\$model->getSelectVal('" . $column->name . "'),'data' => " . $drop['arr'] . ",'options' => ['multiple' => " . $drop['multiple'] . ",'placeholder' => 'Select  ...'],'pluginOptions' => ['allowClear' => true ],]);";
        } elseif ($this->strpos_array($column->name, ['img', 'image', 'picture', 'photo']) !== false) {
            $this->fields["fileimage"][$column->name] = "\$form->field(\$model, '$column->name')->widget(\\kartik\\file\\FileInput::classname(), ['options' => ['accept' => 'image/*'],]);";
        } elseif ($this->strpos_array($column->name, ['file', 'upload', 'files']) !== false) {
            $this->fields["filedocs"][$column->name] = "\$form->field(\$model, '$column->name')->widget(\\kartik\\file\\FileInput::classname(), ['options' => ['accept' => 'application/*'],'pluginOptions'=>['allowedFileExtensions'=>['pdf','doc','docx']],]);";
        } elseif ($this->strpos_array($column->name, ['mail', 'email', 'pochta']) !== false) {
            $this->fields["inputtext"][$column->name] = "\$form->field(\$model, '$column->name')->input('email');";
        } elseif ($this->strpos_array($column->name, ['_id', 'number', 'uid']) !== false) {
            $this->fields["others"][$column->name] = "\$form->field(\$model, '$column->name')->input('number')";
        } elseif ($column->phpType === 'boolean') {
            $this->fields["others"][$column->name] = "\$form->field(\$model, '$column->name')->checkbox()";
        } elseif ($column->type === 'text' || $this->strpos_array($column->name, ['description',]) !== false) {
            $this->fields["text"][$column->name] = "\$form->field(\$model, '$column->name')->textarea(['rows' => 5])";
        } else {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                $input = 'passwordInput';
            } else {
                $input = 'textInput';
            }
            $this->fields["inputtext"][$column->name] = "\$form->field(\$model, '$column->name')->$input(['maxlength' => $column->size])";
        }
    }

    public function renderForm()
    {
        $r = $l = "";
        $lf = array_merge($this->fields["inputtext"], $this->fields["text"], $this->fields["others"]);
        $rf = array_merge($this->fields["date"], $this->fields["dropdown"], $this->fields["fileimage"], $this->fields["filedocs"]);
        $left = count($lf);
        $right = count($rf);
        $path = \Uni::$app->controller->getViewPath() . "/" . $this->getSrc() . ".php";
        $enc = "";
        $content = "<?php\r\n/**\r\n* Created by Edoc.uz. \r\n* User: Rashidov Nuriddin\r\n* I'm a developer not copy paster\r\n* Date: " . date("d.m.Y") . "\r\n* Time: " . date("H:i") . "\r\n*/\r\n?>";
        if ($this->modelClass->upload_file) $enc = "'enctype' => 'multipart/form-data',";

        $content .= "<?php \$form = \\uni\\ui\\Form::begin(['id' => 'form_id','options' => ['class' => 'form-" . $this->layouttype . "'," . $enc . "],'fieldConfig' => [
        'template' => '<div class=\"row\">{label}<div class=\"col-sm-10\">{input}</div><div class=\"col-sm-10\">{error}</div></div>',
        'labelOptions' => ['class' => 'col-sm-2 control-label'],
    ],]);?>\r\n";
        if ($this->layouttype == "horizontal") {
            if ($left > $right) {
                $i = 1;
                $add = ceil(($left - $right) / 2);
                foreach ($lf as $key => $val) {
                    if ($i == count($rf) + $add) break;
                    $l .= "<?=" . $val . "?>\r\n";
                    $i++;
                    unset($lf[$key]);
                }
                foreach ($lf as $key => $val) {
                    $r .= "<?=" . $val . "?>\r\n";
                    unset($lf[$key]);
                }
                foreach ($rf as $key => $val) {
                    $r .= "<?=" . $val . "?>\r\n";
                    unset($rf[$key]);
                }


            } elseif ($right === $left) {
                foreach ($lf as $key => $val) {
                    $l .= "<?=" . $val . "?>\r\n";
                }
                foreach ($rf as $key => $val) {
                    $r .= "<?=" . $val . "?>\r\n";
                    unset($rf[$key]);
                }
            } elseif ($right > $left) {
                $i = 1;
                $add = ceil(($right - $left) / 2);
                foreach ($rf as $key => $val) {
                    if ($i == count($rf) + $add) break;
                    $r .= "<?=" . $val . "?>\r\n";
                    $i++;
                    unset($rf[$key]);
                }
                foreach ($rf as $key => $val) {
                    $r .= "<?=" . $val . "?>\r\n";
                    unset($rf[$key]);
                }
                foreach ($lf as $key => $val) {
                    $l .= "<?=" . $val . "?>\r\n";
                    unset($lf[$key]);
                }
            }
            $content .= "<div class='col-md-6' style='padding: 25px 65px 25px 25px;border-right:2px solid #ccc;'>" . $l . "</div>\r\n<div class='col-md-6'  style='padding:25px;'>" . $r . "</div>";
        } elseif ($this->layouttype == "vertical") {
            $fr = array_merge($lf, $rf);
            $ver = "";
            foreach ($fr as $f => $v) {
                $ver .= "<?=" . $v . "?>\r\n";
            }
            $content .= "<div class='col-sm-12'>" . $ver . "</div>";
        };

        $content .= "<div class='col-md-12'><input class=\"btn btn-blue col-md-6 col-md-offset-3\" type=\"submit\" name=\"" . strtolower((new \ReflectionClass($this->modelClass))->getShortName()) . "\" value=\"Добавить\"></div>";
        $content .= "<?\\uni\\ui\\Form::end() ?>";
        file_put_contents($path, $content);
        return $this->getSrc();
    }

    public function getTableSchema()
    {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        if (is_subclass_of($class, 'uni\db\ActiveRecord')) {
            return $class::getTableSchema();
        } else {
            return false;
        }
    }

    public function getColumnFormat($column)
    {
        if ($column->phpType === 'boolean') {
            return 'boolean';
        } elseif ($column->type === 'text') {
            return 'ntext';
        } elseif (stripos($column->name, 'time') !== false && $column->phpType === 'integer') {
            return 'datetime';
        } elseif (stripos($column->name, 'email') !== false) {
            return 'email';
        } elseif (stripos($column->name, 'url') !== false) {
            return 'url';
        } else {
            return 'text';
        }
    }

    public function strpos_array($haystack, $needles)
    {
        $pos = false;
        if (is_array($needles)) {
            foreach ($needles as $str) {
                if (is_array($str)) {
                    $pos = $this->strpos_array($haystack, $str);
                } else {
                    $pos = strpos($haystack, $str);
                }
                if ($pos !== FALSE) {
                    return true;
                } else $pos = false;
            }
        } else {
            return strpos($haystack, $needles);
        }
        return $pos;
    }
}