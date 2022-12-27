<?php

/*
 *  Write the articles page, which lists articles in chronological order.
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

$t = new Template('articles');
$t->open();
?>

<h1>Articles</h1>

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

<?php
$t->close();
?>
