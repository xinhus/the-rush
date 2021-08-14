#!/bin/sh

cd ${APACHE_DOCUMENT_ROOT}/..
composer install
apache2-foreground
