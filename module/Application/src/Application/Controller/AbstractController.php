<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AbstractController extends AbstractActionController
{
    function attemptedFileUpload()
    {
        return (bool)$_FILES['file']['name'];
    }

    function fileUploadHasError()
    {
        return (bool)$_FILES['file']['error'];
    }

    function flashFileUploadErrorMessage()
    {
        $this->flashMessenger()
            ->setNamespace('error')
            ->addMessage($this->uploadErrorCodeToMessage($_FILES['file']['error']));
    }

    function uploadErrorCodeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }

    /** @return \Application\ShoppingCartAdapter */
    function shoppingCartEnvironment()
    {
        return $this->getServiceLocator()->get('shopping_cart_adapter');
    }

    function finder()
    {
        $finder = new \VF_Vehicle_Finder($this->schema());
        return $finder;
    }

    function schema()
    {
        $schema = new \VF_Schema;
        return $schema;
    }

    /** @return \VF_TestDbAdapter */
    function db()
    {
        return $this->getServiceLocator()->get('database');
    }
}