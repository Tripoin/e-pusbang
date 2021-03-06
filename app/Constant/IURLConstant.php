<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Constant;

/**
 * Description of URLConstant
 *
 * @author sfandrianah
 */
interface IURLConstant {

    //put your code here
    const GROUP_INDEX_URL = '/security/group';
    //URL FUNCTION
    const FUNCTION_INDEX_URL = '/security/function';
//    const FUNCTION_CREATE_URL = 'page/security/function/create';
//    const FUNCTION_LIST_URL = 'page/security/function/list';
//    const FUNCTION_EDIT_URL = 'page/security/function/edit';
//    const FUNCTION_DELETE_URL = 'page/security/function/delete';
//    const FUNCTION_SAVE_URL = 'page/security/function/save';
//    const FUNCTION_UPDATE_URL = 'page/security/function/update';
    //FUNCTION ASSIGNMENT
    const FUNCTION_ASSIGNMENT_INDEX_URL = '/security/function-assignment';
    //URL USER 
    const USER_INDEX_URL = '/security/user';
//    const USER_CREATE_URL = 'page/security/user/create';
//    const USER_LIST_URL = 'page/security/user/list';
//    const USER_EDIT_URL = 'page/security/user/edit';
//    const USER_DELETE_URL = 'page/security/user/delete';
//    const USER_SAVE_URL = 'page/security/user/save';
//    const USER_UPDATE_URL = 'page/security/user/update';
    //URL CONFIRM_SALDO 
    const TOPUP_SALDO_INDEX_URL = 'page/approval/confirm-saldo';
    const TOPUP_SALDO_LIST_URL = 'page/approval/confirm-saldo/list';
    const TOPUP_SALDO_VIEW_URL = 'page/approval/confirm-saldo/view';
    const TOPUP_SALDO_APPROVE_URL = 'page/approval/confirm-saldo/approved';
    const TOPUP_SALDO_REJECT_URL = 'page/approval/confirm-saldo/rejected';
    //URL POSTING
    const POST_INDEX_URL = '/posting/post';
    const POST_CREATE_URL = '/posting/post/create';
    const POST_LIST_URL = '/posting/post/list';
    const POST_EDIT_URL = '/posting/post/edit';
    const POST_DELETE_URL = '/posting/post/delete';
    const POST_SAVE_URL = '/posting/post/save';
    const POST_UPDATE_URL = '/posting/post/update';
    const POST_DELETE_COLLECTION_URL = '/posting/post/deleteCollection';
    //URL POSTING ASSIGNMENT
    const POST_ASSIGN_INDEX_URL = '/posting/post-assign';
    const POST_ASSIGN_CREATE_URL = '/posting/post-assign/create';
    const POST_ASSIGN_LIST_URL = '/posting/post-assign/list';
    const POST_ASSIGN_EDIT_URL = '/posting/post-assign/edit';
    const POST_ASSIGN_DELETE_URL = '/posting/post-assign/delete';
    const POST_ASSIGN_SAVE_URL = '/posting/post-assign/save';
    const POST_ASSIGN_UPDATE_URL = '/posting/post-assign/update';
    const POST_ASSIGN_DELETE_COLLECTION_URL = '/posting/post-assign/deleteCollection';
    const POST_ASSIGN_LIST_POST = '/posting/post-assign/list-post';
    //URL MASTER BANK ASSIGNMENT
    const MASTER_BANK_INDEX_URL = 'master/bank';
    const MASTER_BANK_ACCOUNT_INDEX_URL = 'master/bank-account';
    const MASTER_LANGUAGE_INDEX_URL = 'master/language';
    const MASTER_VIDEO_SEMINAR_INDEX_URL = 'master/video-seminar';
    const MASTER_AUTHOR_INDEX_URL = 'master/author';
    const MASTER_PRICE_INDEX_URL = 'master/price';
    const MASTER_ROOM_INDEX_URL = '/master/room';
    const MASTER_FACILITY_INDEX_URL = '/master/facility';
    const MASTER_SUPPORT_ROOM_INDEX_URL = '/master/support-room';
    const MASTER_ANSWER_CATEGORY_INDEX_URL = '/master/answer-category';
    const MASTER_ANSWER_TYPE_INDEX_URL = '/master/answer-type';
    const MASTER_CATEGORY_ASSESS_INDEX_URL = '/master/category-assess';
    const MASTER_CITY_INDEX_URL = '/master/city';
    const MASTER_QUESTION_CATEGORY_INDEX_URL = '/master/question-category';
    const DOCUMENTATION_INDEX_URL = '/documentation';
    const MASTER_SLIDER_INDEX_URL = '/master/slider';
    const AGENDA_KEGIATAN_INDEX_URL = '/agenda-kegiatan';
    const MASTER_SUBJECT_INDEX_URL = '/master/subject';
    const MASTER_SUBJECT_REQUIREMENTS_INDEX_URL = '/master/subject-requirements';
    const MASTER_MATERIAL_SUBJECT_INDEX_URL = '/master/material-subject';

    /**/
    const APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL = '/approval/participant-registration';
    const APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL = '/approval/activity-registration';
    const APPROVAL_PIC_REGISTRATION_INDEX_URL = '/approval/pic-registration';
    const APPROVAL_REQUEST_AKD_INDEX_URL = '/approval/request-akd';

    const SURVEY_TRAINER_INDEX_URL = '/survey/survey-trainer';
    const SURVEY_ORGANIZER_INDEX_URL = '/survey/survey-organizer';
    
    /*REGISTRATION ADMIN*/
    const REGISTRATION_INTERNAL_INDEX_URL = '/registration/internal';
    const REGISTRATION_INTERNAL_ACTIVITY_INDEX_URL = '/registration/internal-activity';
}
