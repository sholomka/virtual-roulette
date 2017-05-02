<div class="add-task">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Сделать ставку</h4>
            </div>
            <div class="modal-body">
                <h3>Сделать ставку</h3>
                <form method="post" class="make-bet">
                    <div class="form-group">
                        <label class="control-label" for="number">Число:</label>
                        <select name="number" id="number">
                            <?php for ($i = 0; $i <= 36; $i++) : ?>
                                <option value="<?= $i; ?>"><?= $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <div class="help-block"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="amount">Сумма:</label>
                        <input type="text" required class="form-control" id="amount" name="amount">
                        <div class="help-block"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" disabled>Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>