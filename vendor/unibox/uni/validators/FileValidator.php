<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\validators;

use Uni;
use uni\web\UploadedFile;
use uni\helpers\FileHelper;

/**
 * FileValidator verifies if an attribute is receiving a valid uploaded file.
 *
 * Note that you should enable `fileinfo` PHP extension.
 *
 * @property integer $sizeLimit The size limit for uploaded files. This property is read-only.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class FileValidator extends Validator
{
    /**
     * @var array|string a list of file name extensions that are allowed to be uploaded.
     * This can be either an array or a string consisting of file extension names
     * separated by space or comma (e.g. "gif, jpg").
     * Extension names are case-insensitive. Defaults to null, meaning all file name
     * extensions are allowed.
     * @see wrongExtension for the customized message for wrong file type.
     */
    public $extensions;
    /**
     * @var boolean whether to check file type (extension) with mime-type. If extension produced by
     * file mime-type check differs from uploaded file extension, the file will be considered as invalid.
     */
    public $checkExtensionByMimeType = true;
    /**
     * @var array|string a list of file MIME types that are allowed to be uploaded.
     * This can be either an array or a string consisting of file MIME types
     * separated by space or comma (e.g. "text/plain, image/png").
     * Mime type names are case-insensitive. Defaults to null, meaning all MIME types
     * are allowed.
     * @see wrongMimeType for the customized message for wrong MIME type.
     */
    public $mimeTypes;
    /**
     * @var integer the minimum number of bytes required for the uploaded file.
     * Defaults to null, meaning no limit.
     * @see tooSmall for the customized message for a file that is too small.
     */
    public $minSize;
    /**
     * @var integer the maximum number of bytes required for the uploaded file.
     * Defaults to null, meaning no limit.
     * Note, the size limit is also affected by `upload_max_filesize` INI setting
     * and the 'MAX_FILE_SIZE' hidden field value.
     * @see http://php.net/manual/en/ini.core.php#ini.upload-max-filesize
     * @see tooBig for the customized message for a file that is too big.
     */
    public $maxSize;
    /**
     * @var integer the maximum file count the given attribute can hold.
     * Defaults to 1, meaning single file upload. By defining a higher number,
     * multiple uploads become possible. Setting it to `0` means there is no limit on
     * the number of files that can be uploaded simultaneously.
     * > Note: The maximum number of files allowed to be uploaded simultaneously is
     * also limited with PHP directive `max_file_uploads`, which defaults to 20.
     * @see http://php.net/manual/en/ini.core.php#ini.max-file-uploads
     * @see tooMany for the customized message when too many files are uploaded.
     */
    public $maxFiles = 1;
    /**
     * @var string the error message used when a file is not uploaded correctly.
     */
    public $message;
    /**
     * @var string the error message used when no file is uploaded.
     * Note that this is the text of the validation error message. To make uploading files required,
     * you have to set [[skipOnEmpty]] to `false`.
     */
    public $uploadRequired;
    /**
     * @var string the error message used when the uploaded file is too large.
     * You may use the following tokens in the message:
     *
     * - {attribute}: the attribute name
     * - {file}: the uploaded file name
     * - {limit}: the maximum size allowed (see [[getSizeLimit()]])
     * - {formattedLimit}: the maximum size formatted
     * with [[\uni\i18n\Formatter::asShortSize()|Formatter::asShortSize()]]
     */
    public $tooBig;
    /**
     * @var string the error message used when the uploaded file is too small.
     * You may use the following tokens in the message:
     *
     * - {attribute}: the attribute name
     * - {file}: the uploaded file name
     * - {limit}: the value of [[minSize]]
     * - {formattedLimit}: the value of [[minSize]] formatted
     * with [[\uni\i18n\Formatter::asShortSize()|Formatter::asShortSize()]
     */
    public $tooSmall;
    /**
     * @var string the error message used if the count of multiple uploads exceeds limit.
     * You may use the following tokens in the message:
     *
     * - {attribute}: the attribute name
     * - {limit}: the value of [[maxFiles]]
     */
    public $tooMany;
    /**
     * @var string the error message used when the uploaded file has an extension name
     * that is not listed in [[extensions]]. You may use the following tokens in the message:
     *
     * - {attribute}: the attribute name
     * - {file}: the uploaded file name
     * - {extensions}: the list of the allowed extensions.
     */
    public $wrongExtension;
    /**
     * @var string the error message used when the file has an mime type
     * that is not listed in [[mimeTypes]].
     * You may use the following tokens in the message:
     *
     * - {attribute}: the attribute name
     * - {file}: the uploaded file name
     * - {mimeTypes}: the value of [[mimeTypes]]
     */
    public $wrongMimeType;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Uni::t('uni', 'File upload failed.');
        }
        if ($this->uploadRequired === null) {
            $this->uploadRequired = Uni::t('uni', 'Please upload a file.');
        }
        if ($this->tooMany === null) {
            $this->tooMany = Uni::t('uni', 'You can upload at most {limit, number} {limit, plural, one{file} other{files}}.');
        }
        if ($this->wrongExtension === null) {
            $this->wrongExtension = Uni::t('uni', 'Only files with these extensions are allowed: {extensions}.');
        }
        if ($this->tooBig === null) {
            $this->tooBig = Uni::t('uni', 'The file "{file}" is too big. Its size cannot exceed {formattedLimit}.');
        }
        if ($this->tooSmall === null) {
            $this->tooSmall = Uni::t('uni', 'The file "{file}" is too small. Its size cannot be smaller than {formattedLimit}.');
        }
        if (!is_array($this->extensions)) {
            $this->extensions = preg_split('/[\s,]+/', strtolower($this->extensions), -1, PREG_SPLIT_NO_EMPTY);
        } else {
            $this->extensions = array_map('strtolower', $this->extensions);
        }
        if ($this->wrongMimeType === null) {
            $this->wrongMimeType = Uni::t('uni', 'Only files with these MIME types are allowed: {mimeTypes}.');
        }
        if (!is_array($this->mimeTypes)) {
            $this->mimeTypes = preg_split('/[\s,]+/', strtolower($this->mimeTypes), -1, PREG_SPLIT_NO_EMPTY);
        } else {
            $this->mimeTypes = array_map('strtolower', $this->mimeTypes);
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if ($this->maxFiles != 1) {
            $files = $model->$attribute;
            if (!is_array($files)) {
                $this->addError($model, $attribute, $this->uploadRequired);

                return;
            }
            foreach ($files as $i => $file) {
                if (!$file instanceof UploadedFile || $file->error == UPLOAD_ERR_NO_FILE) {
                    unset($files[$i]);
                }
            }
            $model->$attribute = array_values($files);
            if (empty($files)) {
                $this->addError($model, $attribute, $this->uploadRequired);
            }
            if ($this->maxFiles && count($files) > $this->maxFiles) {
                $this->addError($model, $attribute, $this->tooMany, ['limit' => $this->maxFiles]);
            } else {
                foreach ($files as $file) {
                    $result = $this->validateValue($file);
                    if (!empty($result)) {
                        $this->addError($model, $attribute, $result[0], $result[1]);
                    }
                }
            }
        } else {
            $result = $this->validateValue($model->$attribute);
            if (!empty($result)) {
                $this->addError($model, $attribute, $result[0], $result[1]);
            }
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($file)
    {
        if (!$file instanceof UploadedFile || $file->error == UPLOAD_ERR_NO_FILE) {
            return [$this->uploadRequired, []];
        }

        switch ($file->error) {
            case UPLOAD_ERR_OK:
                if ($this->maxSize !== null && $file->size > $this->getSizeLimit()) {
                    return [
                        $this->tooBig,
                        [
                            'file' => $file->name,
                            'limit' => $this->getSizeLimit(),
                            'formattedLimit' => Uni::$app->formatter->asShortSize($this->getSizeLimit())
                        ]
                    ];
                } elseif ($this->minSize !== null && $file->size < $this->minSize) {
                    return [
                        $this->tooSmall,
                        [
                            'file' => $file->name,
                            'limit' => $this->minSize,
                            'formattedLimit' => Uni::$app->formatter->asShortSize($this->minSize)
                        ]
                    ];
                } elseif (!empty($this->extensions) && !$this->validateExtension($file)) {
                    return [$this->wrongExtension, ['file' => $file->name, 'extensions' => implode(', ', $this->extensions)]];
                } elseif (!empty($this->mimeTypes) &&  !in_array(FileHelper::getMimeType($file->tempName), $this->mimeTypes, false)) {
                    return [$this->wrongMimeType, ['file' => $file->name, 'mimeTypes' => implode(', ', $this->mimeTypes)]];
                } else {
                    return null;
                }
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return [$this->tooBig, ['file' => $file->name, 'limit' => $this->getSizeLimit()]];
            case UPLOAD_ERR_PARTIAL:
                Uni::warning('File was only partially uploaded: ' . $file->name, __METHOD__);
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                Uni::warning('Missing the temporary folder to store the uploaded file: ' . $file->name, __METHOD__);
                break;
            case UPLOAD_ERR_CANT_WRITE:
                Uni::warning('Failed to write the uploaded file to disk: ' . $file->name, __METHOD__);
                break;
            case UPLOAD_ERR_EXTENSION:
                Uni::warning('File upload was stopped by some PHP extension: ' . $file->name, __METHOD__);
                break;
            default:
                break;
        }

        return [$this->message, []];
    }

    /**
     * Returns the maximum size allowed for uploaded files.
     * This is determined based on four factors:
     *
     * - 'upload_max_filesize' in php.ini
     * - 'post_max_size' in php.ini
     * - 'MAX_FILE_SIZE' hidden field
     * - [[maxSize]]
     *
     * @return integer the size limit for uploaded files.
     */
    public function getSizeLimit()
    {
        // Get the lowest between post_max_size and upload_max_filesize, log a warning if the first is < than the latter
        $limit = $this->sizeToBytes(ini_get('upload_max_filesize'));
        $postLimit = $this->sizeToBytes(ini_get('post_max_size'));
        if ($postLimit > 0 && $postLimit < $limit) {
            Uni::warning('PHP.ini\'s \'post_max_size\' is less than \'upload_max_filesize\'.', __METHOD__);
            $limit = $postLimit;
        }
        if ($this->maxSize !== null && $limit > 0 && $this->maxSize < $limit) {
            $limit = $this->maxSize;
        }
        if (isset($_POST['MAX_FILE_SIZE']) && $_POST['MAX_FILE_SIZE'] > 0 && $_POST['MAX_FILE_SIZE'] < $limit) {
            $limit = (int) $_POST['MAX_FILE_SIZE'];
        }

        return $limit;
    }

    /**
     * @inheritdoc
     */
    public function isEmpty($value, $trim = false)
    {
        $value = is_array($value) ? reset($value) : $value;
        return !($value instanceof UploadedFile) || $value->error == UPLOAD_ERR_NO_FILE;
    }

    /**
     * Converts php.ini style size to bytes
     *
     * @param string $sizeStr $sizeStr
     * @return int
     */
    private function sizeToBytes($sizeStr)
    {
        switch (substr($sizeStr, -1)) {
            case 'M':
            case 'm':
                return (int) $sizeStr * 1048576;
            case 'K':
            case 'k':
                return (int) $sizeStr * 1024;
            case 'G':
            case 'g':
                return (int) $sizeStr * 1073741824;
            default:
                return (int) $sizeStr;
        }
    }

    /**
     * Checks if given uploaded file have correct type (extension) according current validator settings.
     * @param UploadedFile $file
     * @return boolean
     */
    protected function validateExtension($file)
    {
        $extension = mb_strtolower($file->extension, 'UTF-8');

        if ($this->checkExtensionByMimeType) {

            $mimeType = FileHelper::getMimeType($file->tempName, null, false);
            if ($mimeType === null) {
                return false;
            }

            $extensionsByMimeType = FileHelper::getExtensionsByMimeType($mimeType);

            if (!in_array($extension, $extensionsByMimeType, true)) {
                return false;
            }
        }

        if (!in_array($extension, $this->extensions, true)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        ValidationAsset::register($view);
        $options = $this->getClientOptions($model, $attribute);
        return 'uni.validation.file(attribute, messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }

    /**
     * Returns the client side validation options.
     * @param \uni\base\Model $model the model being validated
     * @param string $attribute the attribute name being validated
     * @return array the client side validation options
     */
    protected function getClientOptions($model, $attribute)
    {
        $label = $model->getAttributeLabel($attribute);

        $options = [];
        if ($this->message !== null) {
            $options['message'] = Uni::$app->getI18n()->format($this->message, [
                'attribute' => $label,
            ], Uni::$app->language);
        }

        $options['skipOnEmpty'] = $this->skipOnEmpty;

        if (!$this->skipOnEmpty) {
            $options['uploadRequired'] = Uni::$app->getI18n()->format($this->uploadRequired, [
                'attribute' => $label,
            ], Uni::$app->language);
        }

        if ($this->mimeTypes !== null) {
            $options['mimeTypes'] = $this->mimeTypes;
            $options['wrongMimeType'] = Uni::$app->getI18n()->format($this->wrongMimeType, [
                'attribute' => $label,
                'mimeTypes' => implode(', ', $this->mimeTypes),
            ], Uni::$app->language);
        }

        if ($this->extensions !== null) {
            $options['extensions'] = $this->extensions;
            $options['wrongExtension'] = Uni::$app->getI18n()->format($this->wrongExtension, [
                'attribute' => $label,
                'extensions' => implode(', ', $this->extensions),
            ], Uni::$app->language);
        }

        if ($this->minSize !== null) {
            $options['minSize'] = $this->minSize;
            $options['tooSmall'] = Uni::$app->getI18n()->format($this->tooSmall, [
                'attribute' => $label,
                'limit' => $this->minSize,
                'formattedLimit' => Uni::$app->formatter->asShortSize($this->minSize),
            ], Uni::$app->language);
        }

        if ($this->maxSize !== null) {
            $options['maxSize'] = $this->maxSize;
            $options['tooBig'] = Uni::$app->getI18n()->format($this->tooBig, [
                'attribute' => $label,
                'limit' => $this->getSizeLimit(),
                'formattedLimit' => Uni::$app->formatter->asShortSize($this->getSizeLimit()),
            ], Uni::$app->language);
        }

        if ($this->maxFiles !== null) {
            $options['maxFiles'] = $this->maxFiles;
            $options['tooMany'] = Uni::$app->getI18n()->format($this->tooMany, [
                'attribute' => $label,
                'limit' => $this->maxFiles,
            ], Uni::$app->language);
        }

        return $options;
    }
}
