.PHONY: dist build clean article

PHP_DIST := $(patsubst %.php,docs/%.html,$(wildcard *.php))
ARTICLE_DIST := $(patsubst articles/%.html,docs/articles/%.html,$(wildcard articles/*.html))

RESOURCES_FILES := $(wildcard resources/*.css) $(wildcard resources/*.jpg) $(wildcard resources/*.js) $(wildcard resources/*.png)
RESOURCES_DIST := $(patsubst resources/%,docs/resources/%,$(RESOURCES_FILES))

CNAME_DIST := docs/CNAME

dist: build

build: $(PHP_DIST) $(ARTICLE_DIST) $(RESOURCES_DIST) $(CNAME_DIST)

clean:
	rm -rf docs

article:
	mkdir -p articles
	php -f scripts/CreateBlogArticle.php

docs/%.html: %.php
	mkdir -p $(dir $@)
	php $^ > $@

docs/articles/%.html: articles/%.json
	mkdir -p $(dir $@)
	php -f scripts/ProcessBlogArticle.php $^ > $@

docs/resources/%: resources/%
	mkdir -p $(dir $@)
	cp $^ $@

docs/CNAME:
	mkdir -p $(dir $@)
	echo -n "blog.mihaele.dev" > $@
