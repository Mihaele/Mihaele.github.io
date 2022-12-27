<?php

/*
 *  Write the index page.
 */

require_once('includes/Template.php');

$t = new Template('index');
$t->open();
?>

<h1>Welcome!</h1>

<p>My name is Ken.  You have reached my personal blog.</p>

<p>I tend to write about things that interest or affect me.  I work in <a href="<?php echo $t->url('tags.html#it'); ?>">IT</a> and I <a href="<?php echo $t->url('tags.html#programming'); ?>">code</a> for fun, so there is likely to be a heavy emphasis on technical topics.  You have been warned.</p>

<p>I'm trying to live a healthier lifestyle.  This blog is an effort to keep me accountable to myself.  It's a constant struggle, but I'm working on <a href="<?php echo $t->url('tags.html#cooking'); ?>">eating healthy</a> and <a href="<?php echo $t->url('tags.html#exercise'); ?>">getting regular exercise</a>.</p>

<p>I also like to document <a href="<?php echo $t->url('tags.html#life'); ?>">slices of life</a> from time to time.</p>

<p>You can also find me on:</p>
<ul>
    <li><a href="https://github.com/mihaele">GitHub</a></li>
</ul>

<?php
$t->close();
?>
