<?php

/**
 * This is the new location that reports will be ported to. This file will act as the main controller to loading in multiple modules.
 * 
 * This is the first step in breaking up the speghetti code that is the maker-faire-forms directory.
 * To start, we'll create a new button that will sync editorial comments with JDB. Over time as we improve things, we'll be moving the reporting tools to this directory.
 */


// Get the editorial comments sync module
include_once( 'modules/editorial-comments.php' );