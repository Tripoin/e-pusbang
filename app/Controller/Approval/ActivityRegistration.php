<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Approval -> ParticipantRegistration
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ADMIN TEMPLATE V.1.0
 */

namespace app\Controller\Approval;

use app\Controller\Base\Controller;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Model\TransactionRegistrationDetails;
use app\Model\MasterApproval;
use app\Model\MasterApprovalCategory;
use app\Model\MasterWaitingList;
use app\Model\MasterParticipantType;
use app\Model\MasterWorkingUnit;
use app\Model\MasterGovernmentAgencies;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\MasterCurriculum;
use app\Model\MasterNotification;
use app\Model\MasterSubject;
use app\Model\MasterReligion;
use app\Model\MasterContact;
use app\Model\MasterAddress;
use app\Model\MasterProvince;
use app\Model\MasterCity;
use app\Model\MasterDistrict;
use app\Model\MasterVillage;
use app\Model\MasterGovernmentClassification;
use app\Model\LinkRegistration;
use app\Model\TransactionRegistration;
use app\Model\MasterAttachment;
use app\Model\SecurityUserProfile;
use app\Model\SecurityUser;
use app\Model\SecurityGroup;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Util\Form;
use app\Util\DataTable;
use app\Util\Database;
use app\Util\Button;
use app\Util\PHPMail\PHPMailer;

//use app\Util\Form;

class ActivityRegistration extends Controller {

    //put your code here

