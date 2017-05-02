<div class="table-responsive">
    <table id="main-table" class="table table-hover table-bordered table-striped">
        <thead>
        <tr>
            <th>spinID</th>
            <th>betAmount</th>
            <th>wonAmount</th>
            <th>dateAdd</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($data)): ?>
            <?php foreach ($data as $item) : ?>
                <tr>
                    <td>
                        <?= $item->spinID; ?>
                    </td>
                    <td >
                        <?= $item->betAmount; ?>
                    </td>
                    <td>
                        <?= $item->wonAmount; ?>
                    </td>
                    <td>
                        <?= $item->dateAdd; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>





