<?php get_header() ?>
<p class="top-info"></p>
    <p class="top-info">
	Esta es la p&aacute;gina principal de las organizaciones. Desde esta
	p&aacute;gina puede administrar las organizaciones a las cuales pertenece,
	crear nuevas organizaciones o eliminarla en caso de tener los permisos. 
    </p>

 <h3>Organizaciones</h3>
<div class="list-table-wrapper">
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
	</td>
</tbody>
        </table>
    </div>


<?php get_footer() ?>
