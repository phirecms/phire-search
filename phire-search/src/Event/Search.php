<?php

namespace Phire\Saerch\Event;

use Pop\Application;
use Phire\Controller\AbstractController;

class Search
{

    /**
     * Set the search template
     *
     * @param  AbstractController $controller
     * @param  Application        $application
     * @return void
     */
    public static function setTemplate(AbstractController $controller, Application $application)
    {
        if ($application->isRegistered('phire-templates') && ($controller instanceof \Phire\Search\Controller\IndexController) &&
            ($controller->hasView()) && $controller->view()->isStream()) {
            $template = \Phire\Templates\Table\Templates::findBy(['name' => 'Search']);
            if (isset($template->id)) {
                if (isset($template->id)) {
                    $device = \Phire\Templates\Event\Template::getDevice($controller->request()->getQuery('mobile'));
                    if ((null !== $device) && ($template->device != $device)) {
                        $childTemplate = \Phire\Templates\Table\Templates::findBy(['parent_id' => $template->id, 'device' => $device]);
                        if (isset($childTemplate->id)) {
                            $tmpl = $childTemplate->template;
                        } else {
                            $tmpl = $template->template;
                        }
                    } else {
                        $tmpl = $template->template;
                    }
                    $controller->view()->setTemplate(\Phire\Templates\Event\Template::parse($tmpl));
                }
            }
        } else if ($application->isRegistered('phire-themes') && ($controller instanceof \Phire\Search\Controller\IndexController) &&
            ($controller->hasView()) && $controller->view()->isFile()) {
            $theme = \Phire\Themes\Table\Themes::findBy(['active' => 1]);
            if (isset($theme->id)) {
                $themePath = $_SERVER['DOCUMENT_ROOT'] . BASE_PATH . CONTENT_PATH . '/themes/' . $theme->folder . '/';
                if (file_exists($themePath . 'search.phtml') || file_exists($themePath . 'search.php')) {
                    $template = file_exists($themePath . 'search.phtml') ? 'search.phtml' : 'search.php';
                    $device = \Phire\Themes\Event\Theme::getDevice($controller->request()->getQuery('mobile'));
                    if ((null !== $device) && (file_exists($themePath . $device . '/' . $template))) {
                        $template = $device . '/' . $template;
                    }
                    $controller->view()->setTemplate($themePath . $template);
                }
            }
        }
    }

}
