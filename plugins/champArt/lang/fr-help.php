<?php if(!defined('PLX_ROOT')) exit; ?>
<h1>Aide du plugin champArt</h1>
<div id="champart">
<fieldset>
<legend>mongroupe</legend>
<p><label for="id_champArt_monchamp">monlabel :</label> ( monchamp ) <a id="toggler_monchamp" href="javascript:void(0)" onclick="toggleDiv('toggle_monchamp', 'toggler_monchamp', 'afficher','masquer')">masquer</a>
</p>
<div id="toggle_monchamp" style="display: block; ">
<input id="id_champArt_monchamp" name="champArt_monchamp" type="text" value="ma valeur" size="66" maxlength="255">
</div>
</fieldset>

<p>
La valeur entre parenth&egrave;ses correspond au param&egrave;tre &agrave; utiliser dans l'appel du plugin ( ici <b>monchamp</b> ).
</p>

<p>
Pour afficher sur votre site la valeur de votre champ:
<blockquote><?php echo htmlentities("<?php eval(\$plxShow->callHook('champArt', 'monchamp')); ?>"); ?></blockquote>
</p>

<p>
Vous pouvez aussi r&eacute;cup&eacute;rer cette valeur sans l'afficher ( utile pour faire des tests etc ... ), pour cela rajoutez <b>_R</b> &agrave; la fin du param&egrave;tre:
ex: <blockquote><?php echo htmlentities("<?php \$monchamp = \$plxShow->callHook('champArt', 'monchamp_R')); ?>"); ?></blockquote>
</p>

<p>Un exemple d'application: si la valeur existe, j'affiche du texte:
<blockquote>
<?php echo htmlentities("<?php"); ?><br>
<?php echo htmlentities("\$monchamp = \$plxShow->callHook('champArt', 'monchamp_R'));"); ?><br>
<?php echo htmlentities("if(\$monchamp!=\"\") {"); ?><br>
<?php echo htmlentities("echo \"il existe une valeur\";"); ?><br>
<?php echo htmlentities("}"); ?><br>
<?php echo htmlentities("?>"); ?><br>
</blockquote>

<p>
Enfin, si vous souhaitez afficher votre valeur pr&eacute;c&eacute;d&eacute;e de son label, rajoutez <b>_L</b> &agrave; la fin du param&egrave;tre:
ex: <blockquote><?php echo htmlentities("<?php eval(\$plxShow->callHook('champArt', 'monchamp_L')); ?>"); ?></blockquote>
Cela affichera:<br>
monlabel: ma valeur
</p>

</div>