<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Constant;

/**
 * Description of PathConstant
 *
 * @author sfandrianah
 */
interface IViewMemberConstant {
    
    /*LIST PARTICIPANT*/
    const LIST_PARTICIPANT_VIEW_INDEX = 'view/page/member/list-participant/index.html.php';
    const LIST_PARTICIPANT_LIST_VIEW_INDEX = 'view/page/member/list-participant/list.html.php';
    const LIST_PARTICIPANT_VIEW_VIEW_INDEX = 'view/page/member/list-participant/view.html.php';
    const LIST_PARTICIPANT_EDIT_VIEW_INDEX = 'view/page/member/list-participant/edit.html.php';
    
    /*ACTIVITY AGENDA*/
    const AGENDA_ACTIVITY_VIEW = 'view/page/member/activity-agenda';
    const ACTIVITY_VIEW_INDEX = 'view/page/member/activity-agenda/activity/activity.html.php';
    const ACTIVITY_LIST_VIEW_INDEX = 'view/page/member/activity-agenda/activity/list.html.php';
    const ACTIVITY_VIEW_VIEW_INDEX = 'view/page/member/activity-agenda/activity/view.html.php';
    const AGENDA_ORGANIZER_VIEW = 'view/page/member/agenda-organizer';
    const AGENDA_ORGANIZER_VIEW_INDEX = 'view/page/member/agenda-organizer/index.html.php';
    const AGENDA_ORGANIZER_VIEW_VIEW_INDEX = 'view/page/member/agenda-organizer/view.html.php';
    const AGENDA_ORGANIZER_LIST_VIEW_INDEX = 'view/page/member/agenda-organizer/list.html.php';
    
    
    
    /*REGISTRATION*/
    const REGISTRATION_VIEW = 'view/page/member/registration';
    const REGISTRATION_ACTIVITY_VIEW_INDEX = 'view/page/member/registration/activity/index.html.php';
    const REGISTRATION_ACTIVITY_LIST_VIEW_INDEX = 'view/page/member/registration/activity/list.html.php';
    const REGISTRATION_ACTIVITY_VIEW_VIEW_INDEX = 'view/page/member/registration/activity/view.html.php';
    const REGISTRATION_ACTIVITY_TEMP_VIEW_INDEX = 'view/page/member/registration/activity-temp/index.html.php';
    const REGISTRATION_ACTIVITY_TEMP_LIST_VIEW_INDEX = 'view/page/member/registration/activity-temp/list.html.php';
    const REGISTRATION_ACTIVITY_TEMP_VIEW_VIEW_INDEX = 'view/page/member/registration/activity-temp/view.html.php';
    const REGISTRATION_ACTIVITY_TEMP_REGISTER_VIEW_INDEX = 'view/page/member/registration/activity-temp/register-activity.html.php';
    const REGISTRATION_ACTIVITY_TEMP_LIST_USER_VIEW_INDEX = 'view/page/member/registration/activity-temp/list-user/list.html.php';
    const REGISTRATION_ACTIVITY_TEMP_LIST_USER_CREATE_VIEW_INDEX = 'view/page/member/registration/activity-temp/list-user/create.html.php';
    const REGISTRATION_ACTIVITY_TEMP_LIST_USER_ADD_VIEW_INDEX = 'view/page/member/registration/activity-temp/list-user/add/index.html.php';
    const REGISTRATION_ACTIVITY_TEMP_LIST_USER_ADD_LIST_VIEW_INDEX = 'view/page/member/registration/activity-temp/list-user/add/list.html.php';
}