<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
//$wa->useScript('keepalive')
  //  ->useScript('form.validate')
    //->useScript('com_content.form-edit');

$this->tab_name = 'com-content-form';
$this->ignore_fieldsets = ['image-intro', 'image-full', 'jmetadata', 'item_associations'];
$this->useCoreUI = true;

// Create shortcut to parameters.
$params = $this->state->get('params');

// This checks if the editor config options have ever been saved. If they haven't they will fall back to the original settings
// if (!$params->exists('show_publishing_options')) {
//     $params->set('show_urls_images_frontend', '0');
// }
?>
<form action="<?php echo Route::_('index.php?option=com_schooltrix&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">
    <?php echo LayoutHelper::render('joomla.edit.title_alias', $this); ?>
    
    <div class="main-card">
        <div class="row">
            <div class="col-lg-6">
                <div>
                    <fieldset class="adminform">
                        <?php echo $this->form->getLabel('admission_type'); ?>
                        <?php echo $this->form->getInput('admission_type'); ?>
                    </fieldset>
                </div>
            </div>
            <div class="col-lg-6">
                <div>
                    <fieldset class="adminform">
                        <?php echo $this->form->getLabel('admission_category'); ?>
                        <?php echo $this->form->getInput('admission_category'); ?>
                    </fieldset>
                </div>
            </div>
        </div>

        <div class="row">
            <legend>Personal Information</legend>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('firstname'); ?>
                <?php echo $this->form->getInput('firstname'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('middlename'); ?>
                <?php echo $this->form->getInput('middlename'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('lastname'); ?>
                <?php echo $this->form->getInput('lastname'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('gender'); ?>
                <?php echo $this->form->getInput('gender'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('dob'); ?>
                <?php echo $this->form->getInput('dob'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('bloodgroup'); ?>
                <?php echo $this->form->getInput('bloodgroup'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('religion'); ?>
                <?php echo $this->form->getInput('religion'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('class'); ?>
                <?php echo $this->form->getInput('class'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('nationality'); ?>
                <?php echo $this->form->getInput('nationality'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('primary_language'); ?>
                <?php echo $this->form->getInput('primary_language'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('disability'); ?>
                <?php echo $this->form->getInput('disability'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('avatar'); ?>
                <?php echo $this->form->getInput('avatar'); ?>
            </div>
        </div>

        <div class="row">
            <legend>Parent's Information</legend>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('mother_firstname'); ?>
                <?php echo $this->form->getInput('mother_firstname'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('mother_middlename'); ?>
                <?php echo $this->form->getInput('mother_middlename'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('mother_lastname'); ?>
                <?php echo $this->form->getInput('mother_lastname'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('mother_contact'); ?>
                <?php echo $this->form->getInput('mother_contact'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('mother_email'); ?>
                <?php echo $this->form->getInput('mother_email'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('mother_occupation'); ?>
                <?php echo $this->form->getInput('mother_occupation'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('father_firstname'); ?>
                <?php echo $this->form->getInput('father_firstname'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('father_middlename'); ?>
                <?php echo $this->form->getInput('father_middlename'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('father_lastname'); ?>
                <?php echo $this->form->getInput('father_lastname'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('father_contact'); ?>
                <?php echo $this->form->getInput('father_contact'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('father_email'); ?>
                <?php echo $this->form->getInput('father_email'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $this->form->getLabel('father_occupation'); ?>
                <?php echo $this->form->getInput('father_occupation'); ?>
            </div>
        </div>
    </div>
</form>

