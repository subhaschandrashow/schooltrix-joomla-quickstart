<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_schooltrix
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Schooltrix\Site\Model;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\MVC\Model\FormModel;
use Joomla\CMS\Table\Table;
use Joomla\Database\ParameterType;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Schooltrix Component Student Model
 *
 * @since  1.5
 */
class StudentModel extends FormModel
{
    /**
     * Model typeAlias string. Used for version history.
     *
     * @var        string
     */
    public $typeAlias = 'com_schooltrix.student';

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function populateState()
    {
        $app   = Factory::getApplication();
        $input = $app->getInput();

       
    }

    /**
     * Method to get student data.
     *
     * @param   integer  $itemId  The id of the article.
     *
     * @return  mixed  Content item data object on success, false on failure.
     */
    public function getItem($itemId = null)
    {
        $itemId = (int) (!empty($itemId)) ? $itemId : $this->getState('student.id');

        // Get a row instance.
        $table = $this->getTable();

        // Attempt to load the row.
        $return = $table->load($itemId);

        // Check for a table object error.
        if ($return === false && $table->getError()) {
            $this->setError($table->getError());
            return false;
        }

        $properties = $table->getProperties(1);
        $value      = ArrayHelper::toObject($properties, CMSObject::class);

        // Compute selected asset permissions.
        $user   = $this->getCurrentUser();
        $userId = $user->get('id');
        $asset  = 'com_schooltrix.student.' . $value->id;

        // Check general edit permission first.
        if ($user->authorise('core.edit', $asset)) {
            $value->params->set('access-edit', true);
        } elseif (!empty($userId) && $user->authorise('core.edit.own', $asset)) {
            // Now check if edit.own is available.
            // Check for a valid user and that they are the owner.
            if ($userId == $value->created_by) {
                $value->params->set('access-edit', true);
            }
        }


        return $value;
    }

    /**
     * Get the return URL.
     *
     * @return  string  The return URL.
     *
     * @since   1.6
     */
    public function getReturnPage()
    {
        return base64_encode($this->getState('return_page', ''));
    }

    /**
     * Method to save the form data.
     *
     * @param   array  $data  The form data.
     *
     * @return  boolean  True on success.
     *
     * @since   3.2
     */
    public function save($data)
    {
        // Associations are not edited in frontend ATM so we have to inherit them
        if (
            Associations::isEnabled() && !empty($data['id'])
            && $associations = Associations::getAssociations('com_content', '#__content', 'com_content.item', $data['id'])
        ) {
            foreach ($associations as $tag => $associated) {
                $associations[$tag] = (int) $associated->id;
            }

            $data['associations'] = $associations;
        }

        if (!Multilanguage::isEnabled()) {
            $data['language'] = '*';
        }

        return parent::save($data);
    }

    /**
     * Method to get the record form.
     *
     * @param   array    $data      Data for the form.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     *
     * @return  Form|boolean  A Form object on success, false on failure
     *
     * @since   1.6
     */
    public function getForm($data = [], $loadData = true)
    {
        $form = $this->loadForm('com_schooltrix.student', 'student', ['control' => 'jform', 'load_data' => $loadData]);

        if (empty($form)) {
            return false;
        }

      

        return $form;
    }

    /**
     * Allows preprocessing of the JForm object.
     *
     * @param   Form    $form   The form object
     * @param   array   $data   The data to be merged into the form object
     * @param   string  $group  The plugin group to be executed
     *
     * @return  void
     *
     * @since   3.7.0
     */
    protected function preprocessForm(Form $form, $data, $group = 'content')
    {
        parent::preprocessForm($form, $data, $group);
    }

    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string  $name     The table name. Optional.
     * @param   string  $prefix   The class prefix. Optional.
     * @param   array   $options  Configuration array for model. Optional.
     *
     * @return  Table  A Table object
     *
     * @since   4.0.0
     * @throws  \Exception
     */
    public function getTable($name = 'Student', $prefix = 'Administrator', $options = [])
    {
        return parent::getTable($name, $prefix, $options);
    }
}
