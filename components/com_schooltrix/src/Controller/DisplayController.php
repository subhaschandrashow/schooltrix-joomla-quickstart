<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Schooltrix\Site\Controller;

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Content Component Controller
 *
 * @since  1.5
 */
class DisplayController extends \Joomla\CMS\MVC\Controller\BaseController
{
    /**
     * @param   array                         $config   An optional associative array of configuration settings.
     *                                                  Recognized key values include 'name', 'default_task', 'model_path', and
     *                                                  'view_path' (this list is not meant to be comprehensive).
     * @param   MVCFactoryInterface|null      $factory  The factory.
     * @param   CMSApplication|null           $app      The Application for the dispatcher
     * @param   \Joomla\CMS\Input\Input|null  $input    The Input object for the request
     *
     * @since   3.0.1
     */
    public function __construct($config = [], MVCFactoryInterface $factory = null, $app = null, $input = null)
    {
        $this->input = Factory::getApplication()->getInput();
      

        parent::__construct($config, $factory, $app, $input);
    }

    /**
     * Method to display a view.
     *
     * @param   boolean  $cachable   If true, the view output will be cached.
     * @param   boolean  $urlparams  An array of safe URL parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return  DisplayController  This object to support chaining.
     *
     * @since   1.5
     */
    public function display($cachable = false, $urlparams = false)
    {
        $cachable = true;

        

        $safeurlparams = [
            'catid'            => 'INT',
            'id'               => 'INT',
            'cid'              => 'ARRAY',
            'year'             => 'INT',
            'month'            => 'INT',
            'limit'            => 'UINT',
            'limitstart'       => 'UINT',
            'showall'          => 'INT',
            'return'           => 'BASE64',
            'filter'           => 'STRING',
            'filter_order'     => 'CMD',
            'filter_order_Dir' => 'CMD',
            'filter-search'    => 'STRING',
            'print'            => 'BOOLEAN',
            'lang'             => 'CMD',
            'Itemid'           => 'INT', ];

        

        parent::display($cachable, $safeurlparams);

        return $this;
    }
}
