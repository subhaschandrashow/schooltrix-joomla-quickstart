<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.schooltrix
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app   = Factory::getApplication();
$input = $app->getInput();
$wa    = $this->getWebAssetManager();

// Browsers support SVG favicons
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon.svg', '', [], true, 1), 'icon', 'rel', ['type' => 'image/svg+xml']);
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'alternate icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon-pinned.svg', '', [], true, 1), 'mask-icon', 'rel', ['color' => '#000']);

// Detecting Active Variables
$option   = $input->getCmd('option', '');
$view     = $input->getCmd('view', '');
$layout   = $input->getCmd('layout', '');
$task     = $input->getCmd('task', '');
$itemid   = $input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

// Color Theme
$paramsColorName = $this->params->get('colorName', 'colors_standard');
$assetColorName  = 'theme.' . $paramsColorName;
$wa->registerAndUseStyle($assetColorName, 'media/templates/site/schooltrix/css/global/' . $paramsColorName . '.css');

// Use a font scheme if set in the template style options
$paramsFontScheme = $this->params->get('useFontScheme', false);
$fontStyles       = '';

if ($paramsFontScheme) {
    if (stripos($paramsFontScheme, 'https://') === 0) {
        $this->getPreloadManager()->preconnect('https://fonts.googleapis.com/', ['crossorigin' => 'anonymous']);
        $this->getPreloadManager()->preconnect('https://fonts.gstatic.com/', ['crossorigin' => 'anonymous']);
        $this->getPreloadManager()->preload($paramsFontScheme, ['as' => 'style', 'crossorigin' => 'anonymous']);
        $wa->registerAndUseStyle('fontscheme.current', $paramsFontScheme, [], ['media' => 'print', 'rel' => 'lazy-stylesheet', 'onload' => 'this.media=\'all\'', 'crossorigin' => 'anonymous']);

        if (preg_match_all('/family=([^?:]*):/i', $paramsFontScheme, $matches) > 0) {
            $fontStyles = '--cassiopeia-font-family-body: "' . str_replace('+', ' ', $matches[1][0]) . '", sans-serif;
			--cassiopeia-font-family-headings: "' . str_replace('+', ' ', isset($matches[1][1]) ? $matches[1][1] : $matches[1][0]) . '", sans-serif;
			--cassiopeia-font-weight-normal: 400;
			--cassiopeia-font-weight-headings: 700;';
        }
    } else {
        $wa->registerAndUseStyle('fontscheme.current', $paramsFontScheme, ['version' => 'auto'], ['media' => 'print', 'rel' => 'lazy-stylesheet', 'onload' => 'this.media=\'all\'']);
        $this->getPreloadManager()->preload($wa->getAsset('style', 'fontscheme.current')->getUri() . '?' . $this->getMediaVersion(), ['as' => 'style']);
    }
}

// Enable assets


$wa->usePreset('template.schooltrix.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr'))
    ->useStyle('template.schooltrix.bootstrap')
    ->useStyle('template.schooltrix.feather')
    ->useStyle('template.schooltrix.icons.flags')
    ->useStyle('template.schooltrix.fontawesome.main')
    ->useStyle('template.schooltrix.fontawesome.all')
    ->useStyle('template.active.language')
    ->useStyle('template.user')
    ->useScript('template.jquery')
    ->useScript('template.bootstrapjs')
    ->useScript('template.featherjs')
    ->useScript('template.slimscroll')
    ->useScript('template.script')
    ->addInlineStyle(":root {
		--hue: 214;
		--template-bg-light: #f0f4fb;
		--template-text-dark: #495057;
		--template-text-light: #ffffff;
		--template-link-color: #2a69b8;
		--template-special-color: #001B4C;
		$fontStyles
	}");

// Override 'template.active' asset to set correct ltr/rtl dependency
$wa->registerStyle('template.active', '', [], [], ['template.schooltrix.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr')]);

