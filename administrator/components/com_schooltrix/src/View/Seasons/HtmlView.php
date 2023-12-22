<?php

namespace Joomla\Component\SchoolTrix\Administrator\View\Seasons;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

/**
 * @package     SchoolTrix
 * @subpackage  com_schooltrix
 *
 * @copyright   (C) 2023-2028 Joomrocks.com
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\schoolTrix\Administrator\View\Seasons;

use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;
use Joomla\CMS\Toolbar\Button\DropdownButton;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\Component\Seasons\Administrator\Model\SeasonsModel;
use Joomla\Registry\Registry;

/**
 * Main "SchoolTrix" Admin View
 */
class HtmlView extends BaseHtmlView {
    
    /**
     * Display the main "SchoolTrix" view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     * @return  void
     */
    function display($tpl = null)
    {
        $model               = $this->getModel();
        $this->items         = $model->getItems();
        $this->state         = $model->getState();

        $this->addToolbar();

        parent::display($tpl);
    }

     /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function addToolbar(): void
    {
        $canDo   = ContentHelper::getActions('com_schooltrix', 'season', $this->state->get('filter.category_id'));
        $user    = Factory::getApplication()->getIdentity();
        $toolbar = Toolbar::getInstance();

        ToolbarHelper::title(Text::_('SCHOOLTRIX_MANAGER_SEASONS'), 'bookmark banners');

        $toolbar->addNew('season.add');

        
    }

}