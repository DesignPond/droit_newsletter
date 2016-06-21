<?php if( (isset($errors) && $errors->has()) || Session::has('status')): ?>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-dismissable alert-<?php echo e(Session::get('status')); ?>">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <?php foreach($errors->all() as $message): ?>
                    <p><?php echo $message; ?></p>
                <?php endforeach; ?>

                <?php if(Session::has('message')): ?>
                    <p><?php echo Session::get('message'); ?></p>
                <?php endif; ?>

            </div>
        </div>
    </div>

<?php endif; ?>
