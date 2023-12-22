<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\schoolTrix\Administrator\Controller;

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Versioning\VersionableControllerTrait;
use Joomla\Utilities\ArrayHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Season controller class.
 *
 * @since  1.6
 */
class SeasonController extends FormController
{
    use VersionableControllerTrait;

    /**
     * The prefix to use with controller messages.
     *
     * @var    string
     * @since  1.6
     */
    protected $text_prefix = 'S_BANNER';

    /**
     * Method override to check if you can add a new record.
     *
     * @param   array  $data  An array of input data.
     *
     * @return  boolean
     *
     * @since   1.6
     */
    protected function allowAdd($data = [])
    {
        $filter     = $this->input->getInt('filter_category_id');
        $categoryId = ArrayHelper::getValue($data, 'catid', $filter, 'int');

        // In the absence of better information, revert to the component permissions.
        return parent::allowAdd($data);
    }

    /**
     * Method override to check if you can edit an existing record.
     *
     * @param   array   $data  An array of input data.
     * @param   string  $key   The name of the key for the primary key.
     *
     * @return  boolean
     *
     * @since   1.6
     */
    protected function allowEdit($data = [], $key = 'id')
    {
        $recordId   = (int) isset($data[$key]) ? $data[$key] : 0;
        $categoryId = 0;

        // Since there is no asset tracking, revert to the component permissions.
        return parent::allowEdit($data, $key);
    }

    /**
     * Method to run batch operations.
     *
     * @param   string  $model  The model
     *
     * @return  boolean  True on success.
     *
     * @since   2.5
     */
    public function batch($model = null)
    {
        $this->checkToken();

        // Set the model
        $model = $this->getModel('Banner', '', []);

        // Preset the redirect
        $this->setRedirect(Route::_('index.php?option=com_banners&view=banners' . $this->getRedirectToListAppend(), false));

        return parent::batch($model);
    }
}