// Logo file or site title param
if ($this->params->get('logoFile')) {
    $logo = HTMLHelper::_('image', Uri::root(false) . htmlspecialchars($this->params->get('logoFile'), ENT_QUOTES), $sitename, ['loading' => 'eager', 'decoding' => 'async'], false, 0);
} elseif ($this->params->get('siteTitle')) {
    $logo = '<span title="' . $sitename . '">' . htmlspecialchars($this->params->get('siteTitle'), ENT_COMPAT, 'UTF-8') . '</span>';
} else {
    $logo = HTMLHelper::_('image', 'logo.svg', $sitename, ['class' => 'logo d-inline-block', 'loading' => 'eager', 'decoding' => 'async'], true, 0);
}

$hasClass = '';

if ($this->countModules('sidebar-left', true)) {
    $hasClass .= ' has-sidebar-left';
}

if ($this->countModules('sidebar-right', true)) {
    $hasClass .= ' has-sidebar-right';
}

// Container
$wrapper = $this->params->get('fluidContainer') ? 'wrapper-fluid' : 'wrapper-static';

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

$stickyHeader = $this->params->get('stickyHeader') ? 'position-sticky sticky-top' : '';

// Defer fontawesome for increased performance. Once the page is loaded javascript changes it to a stylesheet.
$wa->getAsset('style', 'fontawesome')->setAttribute('rel', 'lazy-stylesheet');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
</head>

<body class="site <?php echo $option
    . ' ' . $wrapper
    . ' view-' . $view
    . ($layout ? ' layout-' . $layout : ' no-layout')
    . ($task ? ' task-' . $task : ' no-task')
    . ($itemid ? ' itemid-' . $itemid : '')
    . ($pageclass ? ' ' . $pageclass : '')
    . $hasClass
    . ($this->direction == 'rtl' ? ' rtl' : '');
?>">
    <div class="main-wrapper">

<div class="header">
    <div class="header-left">
        <a href="index.html" class="logo brand-logo">
            <?php echo $logo; ?>
        </a>
        <a href="index.html" class="logo logo-small">
            <img src="assets/img/logo-small.png" alt="Logo" width="30" height="30">
        </a>
    </div>

    <div class="menu-toggle">
    <a href="javascript:void(0);" id="toggle_btn">
    <i class="fas fa-bars"></i>
    </a>
    </div>

<div class="top-nav-search">
<form>
<input type="text" class="form-control" placeholder="Search here">
<button class="btn" type="submit"><i class="fas fa-search"></i></button>
</form>
</div>


<a class="mobile_btn" id="mobile_btn">
<i class="fas fa-bars"></i>
</a>


<ul class="nav user-menu">
<li class="nav-item dropdown language-drop me-2">
<a href="#" class="dropdown-toggle nav-link header-nav-list" data-bs-toggle="dropdown">
<img src="assets/img/icons/header-icon-01.svg" alt="">
</a>
<div class="dropdown-menu">
<a class="dropdown-item" href="javascript:;"><i class="flag flag-lr me-2"></i>English</a>
<a class="dropdown-item" href="javascript:;"><i class="flag flag-bl me-2"></i>Francais</a>
<a class="dropdown-item" href="javascript:;"><i class="flag flag-cn me-2"></i>Turkce</a>
</div>
</li>

<li class="nav-item dropdown noti-dropdown me-2">
<a href="#" class="dropdown-toggle nav-link header-nav-list" data-bs-toggle="dropdown">
<img src="assets/img/icons/header-icon-05.svg" alt="">
</a>
<div class="dropdown-menu notifications">
<div class="topnav-dropdown-header">
<span class="notification-title">Notifications</span>
<a href="javascript:void(0)" class="clear-noti"> Clear All </a>
</div>
<div class="noti-content">
<ul class="notification-list">
<li class="notification-message">
<a href="#">
<div class="media d-flex">
<span class="avatar avatar-sm flex-shrink-0">
<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-02.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">Carlson Tech</span> has approved <span class="noti-title">your estimate</span></p>
<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="#">
<div class="media d-flex">
<span class="avatar avatar-sm flex-shrink-0">
<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-11.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">International Software Inc</span> has sent you a invoice in the amount of <span class="noti-title">$218</span></p>
<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="#">
<div class="media d-flex">
<span class="avatar avatar-sm flex-shrink-0">
<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-17.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">John Hendry</span> sent a cancellation request <span class="noti-title">Apple iPhone XR</span></p>
<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="#">
<div class="media d-flex">
<span class="avatar avatar-sm flex-shrink-0">
<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-13.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">Mercury Software Inc</span> added a new product <span class="noti-title">Apple MacBook Pro</span></p>
<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
</div>
</div>
</a>
</li>
</ul>
</div>
<div class="topnav-dropdown-footer">
<a href="#">View all Notifications</a>
</div>
</div>
</li>

