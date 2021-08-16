<div class="input-daterange input-group">
    <input type="text"
           class="input-sm form-control"
           value="<?= Yii::$app->request->getQueryParam('start') ?>"
           placeholder="start date"
           autocomplete="off"
           name="start"/>
    <span class="input-group-addon">to</span>
    <input type="text"
           placeholder="end date"
           autocomplete="off"
           class="input-sm form-control"
           value="<?= Yii::$app->request->getQueryParam('end') ?>"
           name="end"/>
</div>
