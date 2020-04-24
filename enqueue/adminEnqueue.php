<?php



/**
 * Add Enqueue
 *  for admin
 */


$enqueue->headerScript('assets/js/webToast.min.js');
$enqueue->footerScriptCdn('https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js');
$enqueue->footerScript('assets/js/index.js','DemoScriptIndex');
$enqueue->csrfToken('DemoScriptIndex','corsData');
 $enqueue->footerScript('assets/js/app.js');


$enqueue->styleCdn('https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');
$enqueue->style('assets/css/style.css');


// $enqueue->hotScript('app.js') ;
