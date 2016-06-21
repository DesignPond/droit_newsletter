<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-6">
        <h3>Liste des newsletter</h3>
    </div>
    <div class="col-md-6 text-right">
        <a href="<?php echo e(url('build/newsletter/create')); ?>" class="btn btn-success" id="addNewsletter"><i class="fa fa-plus"></i> &nbsp;Newsletter</a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <?php if(!$newsletters->isEmpty()): ?>
            <?php foreach($newsletters as $newsletter): ?>

                <div class="panel panel-info">
                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-7">
                                <h3><?php echo e($newsletter->titre); ?></h3>
                            </div>
                            <div class="col-md-3">
                                <p><i class="fa fa-user"></i> &nbsp; <?php echo e($newsletter->from_name); ?></p>
                                <p><i class="fa fa-envelope"></i> &nbsp; <?php echo e($newsletter->from_email); ?></p>
                            </div>
                            <div class="col-md-2 text-right">
                                <div class="btn-group-vertical" role="group">
                                    <a href="<?php echo e(url('build/newsletter/'.$newsletter->id)); ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> &nbsp;Editer</a>
                                    <a href="<?php echo e(url('build/campagne/create/'.$newsletter->id)); ?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> &nbsp;Campagne</a>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <?php if(!$newsletter->campagnes->isEmpty()): ?>
                                    <table class="table table-bordered table-striped">
                                       <thead>
                                           <tr>
                                               <th class="col-md-2">Sujet</th>
                                               <th class="col-md-3">Auteurs</th>
                                               <th class="col-md-1">Status</th>
                                               <th class="col-md-3"></th>
                                               <th class="col-md-2"></th>
                                               <th class="col-md-1"></th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                            <?php foreach($newsletter->campagnes as $campagne): ?>
                                                <tr>
                                                    <td><strong><a href="<?php echo e(url('build/campagne/'.$campagne->id.'/edit')); ?>"><?php echo e($campagne->sujet); ?></a></strong></td>
                                                    <td><?php echo e($campagne->auteurs); ?></td>
                                                    <td>
                                                        <?php if($campagne->status == 'brouillon'): ?>
                                                            <span class="label label-default">Brouillon</span>
                                                        <?php else: ?>
                                                            <span class="label label-success">Envoyé</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-sm" href="<?php echo e(url('build/campagne/'.$campagne->id)); ?>">Composer</a>
                                                            <?php if($campagne->status == 'envoyé'): ?>
                                                                <a class="btn btn-primary btn-sm" href="<?php echo e(url('build/statistics/'.$campagne->id)); ?>">Stats</a>
                                                                <a href="javascript:;" class="btn btn-default btn-sm sendEmailNewsletter" data-campagne="<?php echo e($campagne->id); ?>">Envoyer par email</a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if($campagne->status == 'brouillon'): ?>
                                                            <form action="<?php echo e(url('build/campagne/send')); ?>" id="sendCampagneForm" method="POST">
                                                                <?php echo csrf_field(); ?>

                                                                <input name="id" value="<?php echo e($campagne->id); ?>" type="hidden">
                                                                <a href="javascript:;" data-campagne="<?php echo e($campagne->id); ?>" class="btn btn-sm btn-warning btn-block" id="bootbox-demo-3">
                                                                    <i class="fa fa-exclamation"></i> &nbsp;Envoyer la campagne
                                                                </a>
                                                            </form>
                                                        <?php else: ?>
                                                            <?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>
                                                           Envoyé le <?php echo e($campagne->updated_at->formatLocalized('%d %b %Y')); ?> à <?php echo e($campagne->updated_at->toTimeString()); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <form action="<?php echo e(url('build/campagne/'.$campagne->id)); ?>" method="POST">
                                                            <input type="hidden" name="_method" value="DELETE"><?php echo csrf_field(); ?>

                                                            <button data-action="campagne <?php echo e($campagne->sujet); ?>" data-what="Supprimer" class="btn btn-danger btn-xs deleteAction"><i class="fa fa-remove"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                       </tbody>
                                    </table>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?php echo e(url('build/newsletter/'.$newsletter->id)); ?>" method="POST">
                                    <input type="hidden" name="_method" value="DELETE"><?php echo csrf_field(); ?>

                                    <button data-what="supprimer" data-action="newsletter <?php echo e($newsletter->titre); ?>" class="btn btn-xs btn-danger btn-delete deleteAction">Supprimer la newsletter</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('newsletter::Backend.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>