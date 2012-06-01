<?php get_header() ?>
<p class="top-info"></p>
    <p class="top-info">
	Esta es la p&aacute;gina principal de las organizaciones. Desde esta
	p&aacute;gina puede administrar las organizaciones a las cuales pertenece,
	crear nuevas organizaciones o eliminarla en caso de tener los permisos. 
    </p>

 <h3>Organizaciones</h3>
<?php
        $i = 0;
        foreach( array ($ORGANIZACIONES_REG) as $organizacion ) {
		    if ( $organizacion ) {
    ?>

<div class="list-table-wrapper">
        <?php Message::print_all_messages() ?>
        <?php // Message::print_all_form_errors() ?>

<table class="list-table" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" class="" ><a href="">Nombre</a></th>
                <th scope="col" class="" ><span>Sector</span></th>
                <th scope="col" class="" ><span>Descripci&oacute;n</span></th>
            </tr>
        </thead>

	<tfoot>
            <tr>
                <th scope="col" class="" colspan="3" ></th>
            </tr>
        </tfoot>
	<tbody id="the-list">
<?php foreach($organizacion as $org) { ?>
<tr id="post-18" class="alternate author-self status-draft format-default iedit" valign="top">
<td class=""><?php echo $org->org_nombre ?></td>
<td class=""><?php echo $org->org_sectores ?></td>
		<td class=""><?php echo $org->org_desc ?></td>

	</td>
<?php } ?>
</tbody>
        </table>
    </div>
<?php } $i++; } ?>


		<li><a href="<?php echo base_url('organizacion/nuevo') ?>" class=""><span>Crear Organizaci&oacute;n</span></a></li>

<?php get_footer() ?>