<li class="nav-item zoom-screen me-2">
<a href="#" class="nav-link header-nav-list">
<img src="assets/img/icons/header-icon-04.svg" alt="">
</a>
</li>

<li class="nav-item dropdown has-arrow new-user-menus">
<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
<span class="user-img">
<img class="rounded-circle" src="assets/img/profiles/avatar-01.jpg" width="31" alt="Soeng Souy">
<div class="user-text">
<h6>Soeng Souy</h6>
<p class="text-muted mb-0">Administrator</p>
</div>
</span>
</a>
<div class="dropdown-menu">
<div class="user-header">
<div class="avatar avatar-sm">
<img src="assets/img/profiles/avatar-01.jpg" alt="User Image" class="avatar-img rounded-circle">
</div>
<div class="user-text">
<h6>Soeng Souy</h6>
<p class="text-muted mb-0">Administrator</p>
</div>
</div>
<a class="dropdown-item" href="profile.html">My Profile</a>
<a class="dropdown-item" href="inbox.html">Inbox</a>
<a class="dropdown-item" href="login.html">Logout</a>
</div>
</li>

</ul>

</div>


<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <jdoc:include type="modules" name="sidebar-left" style="sidebar" />
    </div>
</div>


<div class="page-wrapper">
<div class="content container-fluid">
    <jdoc:include type="component" />

<div class="page-header">
<div class="row">
<div class="col-sm-12">
<div class="page-sub-header">
<h3 class="page-title">Students</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="students.html">Student</a></li>
<li class="breadcrumb-item active">All Students</li>
</ul>
</div>
</div>
</div>
</div>

<div class="student-group-form">
<div class="row">
<div class="col-lg-3 col-md-6">
<div class="form-group">
<input type="text" class="form-control" placeholder="Search by ID ...">
</div>
</div>
<div class="col-lg-3 col-md-6">
<div class="form-group">
<input type="text" class="form-control" placeholder="Search by Name ...">
</div>
</div>
<div class="col-lg-4 col-md-6">
<div class="form-group">
<input type="text" class="form-control" placeholder="Search by Phone ...">
</div>
</div>
<div class="col-lg-2">
<div class="search-student-btn">
<button type="btn" class="btn btn-primary">Search</button>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<div class="card card-table comman-shadow">
<div class="card-body">

<div class="page-header">
<div class="row align-items-center">
<div class="col">
<h3 class="page-title">Students</h3>
</div>
<div class="col-auto text-end float-end ms-auto download-grp">
<a href="students.html" class="btn btn-outline-gray me-2 active"><i class="feather-list"></i></a>
<a href="students-grid.html" class="btn btn-outline-gray me-2"><i class="feather-grid"></i></a>
<a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
<a href="add-student.html" class="btn btn-primary"><i class="fas fa-plus"></i></a>
</div>
</div>
</div>

<div class="table-responsive">
<table class="table border-0 star-student table-hover table-center mb-0  table-striped">
<thead class="student-thread">
<tr>
<th>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</th>
<th>ID</th>
<th>Name</th>
<th>Class</th>
<th>DOB</th>
<th>Parent Name</th>
<th>Mobile Number</th>
<th>Address</th>
<th class="text-end">Action</th>
</tr>
</thead>
<tbody>
 <tr>
