<?php

/*
 *  JSON metadata files are passed to this script in the first argument.
 *  Load the associated article and write its HTML file.
 */
 
require_once('includes/Template.php');
require_once('includes/BlogArticle.php');

$article = BlogArticle::LoadFromJsonFile($argv[1]);

$t = new Template('article', 1);
$t->open();
?>

<?php if ($article->hasDate()): ?>
    <p class="date"><?php echo $article->date('F j, Y'); ?></p>
<?php endif; ?>

<h1><?php echo $article->title; ?></h1>

<?php if (!(empty($article->subtitle))): ?>
    <h2><?php echo $article->subtitle; ?></h2>
<?php endif; ?>

<?php echo $article->contents; ?>

<ul class="tags">
    <?php foreach ($article->tags as $tag): ?>
        <li><a href="<?php echo $t->url('tags.html#' . $tag); ?>"><?php echo htmlentities(strtoupper($tag)); ?></a></li>
    <?php endforeach; ?>
</ul>

<?php
$t->close();
?>
