<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">

            <form action="<?php echo e(url('build/newsletter')); ?>" data-validate="parsley" method="POST" enctype="multipart/form-data" class="validate-form form-horizontal">
                <?php echo csrf_field(); ?>

                <div class="panel-body">
                    <h4>Ajouter une newsletter</h4>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Titre</label>
                        <div class="col-sm-5">
                            <input type="text" required class="form-control" name="titre" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Nom de la liste</label>
                        <div class="col-sm-5">
                            <select class="form-control" required name="list_id">
                                <option value="">Choix de la liste</option>
                                <?php if(!empty($lists)): ?>
                                    <?php foreach($lists as $list): ?>
                                        <option value="<?php echo e($list->ID); ?>"><?php echo e($list->Name); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Envoyé par</label>
                        <div class="col-sm-5">
                            <input type="text" required class="form-control" name="from_name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Email d'envoi</label>
                        <div class="col-sm-5">
                            <input type="text" required class="form-control" name="from_email" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Email de retour</label>
                        <div class="col-sm-5">
                            <input type="text" required class="form-control" name="return_email" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Lien de désinscription</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo e(url('/')); ?>/</span>
                                <input type="text" required class="form-control" name="unsuscribe" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Couleur principale</label>
                        <div class="col-sm-3">
                            <input type="text" required class="form-control colorpicker" name="color" value="#556B2F">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Bannière avec logos</label>
                        <div class="col-sm-6">
                            <input type="file" required name="logos">
                            <p class="help-block">Taille max 600x130px</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Bannière de titre</label>
                        <div class="col-sm-6">
                            <input type="file" required name="header">
                            <p class="help-block">Taille max 600x160px</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Logo soutien</label>
                        <div class="col-sm-6">
                            <div class="well">
                                <input type="file" required name="soutien">
                                <p class="help-block">Taille max 105x50px</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <input type="hidden" name="preview" value="<?php echo e(url('/')); ?>">
                            <button class="btn btn-primary" type="submit">Envoyer</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('newsletter::Backend.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>