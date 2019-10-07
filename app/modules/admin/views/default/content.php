<div class="portlet portlet-default">
<div class="panel-heading">
    <span id="main-frame-title"><?=Url::t('app','a list of users')?></span>
    <a href="javascript:void(0)" class="toggle-personnel-tree-sidebar pull-right" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=Url::t('app','Units menu')?>" style="display: inline;"><i class="glyphicon glyphicon-align-justify"></i></a>
    <div class="clearfix"></div>
</div>
<div class="portlet-body" id="main-frame-body" style="opacity: 1;"><div class="row">

<div class="toggle-pensonnel-list col-lg-12">
<div class="row">
    <div class="col-sm-6">
        <div id="example-table_length" class="dataTables_length">
            <label>
                <select size="1" name="personal_records_per_page">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                    <option value="50">50</option>
                </select> <?=Url::t('app','count per page')?></label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Поиск данных" id="search-personal-records" value="">
                           <span class="input-group-addon show-personal-search-results" style="cursor:pointer">
                               <i class="fa fa-search"></i>
                           </span>
        </div>
        <!--                        <a href="javascript:void(0)" style="margin: 5px 0 5px 0" class="label label-default pull-right show-advanced-search">расширенный поиск <i class="glyphicon glyphicon-chevron-right"></i></a>-->
    </div>
</div>
<div class="table-responsive">
<div id="example-table_wrapper" class="dataTables_wrapper form-inline" role="grid">
<div class="personnel-list">

<table class="table table-striped table-bordered table-hover dataTable">
<thead>
<tr role="row">
    <!--                    <th class="text-center" role="columnheader" tabindex="0" rowspan="1" colspan="1"></th>
    -->
    <th class="text-center col-sm-1" role="columnheader" tabindex="0" rowspan="1" colspan="1">
        <div class="checkbox">
            <label>
                <input type="checkbox" id="select_all_users" name="select_all_users"> 
                <br><?=Url::t('app','Choose all')?>
            </label>
        </div>
    </th>
    <th class="text-center" role="columnheader" tabindex="0" rowspan="1" colspan="1"><?=Url::t('app','Surname')?></th>
    <th class="text-center" role="columnheader" tabindex="0" rowspan="1" colspan="1"><?=Url::t('app','Name')?></th>
    <th class="text-center" role="columnheader" tabindex="0" rowspan="1" colspan="1"><?=Url::t('app','Middle name')?></th>
    <th class="text-center" role="columnheader" tabindex="0" rowspan="1" colspan="1"><?=Url::t('app','Position')?></th>
    <th class="text-center" role="columnheader" tabindex="0" rowspan="1" colspan="1"><i class="fa fa-cog"></i> <?=Url::t('app','Actions')?></th>
</tr>
</thead>
<tbody role="alert" aria-live="polite" aria-relevant="all">
<tr class="gradeU odd">
    <td class="text-center">
        <input type="checkbox" name="select[84]" id="selected-user-84" class="select-user">
    </td>
    <!--                            <td class="text-center"></td>
-->                            <td class="text-center"><?=Url::t('app','Admin')?></td>
    <td class="text-center"><?=Url::t('app','Mister')?></td>
    <td class="text-center"><?=Url::t('app','Adminovich')?></td>
    <td class="text-center"></td>
    <td class="text-center">
        <div class="btn-group btn-group-xs">
            <a class="btn btn-sm btn-success" rel="tooltip" data-toggle="tooltip" data-placement="bottom" data-original-title="<?=Url::t('app','Edit')?>" href="#users/edit/uid-84">
                <i class="glyphicon glyphicon-edit"></i>
            </a>

            <button type="button" class="btn btn-sm btn-warning" id="remove-user-84-1" data-placement="top" data-toggle="tooltip" title="" data-original-title="<?=Url::t('app','Unlock')?>">
                <i class="glyphicon glyphicon-eye-close"></i>
            </button>
            <button type="button" class="btn btn-sm btn-warning" id="remove-user-84-0" style="display:none" data-placement="top" data-toggle="tooltip" title="" data-original-title="<?=Url::t('app','Block')?>">
                <i class="glyphicon glyphicon-eye-open"></i>
            </button>
        </div>
    </td>
</tr>
</tbody>

<tfoot>
<tr>
    <td colspan="6">
        <div>
            <select name="user_actions" id="user_actions" class="form-control">
                <option value=""><?=Url::t('app','Actions with selected')?></option>
                <option value="1"><?=Url::t('app','Add to group')?></option>
            </select>
        </div>
    </td>
</tr>
</tfoot>

</table>

</div>
</div>
</div>
</div>

<!----Personnel tree list --->
<div class="personnel-tree col-lg-3">
    <div class="list-group">

    </div>
</div>
</div>

<script>
    $("[rel='tooltip']").tooltip();
</script>
</div>
</div>