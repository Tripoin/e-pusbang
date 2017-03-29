<?php

use app\Model\MasterCategoryAssess;
use app\Model\LinkSubjectAssess;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Util\Database;

$db = new Database();
$db->connect();
$masterCategoryAssess = new MasterCategoryAssess();
$linkSubjectAssess = new LinkSubjectAssess();
$transactionActivity = new TransactionActivity();
$transactionActivityDetails = new TransactionActivityDetails();
?>

<?= $Form->formHeader(); ?>
<?php
echo Form()->formLayout(HORIZONTAL)
        ->title(lang('member.subject_name'))
        ->label($get_data[$data->getName()])
        ->labels();
?>
<?php
echo Form()->formLayout(HORIZONTAL)
        ->title(lang('member.generation'))
        ->label($get_data[$data->getGeneration()])
        ->labels();
?>
<?php
echo Form()->formLayout(HORIZONTAL)
        ->title(lang('member.execution_time'))
        ->label(subMonth($get_data[$data->getStartActivity()]) . " - " . subMonth($get_data[$data->getEndActivity()]))
        ->labels();
?>
<table border="0" id="table-manual" class="table table-striped table-bordered order-column dataTable" width="100%">
    <thead>

        <tr>
            <th style="text-align:center;width:20%;"><?= lang('member.day_of_date'); ?></th>
            <th style="text-align:center;width:15%;"><?= lang('member.time'); ?></th>
            <th style="text-align:center;width:20%;"><?= lang('member.material'); ?></th>
            <th style="text-align:center;width:8%;"><?= lang('member.lesson_time'); ?></th>
            <th style="text-align:center;width:10%;"><?= lang('member.trainer_activities'); ?></th>
            <th style="text-align:center;width:8%;"><?= lang('member.total_value'); ?></th>
        </tr>
    </thead>
    <tbody id="table-manual-body">
        <?php foreach ($this->data_activity_details as $value) { ?>
            <tr>
                <td style=""><?= fullDateString($value[$transactionActivityDetails->getStartTime()]); ?></td>
                <td style=""><?= subTimeOnly($value[$transactionActivityDetails->getStartTime()]); ?> - <?= subTimeOnly($value[$transactionActivityDetails->getEndTime()]); ?></td>
                <td><?= $value[$transactionActivityDetails->getMaterialName()]; ?></td>
                <td style="text-align:center;"><?= $value[$transactionActivityDetails->getDuration()]; ?></td>
                <td style="text-align:center;"><?= $value[$transactionActivityDetails->getUserMainName()]; ?></td>
                <td style="">
                    <a href="javascript:void(0)" 
                       onclick="postAjaxEdit(URL(), 'id=26')">8</a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<ul class="nav nav-tabs">
    <!--<li class="active"><a data-toggle="tab" href="#home">Home</a></li>-->
    <?php
    $no = 0;
    foreach ($this->data_parent_subject_assess as $data_parent) {
        $no+=1;
        $active = '';
        if ($no == 1) {
            $active = 'class="active"';
        }
        ?>
        <li <?= $active; ?>><a data-toggle="tab" href="#<?= $data_parent['id']; ?>"><?= $data_parent['name']; ?></a></li>
    <?php } ?>
</ul>
<div class="tab-content">
    <?php
    $no = 0;
    foreach ($this->data_parent_subject_assess as $data_parent) {
        $no+=1;
        $active = '';
        if ($no == 1) {
            $active = '  in active';
        }
        ?>

        <div id="<?= $data_parent['id']; ?>" class="tab-pane fade <?= $active; ?>">
            <?php
            $db->select($linkSubjectAssess->getEntity(), ""
                    . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getName() . " as name,"
                    . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getCode() . " as code,"
                    . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId() . " as id", array(
                $masterCategoryAssess->getEntity()
                    ), ""
                    . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getCategoryAssessId() . EQUAL . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId()
                    . " AND " . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getSubjectId() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getSubjectId()])
                    . " AND " . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getCategoryAssessParentId() . equalToIgnoreCase($data_parent['id'])
            );
            $data_subject_assess = $db->getResult();
            foreach ($data_subject_assess as $value) {
                echo Form()->formLayout(HORIZONTAL)
                        ->type('number')
                        ->attr('onkeyup="this.onchange()" onchange="calculateAll(' . $data_parent['id'] . ')" tripoin="number"')
                        ->id($value['id'])
                        ->name($value['code'])
                        ->title($value['name'])
                        ->value(0)
                        ->textbox();
            }
            echo Form()->formLayout(HORIZONTAL)
                    ->attr('readonly="readonly"')
                    ->id('total' . $data_parent['id'])
                    ->title(lang('general.total'))
                    ->value(0)
                    ->textbox();
            echo Form()->formLayout(HORIZONTAL)
                    ->id('average' . $data_parent['id'])
                    ->attr('readonly="readonly"')
                    ->title(lang('general.average'))
                    ->value(0)
                    ->textbox();
            ?>

        </div>
    <?php } ?>
</div>
<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
<script>
    function calculateAll(id) {
        var all = $('#' + id + ' :input[tripoin="number"]');
//        console.log($('#' + id + ' :input[tripoin="number"]'));
        var values = all
                .map(function () {
                    return $(this).val();
                }).get();

        var total = 0;
        for (var no = 0; no < values.length; no++) {
            total += parseFloat(values[no]);
        }
        var average = total / parseInt(values.length);
        $('#total' + id).val(total);
        $('#average' + id).val(average);
//      console.log(values);
//        alert("masuk");
    }
</script>