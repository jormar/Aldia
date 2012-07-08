<?php $user = user_get_data(); ?>
<div class="click">
    <p>Bienvenido, <?php echo $user->user_nombre . ' ' . $user->user_apellido ?></p>
    <p>
        <a href="<?php echo base_url('usuario/perfil') ?>">Mi perfil</a>
        &nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('accounts/logout') ?>">Logout</a>
    </p>
</div>
<div class="clr"></div>
<div class="menu">
    <ul>
        <li><a href="<?php echo base_url('usuario') ?>" class="<?php if(preg_match('/usuario$/', current_url())) echo 'active' ?>"><span>Inicio</span></a></li>

        <?php if ( currentuser_can('crear_proy') ) { ?>
        <li><a href="<?php echo base_url('proyecto/nuevo') ?>" class="<?php if(preg_match('/proyecto\/nuevo/', current_url())) echo 'active' ?>"><span> + Proponer proyecto</span></a></li>
        <?php } ?>
    </ul>
</div>

<?php
    $org_levels = get_org_rol_levels();
    if ( $org_levels[$user->user_org_rol] <= ADMIN_LEVEL ) {
?>
<div class="menu" style="float: right">
    <ul style="text-align: right">
        <li><a href="<?php echo base_url('usuario/lista') ?>" class="<?php if(preg_match('/usuario\/lista/', current_url())) echo 'active' ?>" ><span>Usuarios</span></a></li>
        <li><a href="<?php echo base_url('comunidad') ?>" class="<?php if(preg_match('/comunidad$/', current_url())) echo 'active' ?>" ><span>La comunidad</span></a></li>
        <li><a href="<?php echo base_url('organizacion') ?>" class="<?php if(preg_match('/organizacion/', current_url())) echo 'active' ?>" ><span>Organizaciones</span></a></li>
    </ul>
</div>
<?php } ?>
