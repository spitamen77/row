<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\console\controllers;

use Uni;
use uni\base\Application;
use uni\console\Controller;
use uni\console\Exception;
use uni\helpers\Console;
use uni\helpers\Inflector;

/**
 * Provides help information about console commands.
 *
 * This command displays the available command list in
 * the application or the detailed instructions about using
 * a specific command.
 *
 * This command can be used as follows on command line:
 *
 * ```
 * uni help [command name]
 * ```
 *
 * In the above, if the command name is not provided, all
 * available commands will be displayed.
 *
 * @property array $commands All available command names. This property is read-only.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class HelpController extends Controller
{
    /**
     * Displays available commands or the detailed information
     * about a particular command.
     *
     * @param string $command The name of the command to show help about.
     * If not provided, all available commands will be displayed.
     * @return integer the exit status
     * @throws Exception if the command for help is unknown
     */
    public function actionIndex($command = null)
    {
        if ($command !== null) {
            $result = Uni::$app->createController($command);
            if ($result === false) {
                $name = $this->ansiFormat($command, Console::FG_YELLOW);
                throw new Exception("No help for unknown command \"$name\".");
            }

            list($controller, $actionID) = $result;

            $actions = $this->getActions($controller);
            if ($actionID !== '' || count($actions) === 1 && $actions[0] === $controller->defaultAction) {
                $this->getSubCommandHelp($controller, $actionID);
            } else {
                $this->getCommandHelp($controller);
            }
        } else {
            $this->getDefaultHelp();
        }
    }

    /**
     * Returns all available command names.
     * @return array all available command names
     */
    public function getCommands()
    {
        $commands = $this->getModuleCommands(Uni::$app);
        sort($commands);
        return array_unique($commands);
    }

    /**
     * Returns an array of commands an their descriptions.
     * @return array all available commands as keys and their description as values.
     */
    protected function getCommandDescriptions()
    {
        $descriptions = [];
        foreach ($this->getCommands() as $command) {
            $description = '';

            $result = Uni::$app->createController($command);
            if ($result !== false) {
                list($controller, $actionID) = $result;
                /** @var Controller $controller */
                $description = $controller->getHelpSummary();
            }

            $descriptions[$command] = $description;
        }

        return $descriptions;
    }

    /**
     * Returns all available actions of the specified controller.
     * @param Controller $controller the controller instance
     * @return array all available action IDs.
     */
    public function getActions($controller)
    {
        $actions = array_keys($controller->actions());
        $class = new \ReflectionClass($controller);
        foreach ($class->getMethods() as $method) {
            $name = $method->getName();
            if ($name !== 'actions' && $method->isPublic() && !$method->isStatic() && strpos($name, 'action') === 0) {
                $actions[] = Inflector::camel2id(substr($name, 6), '-', true);
            }
        }
        sort($actions);

        return array_unique($actions);
    }

    /**
     * Returns available commands of a specified module.
     * @param \uni\base\Module $module the module instance
     * @return array the available command names
     */
    protected function getModuleCommands($module)
    {
        $prefix = $module instanceof Application ? '' : $module->getUniqueID() . '/';

        $commands = [];
        foreach (array_keys($module->controllerMap) as $id) {
            $commands[] = $prefix . $id;
        }

        foreach ($module->getModules() as $id => $child) {
            if (($child = $module->getModule($id)) === null) {
                continue;
            }
            foreach ($this->getModuleCommands($child) as $command) {
                $commands[] = $command;
            }
        }

        $controllerPath = $module->getControllerPath();
        if (is_dir($controllerPath)) {
            $files = scandir($controllerPath);
            foreach ($files as $file) {
                if (!empty($file) && substr_compare($file, 'Controller.php', -14, 14) === 0) {
                    $controllerClass = $module->controllerNamespace . '\\' . substr(basename($file), 0, -4);
                    if ($this->validateControllerClass($controllerClass)) {
                        $commands[] = $prefix . Inflector::camel2id(substr(basename($file), 0, -14));
                    }
                }
            }
        }

        return $commands;
    }

    /**
     * Validates if the given class is a valid console controller class.
     * @param string $controllerClass
     * @return bool
     */
    protected function validateControllerClass($controllerClass)
    {
        if (class_exists($controllerClass)) {
            $class = new \ReflectionClass($controllerClass);
            return !$class->isAbstract() && $class->isSubclassOf('uni\console\Controller');
        } else {
            return false;
        }
    }

    /**
     * Displays all available commands.
     */
    protected function getDefaultHelp()
    {
        $commands = $this->getCommandDescriptions();
        $this->stdout("\nThis is Uni version " . \Uni::getVersion() . ".\n");
        if (!empty($commands)) {
            $this->stdout("\nThe following commands are available:\n\n", Console::BOLD);
            $len = 0;
            foreach ($commands as $command => $description) {
                $result = Uni::$app->createController($command);
                if ($result !== false) {
                    /** @var $controller Controller */
                    list($controller, $actionID) = $result;
                    $actions = $this->getActions($controller);
                    if (!empty($actions)) {
                        $prefix = $controller->getUniqueId();
                        foreach ($actions as $action) {
                            $string = $prefix . '/' . $action;
                            if ($action === $controller->defaultAction) {
                                $string .= ' (default)';
                            }
                            if (($l = strlen($string)) > $len) {
                                $len = $l;
                            }
                        }
                    }
                } elseif (($l = strlen($command)) > $len) {
                    $len = $l;
                }
            }
            foreach ($commands as $command => $description) {
                $this->stdout('- ' . $this->ansiFormat($command, Console::FG_YELLOW));
                $this->stdout(str_repeat(' ', $len + 4 - strlen($command)));
                $this->stdout(Console::wrapText($description, $len + 4 + 2), Console::BOLD);
                $this->stdout("\n");

                $result = Uni::$app->createController($command);
                if ($result !== false) {
                    list($controller, $actionID) = $result;
                    $actions = $this->getActions($controller);
                    if (!empty($actions)) {
                        $prefix = $controller->getUniqueId();
                        foreach ($actions as $action) {
                            $string = '  ' . $prefix . '/' . $action;
                            $this->stdout('  ' . $this->ansiFormat($string, Console::FG_GREEN));
                            if ($action === $controller->defaultAction) {
                                $string .= ' (default)';
                                $this->stdout(' (default)', Console::FG_YELLOW);
                            }
                            $summary = $controller->getActionHelpSummary($controller->createAction($action));
                            if ($summary !== '') {
                                $this->stdout(str_repeat(' ', $len + 4 - strlen($string)));
                                $this->stdout(Console::wrapText($summary, $len + 4 + 2));
                            }
                            $this->stdout("\n");
                        }
                    }
                    $this->stdout("\n");
                }
            }
            $scriptName = $this->getScriptName();
            $this->stdout("\nTo see the help of each command, enter:\n", Console::BOLD);
            $this->stdout("\n  $scriptName " . $this->ansiFormat('help', Console::FG_YELLOW) . ' '
                            . $this->ansiFormat('<command-name>', Console::FG_CYAN) . "\n\n");
        } else {
            $this->stdout("\nNo commands are found.\n\n", Console::BOLD);
        }
    }

    /**
     * Displays the overall information of the command.
     * @param Controller $controller the controller instance
     */
    protected function getCommandHelp($controller)
    {
        $controller->color = $this->color;

        $this->stdout("\nDESCRIPTION\n", Console::BOLD);
        $comment = $controller->getHelp();
        if ($comment !== '') {
            $this->stdout("\n$comment\n\n");
        }

        $actions = $this->getActions($controller);
        if (!empty($actions)) {
            $this->stdout("\nSUB-COMMANDS\n\n", Console::BOLD);
            $prefix = $controller->getUniqueId();

            $maxlen = 5;
            foreach ($actions as $action) {
                $len = strlen($prefix.'/'.$action) + 2 + ($action === $controller->defaultAction ? 10 : 0);
                if ($maxlen < $len) {
                    $maxlen = $len;
                }
            }
            foreach ($actions as $action) {
                $this->stdout('- ' . $this->ansiFormat($prefix.'/'.$action, Console::FG_YELLOW));
                $len = strlen($prefix.'/'.$action) + 2;
                if ($action === $controller->defaultAction) {
                    $this->stdout(' (default)', Console::FG_GREEN);
                    $len += 10;
                }
                $summary = $controller->getActionHelpSummary($controller->createAction($action));
                if ($summary !== '') {
                    $this->stdout(str_repeat(' ', $maxlen - $len + 2) . Console::wrapText($summary, $maxlen + 2));
                }
                $this->stdout("\n");
            }
            $scriptName = $this->getScriptName();
            $this->stdout("\nTo see the detailed information about individual sub-commands, enter:\n");
            $this->stdout("\n  $scriptName " . $this->ansiFormat('help', Console::FG_YELLOW) . ' '
                            . $this->ansiFormat('<sub-command>', Console::FG_CYAN) . "\n\n");
        }
    }

    /**
     * Displays the detailed information of a command action.
     * @param Controller $controller the controller instance
     * @param string $actionID action ID
     * @throws Exception if the action does not exist
     */
    protected function getSubCommandHelp($controller, $actionID)
    {
        $action = $controller->createAction($actionID);
        if ($action === null) {
            $name = $this->ansiFormat(rtrim($controller->getUniqueId() . '/' . $actionID, '/'), Console::FG_YELLOW);
            throw new Exception("No help for unknown sub-command \"$name\".");
        }

        $description = $controller->getActionHelp($action);
        if ($description !== '') {
            $this->stdout("\nDESCRIPTION\n", Console::BOLD);
            $this->stdout("\n$description\n\n");
        }

        $this->stdout("\nUSAGE\n\n", Console::BOLD);
        $scriptName = $this->getScriptName();
        if ($action->id === $controller->defaultAction) {
            $this->stdout($scriptName . ' ' . $this->ansiFormat($controller->getUniqueId(), Console::FG_YELLOW));
        } else {
            $this->stdout($scriptName . ' ' . $this->ansiFormat($action->getUniqueId(), Console::FG_YELLOW));
        }

        $args = $controller->getActionArgsHelp($action);
        foreach ($args as $name => $arg) {
            if ($arg['required']) {
                $this->stdout(' <' . $name . '>', Console::FG_CYAN);
            } else {
                $this->stdout(' [' . $name . ']', Console::FG_CYAN);
            }
        }

        $options = $controller->getActionOptionsHelp($action);
        $options[\uni\console\Application::OPTION_APPCONFIG] = [
            'type' => 'string',
            'default' => null,
            'comment' => "custom application configuration file path.\nIf not set, default application configuration is used.",
        ];
        ksort($options);

        if (!empty($options)) {
            $this->stdout(' [...options...]', Console::FG_RED);
        }
        $this->stdout("\n\n");

        if (!empty($args)) {
            foreach ($args as $name => $arg) {
                $this->stdout($this->formatOptionHelp(
                        '- ' . $this->ansiFormat($name, Console::FG_CYAN),
                        $arg['required'],
                        $arg['type'],
                        $arg['default'],
                        $arg['comment']) . "\n\n");
            }
        }

        if (!empty($options)) {
            $this->stdout("\nOPTIONS\n\n", Console::BOLD);
            foreach ($options as $name => $option) {
                $this->stdout($this->formatOptionHelp(
                        $this->ansiFormat('--' . $name, Console::FG_RED, empty($option['required']) ? Console::FG_RED : Console::BOLD),
                        !empty($option['required']),
                        $option['type'],
                        $option['default'],
                        $option['comment']) . "\n\n");
            }
        }
    }

    /**
     * Generates a well-formed string for an argument or option.
     * @param string $name the name of the argument or option
     * @param boolean $required whether the argument is required
     * @param string $type the type of the option or argument
     * @param mixed $defaultValue the default value of the option or argument
     * @param string $comment comment about the option or argument
     * @return string the formatted string for the argument or option
     */
    protected function formatOptionHelp($name, $required, $type, $defaultValue, $comment)
    {
        $comment = trim($comment);
        $type = trim($type);
        if (strncmp($type, 'bool', 4) === 0) {
            $type = 'boolean, 0 or 1';
        }

        if ($defaultValue !== null && !is_array($defaultValue)) {
            if ($type === null) {
                $type = gettype($defaultValue);
            }
            if (is_bool($defaultValue)) {
                // show as integer to avoid confusion
                $defaultValue = (int) $defaultValue;
            }
            if (is_string($defaultValue)) {
                $defaultValue = "'" . $defaultValue . "'";
            } else {
                $defaultValue = var_export($defaultValue, true);
            }
            $doc = "$type (defaults to " . $defaultValue . ')';
        } else {
            $doc = $type;
        }

        if ($doc === '') {
            $doc = $comment;
        } elseif ($comment !== '') {
            $doc .= "\n" . preg_replace('/^/m', '  ', $comment);
        }

        $name = $required ? "$name (required)" : $name;

        return $doc === '' ? $name : "$name: $doc";
    }

    /**
     * @return string the name of the cli script currently running.
     */
    protected function getScriptName()
    {
        return basename(Uni::$app->request->scriptFile);
    }
}
