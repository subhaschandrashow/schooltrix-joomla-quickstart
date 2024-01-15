<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Schooltrix\Site\View\Student;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * HTML Article View class for the Content component
 *
 * @since  1.5
 */
class HtmlView extends BaseHtmlView
{
    /**
     * The Form object
     *
     * @var  \Joomla\CMS\Form\Form
     */
    protected $form;

    /**
     * The item being created
     *
     * @var  \stdClass
     */
    protected $item;

    /**
     * The page to return to after the article is submitted
     *
     * @var  string
     */
    protected $return_page = '';

    /**
     * The model state
     *
     * @var  \Joomla\CMS\Object\CMSObject
     */
    protected $state;

    /**
     * The page parameters
     *
     * @var    \Joomla\Registry\Registry|null
     *
     * @since  4.0.0
     */
    protected $params = null;

    /**
     * The page class suffix
     *
     * @var    string
     *
     * @since  4.0.0
     */
    protected $pageclass_sfx = '';

    /**
     * The user object
     *
     * @var \Joomla\CMS\User\User
     *
     * @since  4.0.0
     */
    protected $user = null;

    /**
     * Should we show a captcha form for the submission of the article?
     *
     * @var    boolean
     *
     * @since  3.7.0
     */
    protected $captchaEnabled = false;

    /**
     * Should we show Save As Copy button?
     *
     * @var    boolean
     * @since  4.1.0
     */
    protected $showSaveAsCopy = false;

    /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void|boolean
     */
    public function display($tpl = null)
    {
        $app  = Factory::getApplication();
        $user = $app->getIdentity();

        // Get model data.
        $this->state       = $this->get('State');
        $this->item        = $this->get('Item');
        $this->form        = $this->get('Form');
        $this->return_page = $this->get('ReturnPage');

        

        parent::display($tpl);
    }

    /**
     * Prepares the document
     *
     * @return  void
     */
    protected function _prepareDocument()
    {
        $app   = Factory::getApplication();

        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $app->getMenu()->getActive();

        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', Text::_('COM_CONTENT_FORM_EDIT_ARTICLE'));
        }

        $title = $this->params->def('page_title', Text::_('COM_CONTENT_FORM_EDIT_ARTICLE'));

        $this->setDocumentTitle($title);

        $app->getPathway()->addItem($title);

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetaData('robots', $this->params->get('robots'));
        }
    }
}
