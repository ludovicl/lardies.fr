<?php if(!defined('PLX_ROOT')) exit; ?>

<h2>Aide</h2>
<p>Fichier d'aide du plugin Artgalerie</p>

<p>&nbsp;</p>
<h3>Installation</h3>
<P>Pour que ce plugin fonctionne correctement, vous devez avoir pr&eacute;alablement install&eacute; et activ&eacute; le <b>plugin Jquery</b></P>
<p>&nbsp;</p>
<p>
	Dans votre r&eacute;pertoire d'images (par d&eacute;faut: data/images), cr&eacute;ez un r&eacute;pertoire racine (exemple: <i>Photos</i>).<BR />
	Dans le r&eacute;pertoire <i>Photos</i>, cr&eacute;ez un sous-r&eacute;pertoire par galerie (exemple: <i>galerie01, galerie02</i>), qui contiendrons vos images.<BR />
</p>
<p>&nbsp;</p>
<p>
	Dans la configuration du plugin, sp&eacute;cifiez le nom du r&eacute;pertoire racine (<i>Photos</i>)
</p>
<p>&nbsp;</p>
<p>Les images doivent être d&eacute;pos&eacute;es via le m&eacute;dia manager. Sinon pensez &agrave; "recr&eacute;er les miniatures"</p>

<p>&nbsp;</p>

<h3>Utilisation dans les articles</h3>
<p>
	Editez le template de vos articles (article.php). Ajoutez y le code suivant &agrave; l'endroit où vous souhaitez voir apparaitre la
	galerie:</p>
<pre>
	&lt;?php eval($plxShow->callHook('ArtgalerieDisplay')); ?&gt;
</pre>
<p>
	Dans la page d'&eacute;dition de vos article, il y &agrave; un nouveau champs "Galerie" dans la sidebar. Indiquez y le nom du sous r&eacute;pertoire 
	de votre galerie (<i>galerie01</i>).</p>

<p>&nbsp;</p>

<h3>Utilisation dans une page statique</h3>
<h4>Affichage simple d'une galerie</h4>
<p>Dans une page statique ajoutez le code suivant:</p>
<pre>
	&lt;?php
		global $plxShow;
		
		eval($plxShow->callHook('ArtgalerieDisplay', 'galerie01'));
	?&gt;
</pre>
<p>
	Le deuxième argument de callHook est le nom du sous r&eacute;pertoire de votre galerie (<i>galerie01</i>).
</p>
<p>&nbsp;</p>
<p>
	Vous pouvez appeler plusieurs fois le hook dans une m&ecirc;me page, en changeant le nom de la galerie.
</p>

<p>&nbsp;</p>
<h4>Exemple de page statique:</h4>

<pre>
	&lt;p&gt;Page statique-1&lt;/p&gt;
	
	&lt;p&gt;Premiere galerie&lt;/p&gt;
	&lt;?php
		global $plxShow;
		
		eval($plxShow->callHook('ArtgalerieDisplay', 'demo1'));
	?&gt;
	
	&lt;p&gt;Deuxieme galerie&lt;/p&gt;
	&lt;?php
		eval($plxShow->callHook('ArtgalerieDisplay', 'demo2'));
	?&gt;
</pre>

<h4>Afficher les galeries sous formes d'icone</h4>

<p>Dans le répertoire racine de vos galeries, (<i>data/images/photos</i>), créez un répertoire (ex <i>galeries</i>) contenant vos sous-galeries (<i>galerie01</i>, <i>galerie02</i>).
Cela vous donne l'arborescence suivante:
<pre>
 data/images/photos/galeries
 data/images/photos/galeries/galerie01
 data/images/photos/galeries/galerie02
 ...
 </pre>
</p>
<p>Dans une page statique ajoutez le code suivant:</p>
<pre>
	&lt;?php
		global $plxShow;
		
		eval($plxShow->callHook('staticGalerieShow', 'galeries'));
	?&gt;
</pre>
<p>Le deuxième argument est le répertoire qui contient toute vos galeries (<i>galeries</i>).</p>
<p>&nbsp;</p>
<p>La liste des galeries s'affichera sous forme d'icone.</p>

<h3>Ajout d'un thème</h3>
<p>Les thèmes sont situés dans le répertoire du plugin dans le sous-répertoire "themes".</p>
<p>Le répertoire du thème doit contenir à minima 2 fichiers:
	<pre>
	head.php
	galerie.php
	</pre>
</p>
<p><b>"head.php"</b> doit contenir les déclarations qui doivent apparaitre dans l'en-tête de la page HTML (feuilles de style, javascript). Le contenu est inclus lors de l'appel du hook "ThemeEndHead".</p>
<br />
<p><b>"galerie.php"</b> est responsable de l'affichage des images. Le contenu sera affiché lors de l'appel du hook "ArtgalerieDisplay".<br />
Vous avez à votre disposion une variable "$galerie" qui est un tableau contenant les paramètres des images:</p>
<pre>
	$galerie[]['thumb']: 	Chemin de la vignette.
	$galerie[]['file']: 	Chemin de l'image pleine taille.
	$galerie[]['title']:	Description de l'image.
	$galerie[]['alt']:	Text alternatif.
</pre>
<p>N'hésitez pas à vous référer aux fichiers du thème par défaut.</p>