    public function __construct() {
        $this->modelData = new MasterApproval();
        $this->setTitle(lang('approval.approval'));
        $this->setSubTitle(lang('approval.activity_registration'));
        $this->setBreadCrumb(array(lang('approval.approval') => "", lang('approval.activity_registration') => FULLURL()));
        $this->search_filter = array(
            "code" => lang('general.code'),
            "created_by" => lang('approval.user')
        );
        $this->orderBy = $this->modelData->getId() . " DESC";
        $this->indexUrl = IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL;
        $this->viewPath = IViewConstant::APPROVAL_ACTIVITY_REGISTRATION_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function listData() {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
        $data = $this->modelData;
        $masterApproval = new MasterApproval();
        $masterApprovalCategory = new MasterApprovalCategory();
        $masterWaitingList = new MasterWaitingList();
        $masterUserMain = new MasterUserMain();

        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter($this->search_filter);
        $Datatable->createButton(FALSE);
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $search = " AND " . $masterApproval->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
            $search = " AND " . $masterApproval->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else {
            $search = " AND " . $masterApproval->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
        }

//        echo $Datatable->search;

        $whereList = $masterApprovalCategory->getEntity() . DOT . $masterApprovalCategory->getId() . EQUAL . $masterApproval->getEntity() . DOT . $masterApproval->getApprovalCategoryId() . ""
                . " AND " . $masterApproval->getEntity() . DOT . $masterApproval->getApprovalDetailId() . EQUAL . $masterWaitingList->getEntity() . DOT . $masterWaitingList->getId() . ""
                . " AND " . $masterWaitingList->getEntity() . DOT . $masterWaitingList->getUserMainId() . EQUAL . $masterUserMain->getEntity() . DOT . $masterUserMain->getId() . ""
                . " AND " . $masterApprovalCategory->getEntity() . DOT . $masterApproval->getCode() . equalToIgnoreCase('WAITING-LIST') . ""
                . "" . $search;
//        $Datatable->debug(true);
        $list_data = $Datatable->select_pagination($masterApproval, $masterApproval->getEntity(), $whereList, array($masterApprovalCategory->getEntity(), $masterWaitingList->getEntity(), $masterUserMain->getEntity()), $masterApprovalCategory->getEntity(), $this->orderBy, ""
                . $masterApproval->getEntity() . DOT . $masterApproval->getId() . " as id,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getCode() . " as code,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getCreatedByUsername() . " as username,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getCreatedOn() . " as created_on,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getIsExecuted() . " as excecuted,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getStatus() . " as status,"
                . $masterApprovalCategory->getEntity() . "." . $masterApprovalCategory->getName() . " as approval_category_name", $masterApproval->getEntity() . "." . $masterApproval->getId());
//        print_r($list_data);
        include_once FILE_PATH($this->viewList);
    }

    public function edit() {
        $Form = new Form();
        $id = $_POST['id'];
        $db = new Database();
        $db->connect();
        $masterApproval = new MasterApproval();
        $masterApprovalCategory = new MasterApprovalCategory();
        $masterWaitingList = new MasterWaitingList();
        $m_act = new TransactionActivity();
        $m_user_assign = new MasterUserAssignment();
        $m_user_main = new MasterUserMain();
        $m_participant_type = new MasterParticipantType();
        $m_working_unit = new MasterWorkingUnit();
        $m_gov_agencies = new MasterGovernmentAgencies();
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $masterReligion = new MasterReligion();
        $masterContact = new MasterContact();
        $masterAddress = new MasterAddress();
        $masterProvince = new MasterProvince();
        $masterCity = new MasterCity();
        $masterDistrict = new MasterDistrict();
        $masterVillage = new MasterVillage();
        $mGovClass = new MasterGovernmentClassification();
        $masterSubject = new MasterSubject();
//        print_r($id);
        $dt_approval = $db->selectByID($masterApproval, $masterApproval->getId() . EQUAL . $id);
        $dt_approval_category = $db->selectByID($masterApprovalCategory, $masterApprovalCategory->getId() . EQUAL . $dt_approval[0][$masterApproval->getApprovalCategoryId()]);

        $dt_waiting_list = $db->selectByID($masterWaitingList, $masterWaitingList->getId() . EQUAL . $dt_approval[0][$masterApproval->getApprovalDetailId()]);

        $dt_activity = $db->selectByID($m_act, $m_act->getId() . EQUAL . $dt_waiting_list[0][$masterWaitingList->getActivityId()]);
//        print_r($dt_activity);
        $dt_user_main = $db->selectByID($m_user_main, $m_user_main->getId() . EQUAL . $dt_waiting_list[0][$masterWaitingList->getUserMainId()]);

        $dt_participant_type = $db->selectByID($m_participant_type, $m_participant_type->getId() . EQUAL . $dt_user_main[0][$m_user_main->getParticipantTypeId()]);

        $dt_working_unit = $db->selectByID($m_working_unit, $m_working_unit->getId() . EQUAL . $dt_user_main[0][$m_user_main->getWorkingUnitId()]);

        $dt_gov_agencies = $db->selectByID($m_gov_agencies, $m_gov_agencies->getId() . EQUAL . $dt_working_unit[0][$m_working_unit->getGovernment_agency_id()]);

        $dt_user_profile = $db->selectByID($userProfile, $userProfile->getId() . EQUAL . $dt_user_main[0][$m_user_main->getUserProfileId()]);
        $dt_religion = $db->selectByID($masterReligion, $masterReligion->getId() . EQUAL . $dt_user_profile[0][$userProfile->getReligionId()]);
        $dt_contact = $db->selectByID($masterContact, $masterContact->getId() . EQUAL . $dt_user_profile[0][$userProfile->getContactId()]);
        $dt_address = $db->selectByID($masterAddress, $masterAddress->getId() . EQUAL . $dt_user_profile[0][$userProfile->getAddressId()]);
        $dt_province = $db->selectByID($masterProvince, $masterProvince->getId() . EQUAL . $dt_address[0][$masterAddress->getProvinceId()]);
        $dt_city = $db->selectByID($masterCity, $masterCity->getId() . EQUAL . $dt_address[0][$masterAddress->getCityId()]);
        $dt_district = $db->selectByID($masterDistrict, $masterDistrict->getId() . EQUAL . $dt_address[0][$masterAddress->getDistrictId()]);
        $dt_village = $db->selectByID($masterVillage, $masterVillage->getId() . EQUAL . $dt_address[0][$masterAddress->getVillageId()]);

        $dt_gov_class = $db->selectByID($mGovClass, $mGovClass->getId() . EQUAL . $dt_user_main[0][$m_user_main->getGovernmentClassificationId()]);

        $data_subject = valueComboBoxParent($masterSubject->getEntity(), $masterSubject->getId(), $masterSubject->getName(), $masterSubject->getParentId(), $masterSubject->getId() . equalToIgnoreCase($dt_activity[0][$m_act->getSubjectId()]));

//        MasterGovernmentClassification
//        print_r($dt_user_profile);
        include_once FILE_PATH(IViewConstant::APPROVAL_ACTIVITY_REGISTRATION_VIEW_INDEX . '/edit.html.php');
    }

    public function create() {
        parent::create();
    }

    public function approveData($activity_id) {
        $id = $_POST['id'];

        $masterWaitingList = new MasterWaitingList();
        $masterApproval = new MasterApproval();
        $masterUserAssignment = new MasterUserAssignment();
        $db = new Database();
        $db->connect();
        $approvalCategoryId = $_POST['approval_category_id'];
        $transactionRegistration = new TransactionRegistration();
        if ($approvalCategoryId == 3) {
            $userMainId = $_POST['user_main_id'];
            $rs_approve = $db->selectByID($masterApproval, $masterApproval->getApprovalDetailId() . EQUAL . $id . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . "3");

            $db->update($masterWaitingList->getEntity(), array(
                $masterWaitingList->getApprovedBy() => $_SESSION[SESSION_USERNAME_GUEST],
                $masterWaitingList->getIsApproved() => 1,
                $masterWaitingList->getApprovedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                    ), $masterWaitingList->getId() . EQUAL . $id);
            $result = $db->getResult();
            if ($result[0] == 1) {
                $db->update($masterApproval->getEntity(), array(
                    $masterApproval->getStatus() => 1,
                    $masterApproval->getModifiedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                    $masterApproval->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                        ), $masterApproval->getApprovalDetailId() . EQUAL . $id . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . "3");
//            echo $db->getSql();
                $result_2 = $db->getResult();
//            print_r($result_2);
                if ($result_2[0] == 1) {
                    $code_user_assignment = createRandomBooking();
                    $db->insert($masterUserAssignment->getEntity(), array(
                        $masterUserAssignment->getCode() => $code_user_assignment,
                        $masterUserAssignment->getName() => $code_user_assignment . '-' . $_SESSION[SESSION_USERNAME_GUEST],
                        $masterUserAssignment->getRoleId() => 1,
                        $masterUserAssignment->getUser_main_id() => $userMainId,
                        $masterUserAssignment->getActivity_id() => $activity_id,
                        $masterUserAssignment->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                        $masterUserAssignment->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                    ));
                    $result_3 = $db->getResult();
                    if (is_numeric($result_3[0])) {
                        $securityUser = new SecurityUser();
                        $securityUserProfile = new SecurityUserProfile();
                        $masterUserMain = new MasterUserMain();
                        $transactionActivity = new TransactionActivity();

                        $rs_user_admin = $db->selectByID($securityUser, $securityUser->getCode() . equalToIgnoreCase($_SESSION[SESSION_ADMIN_USERNAME]));
                        $rs_user_profile_admin = $db->selectByID($securityUserProfile, $securityUserProfile->getUserId() . equalToIgnoreCase($rs_user_admin[0][$securityUser->getId()]));

                        $rs_activity = $db->selectByID($transactionActivity, $transactionActivity->getId() . equalToIgnoreCase($activity_id));

                        $rs_user_main = $db->selectByID($masterUserMain, $masterUserMain->getId() . equalToIgnoreCase($userMainId));

                        $rs_user_profile = $db->selectByID($securityUserProfile, $securityUserProfile->getId() . equalToIgnoreCase($rs_user_main[0][$masterUserMain->getUserProfileId()]));

                        $img_logo = IMAGE_ICON_EMAIL_URL;
                        $subject = 'Approval Registrasi Peserta Pusbang BKN';
                        $body = '<div style="border-style: solid;border-width: thin;font-family: \'Roboto\';">
                      <div align="center" style="margin:15px;"><img src="' . $img_logo . '" width="120" height="40"/></div>
                        <div align="left" style="margin:15px;">
                            Kepada Yang Terhormat ' . $rs_user_profile[0][$securityUserProfile->getName()] . ',
                        <br/><br/>
                       <p>
                            Pendaftaran Kegiatan anda telah disetujui, 
                            Anda bisa melakukan pendaftaran peserta menggunakan username dan password dibawah ini:
                            <br/><br/>Nama Kegiatan : <b>' . $rs_activity[0][$transactionActivity->getName()] . '</b>
                            <br/>Waktu Pelaksanaan : <b>' . subMonth($rs_activity[0][$transactionActivity->getStartActivity()]) . ' - ' . subMonth($rs_activity[0][$transactionActivity->getEndActivity()]) . '</b>
                            <br/><br/>
                            Silahkan klik link dibawah ini untuk menuju kehalaman Portal Pusbang ASN,
                            <br/>
                            <a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                       </p>
                        <br/>
                        <br/>
                        Terima Kasih telah mendaftar di Pusbang ASN
                        <br/><a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                        </div>
                        </div>
                            ';
                        $code_notif = createRandomBooking();
                        $masterNotification = new MasterNotification();
                        $db->insert($masterNotification->getEntity(), array(
                            $masterNotification->getCode() => $code_notif,
                            $masterNotification->getName() => $subject,
                            $masterNotification->getTitle() => $subject,
                            $masterNotification->getMessage() => $body,
                            $masterNotification->getFrom() => $rs_user_profile_admin[0][$securityUserProfile->getId()],
                            $masterNotification->getTo() => $rs_user_profile[0][$securityUserProfile->getId()],
                            $masterNotification->getDate() => date(DATE_FORMAT_PHP_DEFAULT),
                        ));

                        $rs_insert_notif = $db->getResult();
                        if (is_numeric($rs_insert_notif[0])) {
                            echo toastAlert('success', lang('general.title_approved_success'), lang('general.message_approved_success'));
                            echo '<script>$(function () {postAjaxPagination();});</script>';
                        } else {
                            echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
                            echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
                        }
                    } else {
                        $db->update($masterApproval->getEntity(), array(
                            $masterApproval->getStatus() => null,
                            $masterApproval->getModifiedByUsername() => null,
                            $masterApproval->getModifiedOn() => null,
                                ), $masterApproval->getApprovalDetailId() . EQUAL . $id . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . "3");
                        echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
                        echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
                    }
                } else {
                    echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
                    echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
                }
            } else {
                echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
                echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
            }
        } else if ($approvalCategoryId == 1) {
            $registrationId = $_POST['registration_id'];
            $db->update($transactionRegistration->getEntity(), array(
                $transactionRegistration->getIsApproved() => 1,
                $transactionRegistration->getApprovedBy() => $_SESSION[SESSION_ADMIN_USERNAME],
                $transactionRegistration->getApprovedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                    ), $transactionRegistration->getId() . equalToIgnoreCase($registrationId));
            $rs_update_reg = $db->getResult();
            if (is_numeric($rs_update_reg[0]) == 1) {
                $rs_approve = $db->selectByID($masterApproval, $masterApproval->getApprovalDetailId() . EQUAL . $id . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . $approvalCategoryId);
                $db->update($masterApproval->getEntity(), array(
                    $masterApproval->getStatus() => 1,
                    $masterApproval->getModifiedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
                    $masterApproval->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                        ), $masterApproval->getId() . EQUAL . $id . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . $approvalCategoryId);
                $result_2 = $db->getResult();
                if (is_numeric($result_2[0]) == 1) {
                    $this->createUserFromRegistration();
                } else {
                    echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
                    echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit-registration') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
                }
            } else {
                echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_rapproved_error'));
                echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit-registration') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
            }
        }
    }

    public function createUserFromRegistration() {
        $approvalCategoryId = $_POST['approval_category_id'];
        $registrationId = $_POST['registration_id'];
        $transactionRegistration = new TransactionRegistration();
        $masterApproval = new MasterApproval();
        $securityUser = new SecurityUser();
        $securityUserProfile = new SecurityUserProfile();
        $securityGroup = new SecurityGroup();
        $masterContact = new MasterContact();
        $masterAddress = new MasterAddress();

        $db = new Database();
        $db->connect();

        $rs_reg = $db->selectByID($transactionRegistration, $transactionRegistration->getId() . equalToIgnoreCase($registrationId));
        $rs_approve = $db->selectByID($masterApproval, $masterApproval->getApprovalDetailId() . EQUAL . $registrationId . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . $approvalCategoryId);
        $code = explode('@', $rs_reg[0][$transactionRegistration->getDelegationEmail()]);

        $rs_group = $db->selectByID($securityGroup, $securityGroup->getCode() . equalToIgnoreCase('DELEGATION'));

        $password = password_hash($code[0], PASSWORD_BCRYPT);
        $db->insert($securityUser->getEntity(), array(
            $securityUser->getCode() => $code[0],
            $securityUser->getName() => $code[0],
            $securityUser->getEmail() => $rs_reg[0][$transactionRegistration->getDelegationEmail()],
            $securityUser->getPassword() => $password,
            $securityUser->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            $securityUser->getCreatedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
            $securityUser->getStatus() => 1,
            $securityUser->getGroupId() => $rs_group[0][$securityGroup->getId()],
            $securityUser->getDescription() => $code[0] . ' - From Registration PIC'
        ));
        $rs_user = $db->getResult();
//        LOGGER("insert user:".$rs_user);
        if (is_numeric($rs_user[0])) {
            $db->insert($masterContact->getEntity(), array(
                $masterContact->getCode() => createRandomBooking() . "-" . $code[0],
                $masterContact->getName() => $code[0],
                $masterContact->getEmail1() => $rs_reg[0][$transactionRegistration->getDelegationEmail()],
                $masterContact->getFax() => $rs_reg[0][$transactionRegistration->getDelegationFax()],
                $masterContact->getPhoneNumber1() => $rs_reg[0][$transactionRegistration->getDelegationPhoneNumber()],
                $masterContact->getStatus() => 1,
                $masterContact->getCreatedOn() => $_SESSION[SESSION_ADMIN_USERNAME],
                $masterContact->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            ));
            $rs_contact = $db->getResult();

            $db->insert($masterAddress->getEntity(), array(
                $masterAddress->getCode() => createRandomBooking() . "-" . $code[0],
                $masterAddress->getName() => $rs_reg[0][$transactionRegistration->getDelegationAddress()],
                $masterAddress->getDescription() => $rs_reg[0][$transactionRegistration->getDelegationAddress()],
                $masterAddress->getProvinceId() => $rs_reg[0][$transactionRegistration->getProvinceId()],
                $masterAddress->getCityId() => $rs_reg[0][$transactionRegistration->getCityId()],
                $masterAddress->getVillageId() => $rs_reg[0][$transactionRegistration->getVillageId()],
                $masterAddress->getDistrictId() => $rs_reg[0][$transactionRegistration->getDistrictId()],
                $masterAddress->getZipCode() => $rs_reg[0][$transactionRegistration->getZipCode()],
                $masterAddress->getStatus() => 1,
                $masterAddress->getCreatedOn() => $_SESSION[SESSION_ADMIN_USERNAME],
                $masterAddress->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            ));
            $rs_address = $db->getResult();
            $db->insert($securityUserProfile->getEntity(), array(
                $securityUserProfile->getCode() => $code[0],
                $securityUserProfile->getName() => $rs_reg[0][$transactionRegistration->getDelegationName()],
                $securityUserProfile->getContactId() => $rs_contact[0],
                $securityUserProfile->getAddressId() => $rs_address[0],
                $securityUserProfile->getUserId() => $rs_user[0],
                $securityUserProfile->getStatus() => 1,
                $securityUserProfile->getCreatedOn() => $_SESSION[SESSION_ADMIN_USERNAME],
                $securityUserProfile->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            ));
            $rs_user_profile = $db->getResult();
            if (is_numeric($rs_user_profile[0])) {
                $db->update($transactionRegistration->getEntity(), array(
                    $transactionRegistration->getUserId() => $rs_user[0],
                        ), $transactionRegistration->getId() . equalToIgnoreCase($registrationId));
                $rs_update_reg = $db->getResult();
                $sendMail = $this->sendMailUserFromRegistration();
                if ($sendMail == true) {
                    echo toastAlert('success', lang('general.title_approved_success'), lang('general.message_approved_success'));
                    echo '<script>$(function () {$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
                } else {
                    if (is_numeric($rs_contact[0])) {
                        $db->delete($masterContact->getEntity(), $masterContact->getId() . equalToIgnoreCase($rs_contact[0]));
                        $rs_delete = $db->getResult();
                    }
                    if (is_numeric($rs_address[0])) {
                        $db->delete($masterAddress->getEntity(), $masterAddress->getId() . equalToIgnoreCase($rs_address[0]));
                        $rs_delete = $db->getResult();
                    }
                    $db->delete($securityUserProfile->getEntity(), $securityUserProfile->getId() . equalToIgnoreCase($rs_user_profile[0]));
                    $rs_delete = $db->getResult();
                    $this->rollBackApproval();
                    echo toastAlert('error', lang('general.title_approved_error'), "Gagal Mengirim Email");
                    echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit-registration') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
                }
            } else {
                if (is_numeric($rs_contact[0])) {
                    $db->delete($masterContact->getEntity(), $masterContact->getId() . equalToIgnoreCase($rs_contact[0]));
                    $rs_delete = $db->getResult();
                }
                if (is_numeric($rs_address[0])) {
                    $db->delete($masterAddress->getEntity(), $masterAddress->getId() . equalToIgnoreCase($rs_address[0]));
                    $rs_delete = $db->getResult();
                }
                $this->rollBackApproval();
                echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
                echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit-registration') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
            }
        } else {
            $this->rollBackApproval();
            echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
            echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit-registration') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
        }
    }

    public function sendMailRejectData() {
        $approvalCategoryId = $_POST['approval_category_id'];
        $registrationId = $_POST['registration_id'];
        $transactionRegistration = new TransactionRegistration();
        $masterApproval = new MasterApproval();
        $db = new Database();
        $db->connect();
        $rs_reg = $db->selectByID($transactionRegistration, $transactionRegistration->getId() . equalToIgnoreCase($registrationId));
        $rs_approve = $db->selectByID($masterApproval, $masterApproval->getApprovalDetailId() . EQUAL . $registrationId . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . $approvalCategoryId);
        $code = explode('@', $rs_reg[0][$transactionRegistration->getDelegationEmail()]);
        $pic_code = $code[0];
        $pic_name = $rs_reg[0][$transactionRegistration->getDelegationName()];
        $pic_email = $rs_reg[0][$transactionRegistration->getDelegationEmail()];

        $mail = new PHPMailer;
        try {
            $mail->isSMTP();
//            echo MAIL_USERNAME . '-' . MAIL_PASSWORD;
//            $mail->Debugoutput = 'html';
//            $mail->SMTPDebug = 2;
            $mail->Host = MAIL_HOST;

            $mail->Port = MAIL_SMTP_PORT;
            $mail->SMTPSecure = MAIL_SMTPSECURE;
            $mail->SMTPAuth = MAIL_SMTPAUTH;
//        $mail->SMTPAutoTLS = ['ssl'=> ['allow_self_signed' => true]];

            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;



            $mail->isHTML(true);

//Set who the message is to be sent from
            $mail->setFrom(MAIL_USERNAME, MAIL_FULLNAME);

//Set an alternative reply-to address
            $mail->addReplyTo($pic_email, $pic_name);

//Set who the message is to be sent to
            $mail->addAddress($pic_email, $pic_name);
            $img_logo_tala = 'http://54.251.168.102/e-portal/contents/logo-kecil.png';
            $mail->Subject = 'Approval Registrasi Pusbang BKN';
            $mail->Body = '<div style="border-style: solid;border-width: thin;font-family: \'Roboto\';">
                      <div align="center" style="margin:15px;"><img src="' . $img_logo_tala . '" width="120" height="40"/></div>
                        <div align="left" style="margin:15px;">
                            Kepada Yang Terhormat ' . $pic_name . ',
                        <br/><br/>
                       <p>
                            Pendaftaran Kegiatan anda <b>Tidak Disetujui</b> dengan Catatan:
                            <br/><br/>
                            ' . $_POST['message'] . '
                            <br/>
                       </p>
                        <br/>
                        <br/>
                        Terima Kasih telah mendaftar di Pusbang ASN
                        <br/><a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                        </div>
                        </div>
                            ';
            if ($mail->smtpConnect()) {
                $mail->smtpClose();
                if (!$mail->send()) {
                    LOGGER($mail->ErrorInfo);
                    return false;
                } else {
                    return true;
                }
            } else {
                LOGGER("Error Connect SMTP");
                return false;
            }
        } catch (\Exception $e) {
            LOGGER($e->getMessage());
            return false;
        }
    }

    public function sendMailUserFromRegistration() {
        $approvalCategoryId = $_POST['approval_category_id'];
        $registrationId = $_POST['registration_id'];
        $transactionRegistration = new TransactionRegistration();
        $masterApproval = new MasterApproval();
        $db = new Database();
        $db->connect();
        $rs_reg = $db->selectByID($transactionRegistration, $transactionRegistration->getId() . equalToIgnoreCase($registrationId));
        $rs_approve = $db->selectByID($masterApproval, $masterApproval->getApprovalDetailId() . EQUAL . $registrationId . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . $approvalCategoryId);
        $code = explode('@', $rs_reg[0][$transactionRegistration->getDelegationEmail()]);
        $pic_code = $code[0];
        $pic_name = $rs_reg[0][$transactionRegistration->getDelegationName()];
        $pic_email = $rs_reg[0][$transactionRegistration->getDelegationEmail()];

        $mail = new PHPMailer;
        try {
            $mail->isSMTP();
//            echo MAIL_USERNAME . '-' . MAIL_PASSWORD;
//            $mail->Debugoutput = 'html';
//            $mail->SMTPDebug = 2;
            $mail->Host = MAIL_HOST;

            $mail->Port = MAIL_SMTP_PORT;
            $mail->SMTPSecure = MAIL_SMTPSECURE;
            $mail->SMTPAuth = MAIL_SMTPAUTH;
//        $mail->SMTPAutoTLS = ['ssl'=> ['allow_self_signed' => true]];

            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;



            $mail->isHTML(true);

//Set who the message is to be sent from
            $mail->setFrom(MAIL_USERNAME, MAIL_FULLNAME);

//Set an alternative reply-to address
            $mail->addReplyTo($pic_email, $pic_name);

//Set who the message is to be sent to
            $mail->addAddress($pic_email, $pic_name);
            $img_logo_tala = 'http://54.251.168.102/e-portal/contents/logo-kecil.png';
            $mail->Subject = 'Approval Registrasi Pusbang BKN';
            $mail->Body = '<div style="border-style: solid;border-width: thin;font-family: \'Roboto\';">
                      <div align="center" style="margin:15px;"><img src="' . $img_logo_tala . '" width="120" height="40"/></div>
                        <div align="left" style="margin:15px;">
                            Kepada Yang Terhormat ' . $pic_name . ',
                        <br/><br/>
                       <p>
                            Pendaftaran Kegiatan anda telah disetujui, 
                            Anda bisa melakukan pendaftaran peserta menggunakan username dan password dibawah ini:
                            <br/><br/>Username : <b>' . $pic_code . '</b>
                            <br/>Password : <b>' . $pic_code . '</b>
                            <br/><br/>
                            Silahkan klik link dibawah ini untuk menuju kehalaman Portal Pusbang ASN,
                            <br/>
                            <a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                       </p>
                        <br/>
                        <br/>
                        Terima Kasih telah mendaftar di Pusbang ASN
                        <br/><a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                        </div>
                        </div>
                            ';
            if ($mail->smtpConnect()) {
                $mail->smtpClose();
                if (!$mail->send()) {
                    return false;
//                    $this->rollBackApproval();
//                    echo $mail->ErrorInfo;
//                    LOGGER('GAgAL kirim Email');
                    LOGGER($mail->ErrorInfo);
//                    echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
//                    echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit-registration') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
                } else {
                    return true;
//                    echo toastAlert('success', lang('general.title_approved_success'), lang('general.message_approved_success'));
//                    echo '<script>$(function () {$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
//                    return 1;
                }
            } else {
                return false;
                LOGGER("Error Connect SMTP");
//                $this->rollBackApproval();
//                echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
//                echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit-registration') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
//                return 0;
            }
        } catch (\Exception $e) {
            return false;
//            LOGGER('GAgAL kirim Email');
            LOGGER($e->getMessage());
//            $this->rollBackApproval();
//            echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
//            echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit-registration') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
//            echo $e->getMessage(); //Boring error messages from anything else!
        }
    }

    public function rollBackApproval($type = 1) {
        $approvalCategoryId = $_POST['approval_category_id'];
        $registrationId = $_POST['registration_id'];
        $transactionRegistration = new TransactionRegistration();
        $masterApproval = new MasterApproval();
        $securityUser = new SecurityUser();
        $db = new Database();
        $db->connect();
        $rs_reg = $db->selectByID($transactionRegistration, $transactionRegistration->getId() . equalToIgnoreCase($registrationId));
        $code = explode('@', $rs_reg[0][$transactionRegistration->getDelegationEmail()]);
        if ($type == 1) {
            $db->delete($securityUser->getEntity(), $securityUser->getCode() . equalToIgnoreCase($code[0]));
            $rs_del = $db->getResult();
        }
        $db->update($masterApproval->getEntity(), array(
            $masterApproval->getStatus() => null,
            $masterApproval->getModifiedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
            $masterApproval->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                ), $masterApproval->getApprovalDetailId() . EQUAL . $registrationId . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . $approvalCategoryId);
        return $db->getResult();
    }

    public function rejectData($activity_id) {
        $masterWaitingList = new MasterWaitingList();
        $masterApproval = new MasterApproval();
        $transactionRegistration = new TransactionRegistration();
        $db = new Database();
        $db->connect();
        $approvalCategoryId = $_POST['approval_category_id'];
        $message = $_POST['message'];
        $id = $_POST['id'];
        if ($approvalCategoryId == 3) {

            $userMainId = $_POST['user_main_id'];

            $rs_approve = $db->selectByID($masterApproval, $masterApproval->getApprovalDetailId() . EQUAL . $id . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . $approvalCategoryId);

            $db->update($masterWaitingList->getEntity(), array(
                $masterWaitingList->getApprovedBy() => $_SESSION[SESSION_ADMIN_USERNAME],
                $masterWaitingList->getIsApproved() => 0,
                $masterWaitingList->getApprovedMessage() => $message,
                $masterWaitingList->getApprovedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                    ), $masterWaitingList->getId() . EQUAL . $id);
            $result = $db->getResult();
            if ($result[0] == 1) {
                $db->update($masterApproval->getEntity(), array(
                    $masterApproval->getStatus() => 0,
                    $masterApproval->getModifiedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
                    $masterApproval->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                        ), $masterApproval->getApprovalDetailId() . EQUAL . $id . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . "3");
                $result_2 = $db->getResult();
                if ($result_2[0] == 1) {
                    $securityUser = new SecurityUser();
                    $securityUserProfile = new SecurityUserProfile();
                    $masterUserMain = new MasterUserMain();
//                    $transactionActivity = new TransactionActivity();

                    $rs_user_admin = $db->selectByID($securityUser, $securityUser->getCode() . equalToIgnoreCase($_SESSION[SESSION_ADMIN_USERNAME]));
                    $rs_user_profile_admin = $db->selectByID($securityUserProfile, $securityUserProfile->getUserId() . equalToIgnoreCase($rs_user_admin[0][$securityUser->getId()]));


                    $rs_user_main = $db->selectByID($masterUserMain, $masterUserMain->getId() . equalToIgnoreCase($userMainId));

                    $rs_user_profile = $db->selectByID($securityUserProfile, $securityUserProfile->getId() . equalToIgnoreCase($rs_user_main[0][$masterUserMain->getUserProfileId()]));

                    $img_logo = IMAGE_ICON_EMAIL_URL;
                    $subject = 'Approval Registrasi Pusbang BKN';
                    $body = '<div style="border-style: solid;border-width: thin;font-family: \'Roboto\';">
                      <div align="center" style="margin:15px;"><img src="' . $img_logo . '" width="120" height="40"/></div>
                        <div align="left" style="margin:15px;">
                            Kepada Yang Terhormat ' . $rs_user_profile[0][$securityUserProfile->getName()] . ',
                        <br/><br/>
                       <p>
                            Pendaftaran Kegiatan anda <b>Tidak Disetujui</b> dengan Catatan:
                            <br/><br/>
                            ' . $_POST['message'] . '
                            <br/>
                       </p>
                        <br/>
                        <br/>
                        Terima Kasih telah mendaftar di Pusbang ASN
                        <br/><a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                        </div>
                        </div>
                            ';
                    $code_notif = createRandomBooking();
                    $masterNotification = new MasterNotification();
                    $db->insert($masterNotification->getEntity(), array(
                        $masterNotification->getCode() => $code_notif,
                        $masterNotification->getName() => $subject,
                        $masterNotification->getTitle() => $subject,
                        $masterNotification->getMessage() => $body,
                        $masterNotification->getFrom() => $rs_user_profile_admin[0][$securityUserProfile->getId()],
                        $masterNotification->getTo() => $rs_user_profile[0][$securityUserProfile->getId()],
                        $masterNotification->getDate() => date(DATE_FORMAT_PHP_DEFAULT),
                    ));

                    $rs_insert_notif = $db->getResult();
                    if (is_numeric($rs_insert_notif[0])) {
                        echo toastAlert('success', lang('general.title_rejected_success'), lang('general.message_rejected_success'));
                        echo '<script>$(function () {$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
                    } else {
                        echo toastAlert('error', lang('general.title_rejected_error'), lang('general.message_rejected_error'));
                        echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
                    }
                } else {
                    $this->rollBackApproval(0);
                    echo toastAlert('error', lang('general.title_rejected_error'), lang('general.message_rejected_error'));
                    echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
                }
            } else {
                $this->rollBackApproval(0);
                echo toastAlert('error', lang('general.title_rejected_error'), lang('general.message_rejected_error'));
                echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
            }
        } else if ($approvalCategoryId == 1) {
            $registrationId = $_POST['registration_id'];
            $db->update($transactionRegistration->getEntity(), array(
                $transactionRegistration->getIsApproved() => 0,
                $transactionRegistration->getApprovedBy() => $_SESSION[SESSION_ADMIN_USERNAME],
                $transactionRegistration->getApprovedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                $transactionRegistration->getApprovedMessage() => $message,
                    ), $transactionRegistration->getId() . equalToIgnoreCase($registrationId));
            $rs_update_reg = $db->getResult();
            if (is_numeric($rs_update_reg[0]) == 1) {
                $rs_approve = $db->selectByID($masterApproval, $masterApproval->getApprovalDetailId() . EQUAL . $id . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . $approvalCategoryId);
                $db->update($masterApproval->getEntity(), array(
                    $masterApproval->getStatus() => 0,
                    $masterApproval->getModifiedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
                    $masterApproval->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                        ), $masterApproval->getId() . EQUAL . $id . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . $approvalCategoryId);
//            echo $db->getSql();
                $result_2 = $db->getResult();
//            print_r($result_2);
                if ($result_2[0] == 1) {
                    $send_mail = $this->sendMailRejectData();
                    if ($send_mail == true) {
                        echo toastAlert('success', lang('general.title_rejected_success'), lang('general.message_rejected_success'));
                        echo '<script>$(function () {$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
                    } else {
                        $this->rollBackApproval(0);
                        echo toastAlert('error', lang('general.title_rejected_error'), lang('general.message_rejected_error'));
                        echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
                    }
                } else {
                    $this->rollBackApproval(0);
                    echo toastAlert('error', lang('general.title_rejected_error'), lang('general.message_rejected_error'));
                    echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit-registration') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
                }
            } else {
                $this->rollBackApproval(0);
                echo toastAlert('error', lang('general.title_rejected_error'), lang('general.message_rejected_error'));
                echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit-registration') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
            }
        }
    }

    public function rejectDetail($activity_id) {
//        echo $_SESSION[SESSION_ADMIN_USERNAME];
        echo '<form role="form" id="form-message-reject" class="signup" action="#" onsubmit="return false;" method="POST" novalidate="novalidate">';
        echo Form()->id('message')->title(lang('member.rejection_notes'))->placeholder('Tulis Alasan Penolakan')->textarea();
        $approvalCategoryId = $_POST['approval_category_id'];
        if ($approvalCategoryId == 3) {
            echo Button()->icon('fa fa-times')
                    ->setClass('btn btn-warning')
                    ->alertBtnMsg(lang('member.yes'))
                    ->alertMsg(lang('member.notif_rejected_candidates'))
                    ->alertTitle(lang('general.reject'))
                    ->onClick('postAjaxByAlertFormManual(this,\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/' . $activity_id . '/reject') . '\',\'form-message-reject\',\'approval_category_id=' . $approvalCategoryId . '&id=' . $_POST['id'] . '&user_main_id=' . $_POST['user_main_id'] . '\')')
                    ->label(lang('general.reject'))->buttonManual();
            echo '</form>';
        } else if ($approvalCategoryId == 1) {
            $registration_id = $_POST['registration_id'];
//            echo $registration_id;
            echo Button()->icon('fa fa-times')
                    ->setClass('btn btn-warning')
                    ->alertBtnMsg(lang('member.yes'))
                    ->alertMsg(lang('member.notif_rejected_candidates'))
                    ->alertTitle(lang('general.reject'))
                    ->onClick('postAjaxByAlertFormManual(this,\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/' . $activity_id . '/reject') . '\',\'form-message-reject\',\'approval_category_id=' . $approvalCategoryId . '&id=' . $_POST['id'] . '&registration_id=' . $registration_id . '\')')
                    ->label(lang('general.reject'))->buttonManual();
//            echo $activity_id;
        }
        echo '<script>$(function(){$(\'#modal-title-self\').html(\'' . lang('member.detail_approved_reject_candidates') . " | " . lang('member.rejection_notes') . '\')});</script>';
    }

}
