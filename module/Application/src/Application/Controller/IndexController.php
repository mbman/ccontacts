<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Swagger\Swagger;

class IndexController extends AbstractActionController
{
    /**
     * Redirect homepage to static web app
     */
    public function indexAction()
    {
        $this->redirect()->toUrl('index.htm');
    }

    /**
     * Swagger REST API documentation
     */
    public function docsAction()
    {
        $swagger = $this->getServiceLocator()->get('service.swagger');
        $swagger->flushCache();
        return new JsonModel(json_decode($swagger->getResource('/'.$this->params('path')), true));
    }
}
