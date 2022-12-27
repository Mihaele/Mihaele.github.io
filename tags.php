<?php

/*
 *  Write the tags page, where articles are grouped by tags.
 */

require_once('includes/BlogArticle.php');
require_once('includes/Template.php');

$articles = BlogArticle::LoadAll();
$tags = [];
$max_tag = 0;
foreach ($articles as $article) {
    foreach ($article->tags as $article_tag) {
        if (!(isset($tags[$article_tag]))) {
            $tags[$article_tag] = [];
        }
        $tags[$article_tag][] = $article;
        $max_tag = max($max_tag, count($tags[$article_tag]));
    }
}

$t = new Template('tags');
$t->open();
?>

<h1>Tags</h1>

<?php foreach ($tags as $tag => $articles): ?>
    <h3><?php echo htmlentities(strtoupper($tag)); ?> <a class="anchor" name="<?php echo htmlentities($tag); ?>"></a></h3>
    <ul>
        <?php foreach ($articles as $article): ?>
            <li>
                <span class="date"><?php echo htmlentities($article->date('M j, Y')); ?></span>
                <a href="<?php echo $t->url($article->link); ?>">
                    <?php echo htmlentities($article->title); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>

<?php
$t->close();
?>