<td>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
<td>PRE2209</td>
<td>
<h2 class="table-avatar">
<a href="student-details.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-01.jpg" alt="User Image"></a>
<a href="student-details.html">Aaliyah</a>
</h2>
</td>
<td>10 A</td>
<td>2 Feb 2002</td>
<td>Jeffrey Wong</td>
<td>097 3584 5870</td>
<td>911 Deer Ridge Drive,USA</td>
<td class="text-end">
<div class="actions ">
<a href="javascript:;" class="btn btn-sm bg-success-light me-2 ">
<i class="feather-eye"></i>
</a>
<a href="edit-student.html" class="btn btn-sm bg-danger-light">
<i class="feather-edit"></i>
</a>
</div>
</td>
</tr>
<tr>
<td>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
<td>PRE2213</td>
<td>
<h2 class="table-avatar">
<a href="student-details.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-03.jpg" alt="User Image"></a>
<a href="student-details.html">Malynne</a>
</h2>
</td>
<td>8 A</td>
<td>3 June 2010</td>
<td>Fields Malynne</td>
<td>242 362 3100</td>
<td>Bacardi Rd P.O. Box N-4880, New Providence</td>
<td class="text-end">
<div class="actions ">
<a href="javascript:;" class="btn btn-sm bg-success-light me-2 ">
<i class="feather-eye"></i>
</a>
<a href="edit-student.html" class="btn btn-sm bg-danger-light">
<i class="feather-edit"></i>
</a>
</div>
</td>
</tr>
<tr>
<td>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
<td>PRE2143</td>
<td>
<h2 class="table-avatar">
<a href="student-details.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-02.jpg" alt="User Image"></a>
<a href="student-details.html">Levell Scott</a>
</h2>
</td>
<td>10 A</td>
<td>12 Apr 2002</td>
<td>Jeffrey Scott</td>
<td>026 7318 4366</td>
<td>P.O. Box: 41, Gaborone</td>
<td class="text-end">
<div class="actions ">
<a href="javascript:;" class="btn btn-sm bg-success-light me-2 ">
<i class="feather-eye"></i>
</a>
<a href="edit-student.html" class="btn btn-sm bg-danger-light">
<i class="feather-edit"></i>
</a>
</div>
</td>
</tr>
<tr>
<td>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
<td>PRE2431</td>
<td>
<h2 class="table-avatar">
<a href="student-details.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-03.jpg" alt="User Image"></a>
<a href="student-details.html">Minnie</a>
</h2>
</td>
<td>11 C</td>
<td>24 Feb 2000</td>
<td>J Shaffer</td>
<td>952 512 4909</td>
<td>4771 Oral Lake Road, Golden Valley</td>
<td class="text-end">
<div class="actions ">
<a href="javascript:;" class="btn btn-sm bg-success-light me-2 ">
<i class="feather-eye"></i>
</a>
<a href="edit-student.html" class="btn btn-sm bg-danger-light">
<i class="feather-edit"></i>
</a>
</div>
</td>
</tr>
<tr>
<td>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
<td>PRE1534</td>
<td>
<h2 class="table-avatar">
<a href="student-details.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-04.jpg" alt="User Image"></a>
<a href="student-details.html">Lois A</a>
</h2>
</td>
<td>10 A</td>
<td>22 Jul 2006</td>
<td>Cleary Wong</td>
<td>413 289 1314</td>
<td>2844 Leverton Cove Road, Palmer</td>
<td class="text-end">
<div class="actions ">
<a href="javascript:;" class="btn btn-sm bg-success-light me-2 ">
<i class="feather-eye"></i>
</a>
<a href="edit-student.html" class="btn btn-sm bg-danger-light">
<i class="feather-edit"></i>
</a>
</div>
</td>
</tr>
<tr>
<td>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
<td>PRE2153</td>
<td>
<h2 class="table-avatar">
<a href="student-details.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-05.jpg" alt="User Image"></a>
<a href="student-details.html">Calvin</a>
</h2>
</td>
<td>9 B</td>
<td>8 Dec 2003</td>
<td>Minnie J Shaffer</td>
<td>701 753 3810</td>
<td>1900 Hidden Meadow Drive, Crete</td>
<td class="text-end">
<div class="actions ">
<a href="javascript:;" class="btn btn-sm bg-success-light me-2 ">
<i class="feather-eye"></i>
</a>
<a href="edit-student.html" class="btn btn-sm bg-danger-light">
<i class="feather-edit"></i>
</a>
</div>
</td>
</tr>
<tr>
<td>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
<td>PRE1252</td>
<td>
<h2 class="table-avatar">
<a href="student-details.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-06.jpg" alt="User Image"></a>
<a href="student-details.html">Joe Kelley</a>
</h2>
</td>
<td>11 C</td>
<td>7 Oct 2000</td>
<td>Vincent Howard</td>
<td>402 221 7523</td>
<td>3979 Ashwood Drive, Omaha</td>
<td class="text-end">
<div class="actions ">
<a href="javascript:;" class="btn btn-sm bg-success-light me-2 ">
<i class="feather-eye"></i>
</a>
<a href="edit-student.html" class="btn btn-sm bg-danger-light">
<i class="feather-edit"></i>
</a>
</div>
</td>
</tr>
<tr>
<td>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
<td>PRE1434</td>
<td>
<h2 class="table-avatar">
<a href="student-details.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-07.jpg" alt="User Image"></a>
<a href="student-details.html">Vincent</a>
</h2>
</td>
<td>10 A</td>
<td>4 Jan 2002</td>
<td>Kelley Joe</td>
<td>402 221 7523</td>
<td>3979 Ashwood Drive, Omaha</td>
<td class="text-end">
<div class="actions ">
<a href="javascript:;" class="btn btn-sm bg-success-light me-2 ">
<i class="feather-eye"></i>
</a>
<a href="edit-student.html" class="btn btn-sm bg-danger-light">
<i class="feather-edit"></i>
</a>
</div>
</td>
</tr>
<tr>
<td>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
<td>PRE2345</td>
<td>
<h2 class="table-avatar">
<a href="student-details.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-08.jpg" alt="User Image"></a>
<a href="student-details.html">Kozma  Tatari</a>
</h2>
</td>
<td>9 A</td>
<td>1 Feb 2006</td>
<td>Lombardi</td>
<td>04 2239 968</td>
<td>Rruga E Kavajes, Condor Center, Tirana</td>
<td class="text-end">
<div class="actions ">
<a href="javascript:;" class="btn btn-sm bg-success-light me-2 ">
<i class="feather-eye"></i>
</a>
<a href="edit-student.html" class="btn btn-sm bg-danger-light">
<i class="feather-edit"></i>
</a>
</div>
</td>
</tr>
<tr>
<td>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
<td>PRE2365</td>
<td>
<h2 class="table-avatar">
<a href="student-details.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-09.jpg" alt="User Image"></a>
<a href="student-details.html">John Chambers</a>
</h2>
</td>
<td>11 B</td>
<td>13 Sept 2003</td>
<td>Wong Jeffrey</td>
<td>870 663 2334</td>
<td>4667 Sunset Drive, Pine Bluff</td>
<td class="text-end">
<div class="actions ">
<a href="javascript:;" class="btn btn-sm bg-success-light me-2 ">
<i class="feather-eye"></i>
</a>
<a href="edit-student.html" class="btn btn-sm bg-danger-light">
<i class="feather-edit"></i>
</a>
</div>
</td>
</tr>
<tr>
<td>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
 <td>PRE1234</td>
<td>
<h2 class="table-avatar">
<a href="student-details.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-10.jpg" alt="User Image"></a>
<a href="student-details.html">Nathan Humphries</a>
</h2>
</td>
<td>10 B</td>
<td>26 Apr 1994</td>
<td>Stephen Marley</td>
<td>077 3499 9959</td>
<td>86 Lamphey Road, Thelnetham</td>
<td class="text-end">
<div class="actions ">
<a href="javascript:;" class="btn btn-sm bg-success-light me-2 ">
<i class="feather-eye"></i>
</a>
<a href="edit-student.html" class="btn btn-sm bg-danger-light">
<i class="feather-edit"></i>
</a>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>

<footer>
<p>Copyright © 2022 Dreamguys.</p>
</footer>

</div>

</div>
</body>
</html>
