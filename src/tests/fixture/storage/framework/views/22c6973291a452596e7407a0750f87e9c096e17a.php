<?php if(Session::has('status')): ?>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-dismissable alert-<?php echo e(Session::get('status')); ?>">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <?php if(Session::has('message')): ?>
                    <p><?php echo Session::get('message'); ?></p>
                <?php endif; ?>

            </div>
        </div>
    </div>

<?php endif; ?>

<?php if( (isset($errors) && count($errors) > 0) ): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-dismissable alert-error">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <p><?php echo $message; ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row" id="messageAlert">
    <div class="col-md-12">
        <div class="alert alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p></p>
        </div>
    </div>
</div>
