<?php

require_once('Template.php');
$t = Template::Get();

?><!DOCTYPE html>
<html>
    <head>
        <title>blog.mihaele.dev</title>
        <link rel="stylesheet" href="<?php echo $t->url('resources/reset.css'); ?>">
        <link rel="stylesheet" href="<?php echo $t->url('resources/blog.css'); ?>">
    </head>
    <body>
        <header>
            <div class="id"><a href="<?php echo $t->url('index.html'); ?>">blog.mihaele.dev</a></div>
            <ul class="links">
                <li><a href="<?php echo $t->url('articles.html'); ?>">Articles</a></li>
                <li><a href="<?php echo $t->url('tags.html'); ?>">Tags</a></li>
                <li><a class="external" href="https://github.com/mihaele">Code</a></li>
            </ul>
        </header>
        <main class="page page-<?php echo $t->type(); ?>">
            