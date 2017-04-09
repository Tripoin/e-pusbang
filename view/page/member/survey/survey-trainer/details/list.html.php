
<?php
use app\Constant\IURLMemberConstant;

$Datatable->createButton(false);
//$Datatable->headerButton(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "","text-align:center;width:100px;","", "","text-align:center;width:100px;","text-align:center;width:100px;", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), 
    lang("transaction.day/date"),
    lang("transaction.time"),
    lang("transaction.material"),
    lang("transaction.lesson_time"),
    lang("transaction.trainer")
));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {
    if (!empty($value)) {
        $startTime = date('h:i', strtotime($value[$activityDetails->getStartTime()]));
        $endTime = date('h:i', strtotime($value[$activityDetails->getEndTime()]));
   
        $Datatable->body(array(
            $no,
            fullDateString($value[$activityDetails->getStartTime()]),
            $startTime." - ".$endTime,
            $value[$activityDetails->getMaterialName()],
            $value[$activityDetails->getDuration()],
            '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . URL(IURLMemberConstant::SURVEY_TRAINER_URL . '/detail/survey') . '\',\'id=' . $value[$data->getId()] . '&id_activity=' . $_POST['id'].'\')">' . $value[$activityDetails->getUserMainName()] . '</a>',
            ));
        $no += 1;
    }
}

echo $Datatable->show();
?>
<script>
    $(function () {
        $('.portlet-title > div > span').html('<?= lang('transaction.activity_details'); ?>');
        initDetails();
        initPage();
    });
    function initDetails() {
        $('#actionHeader').html(comButtonBack('<?= lang('general.back'); ?>', 'btn btn-danger', 'fa fa-back'));
        //$('#buttonBack').attr("onclick", "pageParent()");
        $('#list_search_by').attr("class", "input-sm input-xsmall input-inline");
        $('#search_pagination').attr("class", "form-control");
        $('#search_pagination').attr("style", "height:18px;");
        $('.pagination').attr("style", "margin-top:0");
    }
</script>
<!--<script>location.reload(true);</script>-->
