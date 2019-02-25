<div class="col-md-2 folder_dynamic" style="margin-bottom:15px;" data-id="<?= $v['id'] ?>" id="folder_dynamic_<?= $v['id'] ?>">
    <div class="row folder_dynamic_items" title="<?= $v['name'] ?>" data-id="<?= $v['id'] ?>">
        <div class="col-md-2 col-sm-2 col-xs-2"><i class="<?= $v['icon'] ?>" style="font-size: 25pt;color: #9b9b9b;"></i></div>
        <div class="col-md-10 col-sm-10 col-xs-10" style="line-height: 40px;"><?= \cpn\chanpan\utils\CNUtils::lengthName($v['name']) ?></div>
    </div>
</div>